<?php

use App\Exports\OauthExport;
use App\Livewire\Component;
use App\Models\Oauth;
use App\Services\OauthService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Oauth')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search']);
    }

    public function delete(Oauth $oauth): void
    {
        $service = new OauthService();
        $service->delete(oauth: $oauth);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.oauth') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function oauths(bool $paginate = true): object
    {
        $service = new OauthService();
        $oauths = $service->index(search: $this->search, paginate: $paginate);

        return $oauths;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.oauth') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new OauthService();
        $oauths = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $oauths->loadMissing(['createdBy', 'updatedBy']);

        return Excel::download(new OauthExport(oauths: $oauths), trans('page.oauth') . '.xlsx');
    }
};
?>

@section('title', trans('page.oauth'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-search fa-fw"></span>
            {{ trans('index.search') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="d-grid gap-3">
                <div class="row g-3">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-search fa-fw "></span>
                            </div>
                            <input type="search" class="form-control" id="search" name="search" minlength="1"
                                maxlength="50" placeholder="{{ trans('field.search') }}" wire:model.lazy="search"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="button" class="btn btn-warning" wire:click="resetFilter"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="resetFilter">
                                <span class="fas fa-eraser fa-fw"></span>
                                {{ trans('index.reset_filter') }}
                            </span>
                            <span wire:loading wire:target="resetFilter" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.reset_filter') }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header text-bg-primary">
            <span class="fas fa-table fa-fw"></span>
            {{ trans('index.data') }} @yield('title')
        </div>

        <div class="card-body">
            <div class="row g-3">
                @can('oauth.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.oauth.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('oauth.export')
                    <div class="col-auto">
                        <button type="button" class="btn btn-success w-100" wire:click="export"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="export">
                                <span class="fas fa-file-excel fa-fw"></span>
                                <span>{{ trans('index.export') }}</span>
                            </span>
                            <span wire:loading wire:target="export" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>{{ trans('index.export') }}</span>
                            </span>
                        </button>
                    </div>
                @endcan
            </div>

            <hr />

            <div class="table-responsive border-bottom mb-3">
                <table class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th width="1%">{{ trans('field.code') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th width="1%">{{ trans('field.refresh_token') }}</th>
                            <th width="1%">{{ trans('field.access_token') }}</th>
                            <th width="1%">{{ trans('field.token_type') }}</th>
                            <th width="1%">{{ trans('field.expires_in') }}</th>
                            <th width="1%">{{ trans('field.scope') }}</th>
                            <th width="1%">{{ trans('field.created') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->oauths() as $oauth)
                            <tr wire:key="oauth-{{ $oauth->id }}">
                                <td class="text-center">
                                    {{ ($this->oauths()->currentPage() - 1) * $this->oauths()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false" href="{{ route('cms.oauth.detail', ['oauth' => $oauth]) }}"
                                        wire:navigate>
                                        {{ $oauth->id }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false" href="{{ route('cms.oauth.detail', ['oauth' => $oauth]) }}"
                                        wire:navigate>
                                        {{ $oauth->code }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false" href="{{ route('cms.oauth.detail', ['oauth' => $oauth]) }}"
                                        wire:navigate>
                                        {{ $oauth->name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($oauth->refresh_token)
                                        <button type="button" class="btn btn-primary btn-sm w-100"
                                            data-bs-toggle="modal" data-bs-target="#refresh-token-{{ $oauth->id }}">
                                            <span class="fas fa-folder-open fa-fw"></span>
                                            {{ trans('index.open') }}
                                        </button>

                                        <div class="modal fade" id="refresh-token-{{ $oauth->id }}" tabindex="-1">
                                            <div
                                                class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">
                                                            <span class="fas fa-file-lines fa-fw"></span>
                                                            {{ trans('page.oauth') }}
                                                            {{ trans('field.refresh_token') }}
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-pre-wrap">{!! $oauth->refresh_token !!}</div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary w-100"
                                                            data-bs-dismiss="modal">
                                                            <span class="fas fa-folder-closed fa-fw"></span>
                                                            {{ trans('index.close') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($oauth->access_token)
                                        <button type="button" class="btn btn-primary btn-sm w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#access-token-{{ $oauth->id }}">
                                            <span class="fas fa-folder-open fa-fw"></span>
                                            {{ trans('index.open') }}
                                        </button>

                                        <div class="modal fade" id="access-token-{{ $oauth->id }}"
                                            tabindex="-1">
                                            <div
                                                class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">
                                                            <span class="fas fa-file-lines fa-fw"></span>
                                                            {{ trans('page.oauth') }}
                                                            {{ trans('field.access_token') }}
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-pre-wrap">{!! $oauth->access_token !!}</div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary w-100"
                                                            data-bs-dismiss="modal">
                                                            <span class="fas fa-folder-closed fa-fw"></span>
                                                            {{ trans('index.close') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $oauth->token_type }}</td>
                                <td class="text-center">{{ $oauth->expires_in }}</td>
                                <td>{{ $oauth->scope }}</td>
                                <td class="text-center">{{ $oauth->created }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('oauth.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.oauth.detail', ['oauth' => $oauth]) }}" wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('oauth.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.oauth.edit', ['oauth' => $oauth]) }}" wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('oauth.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $oauth->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $oauth->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $oauth->id }})"
                                                    class="w-100">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="100%">
                                    {{ trans('message.no_data_available') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $this->oauths()->links('pagination') }}
        </div>
    </div>
</div>
