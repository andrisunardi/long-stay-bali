<?php

use App\Livewire\Component;
use App\Services\GuideService;
use Livewire\Attributes\Title;
use App\Models\Guide;

new #[Title('Detail | Guide')] class extends Component {
    public Guide $guide;

    public function mount(Guide $guide): void
    {
        $this->guide = $guide;
    }

    public function changeShow(): void
    {
        $service = new GuideService();
        $service->show(guide: $this->guide);

        $this->alertSuccess(title: trans('index.change_show') . ' ' . trans('index.success'), body: trans('page.guide') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeActive(): void
    {
        $service = new GuideService();
        $service->active(guide: $this->guide);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.guide') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(): void
    {
        $service = new GuideService();
        $service->delete(guide: $this->guide);

        session()->flash('success', [
            'title' => trans('index.delete') . ' ' . trans('index.success'),
            'message' => trans('page.guide') . ' ' . trans('message.has_been_successfully_deleted'),
        ]);

        $this->redirect(route('cms.guide.index'), navigate: true);
    }
};
?>

@section('title', trans('page.guide'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-info">
            <span class="fas fa-list fa-fw"></span>
            {{ trans('index.detail') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-info w-100" href="{{ route('cms.guide.index') }}" wire:navigate>
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
                        {{ $guide->id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.guide_category_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($guide->category)
                            <a draggable="false"
                                href="{{ route('cms.guide-category.detail', ['guideCategory' => $guide->category]) }}"
                                wire:navigate>
                                {{ $guide->category->name }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guide->title }}

                        @if ($guide->is_show && $guide->is_active)
                            <a draggable="false" href="{{ route('guide.detail', ['slug' => $guide->slug]) }}"
                                target="_blank">
                                <span class="fas fa-external-link fa-fw"></span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guide->title_id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title_zh') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guide->title_zh }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.body') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {!! $guide->body !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.body_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {!! $guide->body_id !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.body_zh') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {!! $guide->body_zh !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.show') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @can('guide.edit')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="is_show_{{ $guide->id }}" name="is_show" value="1"
                                    {{ $guide->is_show ? 'checked' : '' }} wire:click="changeShow({{ $guide->id }})"
                                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label text-{{ Str::successDanger($guide->is_show) }}"
                                    for="is_show_{{ $guide->id }}">
                                    {{ Str::yesNo($guide->is_show) }}
                                </label>
                            </div>
                        @else
                            <span class="badge rounded-pill text-bg-{{ Str::successDanger($guide->is_show) }}">
                                {{ Str::yesNo($guide->is_show) }}
                            </span>
                        @endcan
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.active') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @can('guide.edit')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="is_active_{{ $guide->id }}" name="is_active" value="1"
                                    {{ $guide->is_active ? 'checked' : '' }}
                                    wire:click="changeActive({{ $guide->id }})" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <label class="form-check-label text-{{ Str::successDanger($guide->is_active) }}"
                                    for="is_active_{{ $guide->id }}">
                                    {{ Str::yesNo($guide->is_active) }}
                                </label>
                            </div>
                        @else
                            <span class="badge rounded-pill text-bg-{{ Str::successDanger($guide->is_active) }}">
                                {{ Str::yesNo($guide->is_active) }}
                            </span>
                        @endcan
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.slug') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guide->slug }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guide->createdBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $guide->updatedBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($guide->created_at)
                            {{ $guide->created_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $guide->created_at->diffForHumans() }})
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($guide->updated_at)
                            {{ $guide->updated_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $guide->updated_at->diffForHumans() }})
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row g-3">
                @can('guide.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.guide.edit', ['guide' => $guide]) }}" wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('guide.delete')
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

    <livewire:activity-log :model="$guide" />
</div>
