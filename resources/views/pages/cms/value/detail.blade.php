<?php

use App\Livewire\Component;
use App\Services\ValueService;
use Livewire\Attributes\Title;
use App\Models\Value;

new #[Title('Detail | Value')] class extends Component {
    public Value $vale;

    public function mount(Value $vale): void
    {
        $this->vale = $vale;
    }

    public function changeActive(): void
    {
        $service = new ValueService();
        $service->active(vale: $this->vale);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.vale') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(): void
    {
        $service = new ValueService();
        $service->delete(vale: $this->vale);

        session()->flash('success', [
            'title' => trans('index.delete') . ' ' . trans('index.success'),
            'message' => trans('page.vale') . ' ' . trans('message.has_been_successfully_deleted'),
        ]);

        $this->redirect(route('cms.vale.index'), navigate: true);
    }
};
?>

@section('title', trans('page.vale'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-info">
            <span class="fas fa-list fa-fw"></span>
            {{ trans('index.detail') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-info w-100" href="{{ route('cms.vale.index') }}" wire:navigate>
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
                        {{ $vale->id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->title }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->title_id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title_zh') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->title_zh }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.title_fr') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->title_fr }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.short_description') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->short_description }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.short_description_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->short_description_id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.short_description_zh') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->short_description_zh }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.short_description_fr') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->short_description_fr }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->description }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->description_id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description_zh') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->description_zh }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description_fr') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->description_fr }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.icon') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->icon }}
                        <span class="{{ $vale->icon }}"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.active') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @can('vale.edit')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="is_active_{{ $vale->id }}" name="is_active" value="1"
                                    {{ $vale->is_active ? 'checked' : '' }}
                                    wire:click="changeActive({{ $vale->id }})" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <label class="form-check-label text-{{ Str::successDanger($vale->is_active) }}"
                                    for="is_active_{{ $vale->id }}">
                                    {{ Str::yesNo($vale->is_active) }}
                                </label>
                            </div>
                        @else
                            <span class="badge rounded-pill text-bg-{{ Str::successDanger($vale->is_active) }}">
                                {{ Str::yesNo($vale->is_active) }}
                            </span>
                        @endcan
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->createdBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $vale->updatedBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($vale->created_at)
                            {{ $vale->created_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $vale->created_at->diffForHumans() }})
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($vale->updated_at)
                            {{ $vale->updated_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $vale->updated_at->diffForHumans() }})
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row g-3">
                @can('vale.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.vale.edit', ['vale' => $vale]) }}" wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('vale.delete')
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

    <livewire:activity-log :model="$vale" />
</div>
