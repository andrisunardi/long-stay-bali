<?php

namespace App\Libraries;

use App\Models\Oauth;
// use Buglinjo\LaravelWebp\Webp;
use Google\Client;
use Google\Service\Drive;

// use Google\Service\Drive\DriveFile;
// use Google\Service\Drive\Permission;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;
// use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GoogleDrive
{
    public Drive $drive;

    public function __construct()
    {
        $client = new Client;

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));

        $client->addScope(Drive::DRIVE);

        $oauth = Oauth::where('code', 'GOOGLEDRIVE')->firstOrFail();
        $refreshToken = $oauth->refresh_token;

        if (! $refreshToken) {
            throw new \Exception('Google refresh token not found');
        }

        $client->setAccessToken([
            'access_token' => '',
            'refresh_token' => $refreshToken,
            'expires_in' => 0,
            'created' => time(),
        ]);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($refreshToken);
        }

        $this->drive = new Drive($client);
    }

    // public function createFolder(string $name, ?string $parentId = null): string
    // {
    //     $parentId = $parentId ?? config('services.google.root_folder');

    //     $metadata = [
    //         'name' => $name,
    //         'mimeType' => 'application/vnd.google-apps.folder',
    //         'parents' => [$parentId],
    //     ];

    //     if ($parentId) {
    //         $metadata['parents'] = [$parentId];
    //     }

    //     $folder = $this->drive->files->create(postBody: new DriveFile($metadata));

    //     return $folder->id;
    // }

    // public function renameFolder(string $folderId, string $name): void
    // {
    //     $this->drive->files->update(
    //         fileId: $folderId,
    //         postBody: new DriveFile(['name' => $name]),
    //     );
    // }

    // public function uploadImage(
    //     TemporaryUploadedFile $image,
    //     string $name,
    //     ?string $folderId = null,
    // ): string {
    //     $folderId = $folderId ?? config('services.google.root_folder');

    //     $datetime = now()->format('Y-m-d-H-i-s');
    //     $name = Str::slug($name);

    //     $name = "{$name}-{$datetime}.webp";

    //     if ($image->extension() === 'webp') {
    //         $content = $image->get();
    //     } else {
    //         $webpTmp = "webp-tmp/{$name}";

    //         Webp::make($image)->quality(70)->save(Storage::path($webpTmp));

    //         $content = Storage::get($webpTmp);
    //         Storage::delete($webpTmp);
    //     }

    //     $mimeType = 'image/webp';

    //     $image = $this->drive->files->create(
    //         new DriveFile([
    //             'name' => $name,
    //             'parents' => [$folderId],
    //         ]),
    //         [
    //             'data' => $content,
    //             'mimeType' => $mimeType,
    //             'uploadType' => 'multipart',
    //         ]
    //     );

    //     $this->drive->permissions->create($image->id, new Permission([
    //         'type' => 'anyone',
    //         'role' => 'reader',
    //     ]));

    //     return $image->id;
    // }

    // public function uploadFile(
    //     TemporaryUploadedFile $file,
    //     string $name,
    //     ?string $folderId = null,
    // ): string {
    //     $folderId = $folderId ?? config('services.google.root_folder');

    //     $datetime = now()->format('Y-m-d-H-i-s');
    //     $name = Str::slug($name);

    //     $name = "{$name}-{$datetime}.{$file->extension()}";
    //     $content = $file->get();
    //     $mimeType = $file->getMimeType();

    //     $file = $this->drive->files->create(
    //         new DriveFile([
    //             'name' => $name,
    //             'parents' => [$folderId],
    //         ]),
    //         [
    //             'data' => $content,
    //             'mimeType' => $mimeType,
    //             'uploadType' => 'multipart',
    //         ]
    //     );

    //     $this->drive->permissions->create($file->id, new Permission([
    //         'type' => 'anyone',
    //         'role' => 'reader',
    //     ]));

    //     return $file->id;
    // }

    // public function delete(string $fileId): void
    // {
    //     $this->drive->files->delete($fileId);
    // }

    public function listFiles(
        string $folderId,
        bool $isPaginate = false,
        int $pageSize = 10,
        ?string $pageToken = null
    ): array {
        $params = [
            'q' => "'{$folderId}' in parents and trashed = false and (mimeType contains 'image/' or mimeType = 'application/vnd.google-apps.folder')",
            'pageSize' => $isPaginate ? $pageSize : null,
            'fields' => 'nextPageToken, files(id, name, mimeType, thumbnailLink, size)',
            // 'orderBy' => 'name_natural',
            'supportsAllDrives' => true,
            'includeItemsFromAllDrives' => true,
            'corpora' => 'allDrives',
        ];

        if ($pageToken) {
            $params['pageToken'] = $pageToken;
        }

        $response = $this->drive->files->listFiles($params);

        return collect($response->getFiles())
            ->map(fn ($file) => [
                'id' => $file->id,
                'name' => $file->name,
                'type' => $file->mimeType === 'application/vnd.google-apps.folder'
                    ? 'folder'
                    : 'image',
                'thumbnail' => $file->thumbnailLink,
                'size' => $file->size ?? null,
            ])
            ->toArray();

        // 'nextPageToken' => $response->getNextPageToken(),
    }

    public function download(string $fileId): string
    {
        $response = $this->drive->files->get($fileId, [
            'alt' => 'media',
        ]);

        return $response->getBody()->getContents();
    }
}
