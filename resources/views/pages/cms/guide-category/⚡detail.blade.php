<?php

use App\Livewire\Component;
use App\Services\GuideCategoryService;
use Livewire\Attributes\Title;
use App\Models\GuideCategory;

new #[Title('Detail | Guide Category')] class extends Component {
    public GuideCategory $guideCategory;

    public function mount(GuideCategory $guideCategory): void
    {
        $this->guideCategory = $guideCategory;
        $this->guideCategory->loadCount(['guides']);
    }

    public function changeShow(): void
    {
        $service = new GuideCategoryService();
        $service->show(guideCategory: $this->guideCategory);
        $this->guideCategory->loadCount(['guides']);

        $this->alertSuccess(title: trans('index.change_show') . ' ' . trans('index.success'), body: trans('page.guide_category') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeActive(): void
    {
        $service = new GuideCategoryService();
        $service->active(guideCategory: $this->guideCategory);
        $this->guideCategory->loadCount(['guides']);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.guide_category') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(): void
    {
        $service = new GuideCategoryService();
        $service->delete(guideCategory: $this->guideCategory);

        session()->flash('success', [
            'title' => trans('index.delete') . ' ' . trans('index.success'),
            'message' => trans('page.guide_category') . ' ' . trans('message.has_been_successfully_deleted'),
        ]);

        $this->redirect(route('cms.guide-category.index'), navigate: true);
    }
};
?>

@section('title', trans('page.guide_category'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-info">
            <span class="fas fa-list fa-fw"></span>
            {{ trans('index.detail') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-info w-100" href="{{ route('cms.guide-category.index') }}"
                        wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr />

            <div class="d-grid gap-3">
                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->name_id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name_zh') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->name_zh }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name_fr') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->name_fr }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.show') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @can('guideCategory.edit')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="is_show_{{ $guideCategory->id }}" name="is_show" value="1"
                                    {{ $guideCategory->is_show ? 'checked' : '' }}
                                    wire:click="changeShow({{ $guideCategory->id }})" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <label class="form-check-label text-{{ Str::successDanger($guideCategory->is_show) }}"
                                    for="is_show_{{ $guideCategory->id }}">
                                    {{ Str::yesNo($guideCategory->is_show) }}
                                </label>
                            </div>
                        @else
                            <span class="badge rounded-pill text-bg-{{ Str::successDanger($guideCategory->is_show) }}">
                                {{ Str::yesNo($guideCategory->is_show) }}
                            </span>
                        @endcan
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.active') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @can('guideCategory.edit')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="is_active_{{ $guideCategory->id }}" name="is_active" value="1"
                                    {{ $guideCategory->is_active ? 'checked' : '' }}
                                    wire:click="changeActive({{ $guideCategory->id }})" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <label class="form-check-label text-{{ Str::successDanger($guideCategory->is_active) }}"
                                    for="is_active_{{ $guideCategory->id }}">
                                    {{ Str::yesNo($guideCategory->is_active) }}
                                </label>
                            </div>
                        @else
                            <span class="badge rounded-pill text-bg-{{ Str::successDanger($guideCategory->is_active) }}">
                                {{ Str::yesNo($guideCategory->is_active) }}
                            </span>
                        @endcan
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('index.total') }} {{ trans('page.guide') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <a draggable="false"
                            href="{{ route('cms.guide.index', ['guide_category_id' => $guideCategory->id]) }}"
                            wire:navigate>
                            {{ $guideCategory->guides_count }}
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->createdBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guideCategory->updatedBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($guideCategory->created_at)
                            {{ $guideCategory->created_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $guideCategory->created_at->diffForHumans() }})
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($guideCategory->updated_at)
                            {{ $guideCategory->updated_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $guideCategory->updated_at->diffForHumans() }})
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row g-3">
                @can('guideCategory.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.guide-category.edit', ['guideCategory' => $guideCategory]) }}"
                            wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('guideCategory.delete')
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger w-100" wire:click="delete"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">
                                <span class="fas fa-trash fa-fw"></span>
                                {{ trans('index.delete') }}
                            </span>
                            <span wire:loading wire:target="delete" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.delete') }}
                            </span>
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    <livewire:activity-log :model="$guideCategory" />
</div>
