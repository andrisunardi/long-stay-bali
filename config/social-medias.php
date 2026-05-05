<?php

$id = 1;

return [
    [
        'id' => $id,
        'name' => 'Facebook',
        'icon' => 'fab fa-facebook',
        'username' => config('constants.social_media.facebook'),
        'link' => 'https://www.facebook.com/'.config('constants.social_media.facebook'),
    ],
    [
        'id' => $id,
        'name' => 'Instagram',
        'icon' => 'fab fa-instagram',
        'username' => config('constants.social_media.instagram'),
        'link' => 'https://www.instagram.com/'.config('constants.social_media.instagram'),
    ],
    // [
    //     'id' => $id,
    //     'name' => 'Tiktok',
    //     'icon' => 'fab fa-tiktok',
    //     'username' => config('constants.social_media.tiktok'),
    //     'link' => 'https://www.tiktok.com/@'.config('constants.social_media.tiktok'),
    // ],
    // [
    //     'id' => $id,
    //     'name' => 'Linkedin',
    //     'icon' => 'fab fa-linkedin',
    //     'username' => config('constants.social_media.linkedin'),
    //     'link' => 'https://www.linkedin.com/company/'.config('constants.social_media.linkedin'),
    // ],
];
