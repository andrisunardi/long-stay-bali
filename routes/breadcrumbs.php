<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// ERRORS 404
Breadcrumbs::for('errors.404', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.error'), null, ['icon' => 'fas fa-circle-exclamation']);
});

// LIVEWIRE MESSAGE
Breadcrumbs::for('livewire.message', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.message'), null, ['icon' => 'fas fa-message']);
});

// LIVEWWIRE UPDATE
Breadcrumbs::for('livewire.update', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.update'), null, ['icon' => 'fas fa-edit']);
});

// LIVEWIRE PREVIEW FILE
Breadcrumbs::for('livewire.preview-file', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.preview_file'), null, ['icon' => 'fas fa-photo-film']);
});

// TELESCOPE
Breadcrumbs::for('telescope', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.telescope'), null, ['icon' => 'fas fa-telescope']);
});

// HORIZON
Breadcrumbs::for('horizon.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.horizon'), null, ['icon' => 'fas fa-cloud-moon']);
});

// LOG VIEWER
Breadcrumbs::for('log-detailer.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(trans('index.log_detailer'), null, ['icon' => 'fas fa-history']);
});

// HOME
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(trans('page.home'), route('home'), ['icon' => 'fas fa-home']);
});

// ABOUT
Breadcrumbs::for('about', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('page.about'), route('about'), ['icon' => 'fas fa-building']);
});

// CONTACT
Breadcrumbs::for('contact', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('page.contact'), route('contact'), ['icon' => 'fas fa-phone']);
});

// CMS
// HOME
Breadcrumbs::for('cms.home', function (BreadcrumbTrail $trail) {
    $trail->push(trans('page.home'), route('cms.home'), ['icon' => 'fas fa-home']);
});

// MODULE
// CONTACT
Breadcrumbs::for('cms.contact.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.contact'), route('cms.contact.index'), ['icon' => 'fas fa-phone']);
});

Breadcrumbs::for('cms.contact.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.contact.index');
    $trail->push(trans('index.add'), route('cms.contact.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.contact.edit', function (BreadcrumbTrail $trail, $contact) {
    $trail->parent('cms.contact.index');
    $trail->push(trans('index.edit'), route('cms.contact.edit', $contact), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.contact.detail', function (BreadcrumbTrail $trail, $contact) {
    $trail->parent('cms.contact.index');
    $trail->push(trans('index.detail'), route('cms.contact.detail', $contact), ['icon' => 'fas fa-list']);
});

// GUIDE
Breadcrumbs::for('cms.guide.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.guide'), route('cms.guide.index'), ['icon' => 'fas fa-newspaper']);
});

Breadcrumbs::for('cms.guide.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.guide.index');
    $trail->push(trans('index.add'), route('cms.guide.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.guide.edit', function (BreadcrumbTrail $trail, $guide) {
    $trail->parent('cms.guide.index');
    $trail->push(trans('index.edit'), route('cms.guide.edit', $guide), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.guide.detail', function (BreadcrumbTrail $trail, $guide) {
    $trail->parent('cms.guide.index');
    $trail->push(trans('index.detail'), route('cms.guide.detail', $guide), ['icon' => 'fas fa-list']);
});

// GUIDE CATEGORY
Breadcrumbs::for('cms.guide-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.guide_category'), route('cms.guide-category.index'), ['icon' => 'fas fa-tags']);
});

Breadcrumbs::for('cms.guide-category.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.guide-category.index');
    $trail->push(trans('index.add'), route('cms.guide-category.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.guide-category.edit', function (BreadcrumbTrail $trail, $guide) {
    $trail->parent('cms.guide-category.index');
    $trail->push(trans('index.edit'), route('cms.guide-category.edit', $guide), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.guide-category.detail', function (BreadcrumbTrail $trail, $guide) {
    $trail->parent('cms.guide-category.index');
    $trail->push(trans('index.detail'), route('cms.guide-category.detail', $guide), ['icon' => 'fas fa-list']);
});

// PROPERTY
Breadcrumbs::for('cms.property.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.property'), route('cms.property.index'), ['icon' => 'fas fa-building']);
});

Breadcrumbs::for('cms.property.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.property.index');
    $trail->push(trans('index.add'), route('cms.property.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.property.edit', function (BreadcrumbTrail $trail, $property) {
    $trail->parent('cms.property.index');
    $trail->push(trans('index.edit'), route('cms.property.edit', $property), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.property.detail', function (BreadcrumbTrail $trail, $property) {
    $trail->parent('cms.property.index');
    $trail->push(trans('index.detail'), route('cms.property.detail', $property), ['icon' => 'fas fa-list']);
});

// PROPERTY IMAGE
Breadcrumbs::for('cms.property-image.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.property_image'), route('cms.property-image.index'), ['icon' => 'fas fa-images']);
});

Breadcrumbs::for('cms.property-image.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.property-image.index');
    $trail->push(trans('index.add'), route('cms.property-image.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.property-image.edit', function (BreadcrumbTrail $trail, $propertyImage) {
    $trail->parent('cms.property-image.index');
    $trail->push(trans('index.edit'), route('cms.property-image.edit', $propertyImage), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.property-image.detail', function (BreadcrumbTrail $trail, $propertyImage) {
    $trail->parent('cms.property-image.index');
    $trail->push(trans('index.detail'), route('cms.property-image.detail', $propertyImage), ['icon' => 'fas fa-list']);
});

// MASTER
// STANDARD
Breadcrumbs::for('cms.standard.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.standard'), route('cms.standard.index'), ['icon' => 'fas fa-clipboard-check']);
});

Breadcrumbs::for('cms.standard.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.standard.index');
    $trail->push(trans('index.add'), route('cms.standard.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.standard.edit', function (BreadcrumbTrail $trail, $standard) {
    $trail->parent('cms.standard.index');
    $trail->push(trans('index.edit'), route('cms.standard.edit', $standard), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.standard.detail', function (BreadcrumbTrail $trail, $standard) {
    $trail->parent('cms.standard.index');
    $trail->push(trans('index.detail'), route('cms.standard.detail', $standard), ['icon' => 'fas fa-list']);
});

// VALUE
Breadcrumbs::for('cms.value.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.value'), route('cms.value.index'), ['icon' => 'fas fa-gem']);
});

Breadcrumbs::for('cms.value.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.value.index');
    $trail->push(trans('index.add'), route('cms.value.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.value.edit', function (BreadcrumbTrail $trail, $value) {
    $trail->parent('cms.value.index');
    $trail->push(trans('index.edit'), route('cms.value.edit', $value), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.value.detail', function (BreadcrumbTrail $trail, $value) {
    $trail->parent('cms.value.index');
    $trail->push(trans('index.detail'), route('cms.value.detail', $value), ['icon' => 'fas fa-list']);
});

// AREA
Breadcrumbs::for('cms.area.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.area'), route('cms.area.index'), ['icon' => 'fas fa-archway']);
});

Breadcrumbs::for('cms.area.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.area.index');
    $trail->push(trans('index.add'), route('cms.area.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.area.edit', function (BreadcrumbTrail $trail, $area) {
    $trail->parent('cms.area.index');
    $trail->push(trans('index.edit'), route('cms.area.edit', $area), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.area.detail', function (BreadcrumbTrail $trail, $area) {
    $trail->parent('cms.area.index');
    $trail->push(trans('index.detail'), route('cms.area.detail', $area), ['icon' => 'fas fa-list']);
});

// DISTRICT
Breadcrumbs::for('cms.district.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.district'), route('cms.district.index'), ['icon' => 'fas fa-city']);
});

Breadcrumbs::for('cms.district.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.district.index');
    $trail->push(trans('index.add'), route('cms.district.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.district.edit', function (BreadcrumbTrail $trail, $district) {
    $trail->parent('cms.district.index');
    $trail->push(trans('index.edit'), route('cms.district.edit', $district), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.district.detail', function (BreadcrumbTrail $trail, $district) {
    $trail->parent('cms.district.index');
    $trail->push(trans('index.detail'), route('cms.district.detail', $district), ['icon' => 'fas fa-list']);
});

// ACCESS
// OAUTH
Breadcrumbs::for('cms.oauth.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.oauth'), route('cms.oauth.index'), ['icon' => 'fas fa-gears']);
});

Breadcrumbs::for('cms.oauth.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.oauth.index');
    $trail->push(trans('index.add'), route('cms.oauth.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.oauth.edit', function (BreadcrumbTrail $trail, $oauth) {
    $trail->parent('cms.oauth.index');
    $trail->push(trans('index.edit'), route('cms.oauth.edit', $oauth), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.oauth.detail', function (BreadcrumbTrail $trail, $oauth) {
    $trail->parent('cms.oauth.index');
    $trail->push(trans('index.detail'), route('cms.oauth.detail', $oauth), ['icon' => 'fas fa-list']);
});

// PERMISSION
Breadcrumbs::for('cms.permission.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.permission'), route('cms.permission.index'), ['icon' => 'fas fa-lock-open']);
});

Breadcrumbs::for('cms.permission.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.permission.index');
    $trail->push(trans('index.add'), route('cms.permission.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.permission.edit', function (BreadcrumbTrail $trail, $permission) {
    $trail->parent('cms.permission.index');
    $trail->push(trans('index.edit'), route('cms.permission.edit', $permission), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.permission.detail', function (BreadcrumbTrail $trail, $permission) {
    $trail->parent('cms.permission.index');
    $trail->push(trans('index.detail'), route('cms.permission.detail', $permission), ['icon' => 'fas fa-list']);
});

// ROLE
Breadcrumbs::for('cms.role.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.role'), route('cms.role.index'), ['icon' => 'fas fa-key']);
});

Breadcrumbs::for('cms.role.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.role.index');
    $trail->push(trans('index.add'), route('cms.role.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.role.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('cms.role.index');
    $trail->push(trans('index.edit'), route('cms.role.edit', $role), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.role.detail', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('cms.role.index');
    $trail->push(trans('index.detail'), route('cms.role.detail', $role), ['icon' => 'fas fa-list']);
});

// USER
Breadcrumbs::for('cms.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.user'), route('cms.user.index'), ['icon' => 'fas fa-user']);
});

Breadcrumbs::for('cms.user.add', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.user.index');
    $trail->push(trans('index.add'), route('cms.user.add'), ['icon' => 'fas fa-plus']);
});

Breadcrumbs::for('cms.user.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('cms.user.index');
    $trail->push(trans('index.edit'), route('cms.user.edit', $user), ['icon' => 'fas fa-edit']);
});

Breadcrumbs::for('cms.user.detail', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('cms.user.index');
    $trail->push(trans('index.detail'), route('cms.user.detail', $user), ['icon' => 'fas fa-list']);
});

// PROFILE
Breadcrumbs::for('cms.profile.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.home');
    $trail->push(trans('page.profile'), route('cms.profile.index'), ['icon' => 'fas fa-user']);
});

Breadcrumbs::for('cms.profile.edit-profile', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.profile.index');
    $trail->push(trans('page.edit_profile'), route('cms.profile.edit-profile'), ['icon' => 'fas fa-user-edit']);
});

Breadcrumbs::for('cms.profile.change-password', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.profile.index');
    $trail->push(trans('page.change_password'), route('cms.profile.change-password'), ['icon' => 'fas fa-user-lock']);
});

Breadcrumbs::for('cms.profile.setting', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.profile.index');
    $trail->push(trans('page.setting'), route('cms.profile.setting'), ['icon' => 'fas fa-user-gear']);
});

Breadcrumbs::for('cms.profile.activity', function (BreadcrumbTrail $trail) {
    $trail->parent('cms.profile.index');
    $trail->push(trans('page.activity'), route('cms.profile.activity'), ['icon' => 'fas fa-user-clock']);
});
