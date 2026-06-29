<?php

use App\Exports\GuideCategoryExport;
use App\Livewire\Component;
use App\Models\GuideCategory;
use App\Services\GuideCategoryService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Guide Category')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: [])]
    public array $is_show = [];

    #[Url(except: [])]
    public array $is_active = [];

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'is_show', 'is_active']);
    }

    public function changeShow(GuideCategory $guideCategory): void
    {
        $service = new GuideCategoryService();
        $service->show(guideCategory: $guideCategory);

        $this->alertSuccess(title: trans('index.change_show') . ' ' . trans('index.success'), body: trans('page.guide_category') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeActive(GuideCategory $guideCategory): void
    {
        $service = new GuideCategoryService();
        $service->active(guideCategory: $guideCategory);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.guide_category') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(GuideCategory $guideCategory): void
    {
        $service = new GuideCategoryService();
        $service->delete(guideCategory: $guideCategory);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.guide_category') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function guideCategories(bool $paginate = true): object
    {
        $service = new GuideCategoryService();
        $guideCategories = $service->index(search: $this->search, isShow: $this->is_show, isActive: $this->is_active, paginate: $paginate);
        $guideCategories->loadCount(['guides']);

        return $guideCategories;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.guide_category') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new GuideCategoryService();
        $guideCategories = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $guideCategories->loadCount(['guides']);
        $guideCategories->loadMissing(['createdBy', 'updatedBy']);

        return Excel::download(new GuideCategoryExport(guideCategories: $guideCategories), trans('page.guide_category') . '.xlsx');
    }
};
?>

@section('title', trans('page.guide_category'))

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

                <div class="row g-3">
                    <div class="col-sm-auto">
                        <label class="form-label" for="is_show">
                            {{ trans('field.is_show') }}
                        </label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_show_1" name="is_show"
                                    value="1" wire:model.lazy="is_show" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_show_1">
                                    {{ trans('index.yes') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_show_0" name="is_show"
                                    value="0" wire:model.lazy="is_show" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_show_0">
                                    {{ trans('no') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-auto">
                        <label class="form-label" for="is_active">
                            {{ trans('field.is_active') }}
                        </label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active_1" name="is_active"
                                    value="1" wire:model.lazy="is_active" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_active_1">
                                    {{ trans('index.yes') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active_0" name="is_active"
                                    value="0" wire:model.lazy="is_active" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_active_0">
                                    {{ trans('index.no') }}
                                </label>
                            </div>
                        </div>
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
                @can('guide_category.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.guide-category.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('guide_category.export')
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
                <table
                    class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.guide') }}</th>
                            <th width="1%">{{ trans('field.show') }}</th>
                            <th width="1%">{{ trans('field.active') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->guideCategories() as $guideCategory)
                            <tr wire:key="guideCategory-{{ $guideCategory->id }}">
                                <td class="text-center">
                                    {{ ($this->guideCategories()->currentPage() - 1) * $this->guideCategories()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.guide-category.detail', ['guideCategory' => $guideCategory]) }}"
                                        wire:navigate>
                                        {{ $guideCategory->id }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="{{ route('cms.guide-category.detail', ['guideCategory' => $guideCategory]) }}"
                                        wire:navigate>
                                        {{ $guideCategory->name }}
                                    </a>
                                    <span>/</span>
                                    {{ $guideCategory->name_id }}
                                    <span>/</span>
                                    {{ $guideCategory->name_zh }}
                                    <span>/</span>
                                    {{ $guideCategory->name_fr }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.guide.index', ['guide_category_id' => $guideCategory->id]) }}"
                                        wire:navigate>
                                        {{ $guideCategory->guides_count }}
                                    </a>
                                </td>
                                <td>
                                    @can('guide_category.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_show_{{ $guideCategory->id }}" name="is_show" value="1"
                                                {{ $guideCategory->is_show ? 'checked' : '' }}
                                                wire:click="changeShow({{ $guideCategory->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($guideCategory->is_show) }}"
                                                for="is_show_{{ $guideCategory->id }}">
                                                {{ Str::yesNo($guideCategory->is_show) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($guideCategory->is_show) }}">
                                            {{ Str::yesNo($guideCategory->is_show) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    @can('guide_category.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_active_{{ $guideCategory->id }}" name="is_active" value="1"
                                                {{ $guideCategory->is_active ? 'checked' : '' }}
                                                wire:click="changeActive({{ $guideCategory->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($guideCategory->is_active) }}"
                                                for="is_active_{{ $guideCategory->id }}">
                                                {{ Str::yesNo($guideCategory->is_active) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($guideCategory->is_active) }}">
                                            {{ Str::yesNo($guideCategory->is_active) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('guide_category.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.guide-category.detail', ['guideCategory' => $guideCategory]) }}"
                                                wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('guide_category.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.guide-category.edit', ['guideCategory' => $guideCategory]) }}"
                                                wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('guide_category.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $guideCategory->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $guideCategory->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $guideCategory->id }})"
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

            {{ $this->guideCategories()->links('pagination') }}
        </div>
    </div>
</div>
