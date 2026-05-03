<?php

use App\Exports\GuideExport;
use App\Livewire\Component;
use App\Models\Guide;
use App\Services\GuideService;
use App\Services\GuideCategoryService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Guide')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $guide_category_id = '';

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

        $this->reset(['search', 'guide_category_id', 'is_show', 'is_active']);
    }

    public function changeShow(Guide $guide): void
    {
        $service = new GuideService();
        $service->show(guide: $guide);

        $this->alertSuccess(title: trans('index.change_show') . ' ' . trans('index.success'), body: trans('page.guide') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeActive(Guide $guide): void
    {
        $service = new GuideService();
        $service->active(guide: $guide);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.guide') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(Guide $guide): void
    {
        $service = new GuideService();
        $service->delete(guide: $guide);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.guide') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function guideCategories(): object
    {
        $service = new GuideCategoryService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function guides(bool $paginate = true): object
    {
        $service = new GuideService();
        $guides = $service->index(search: $this->search, guideCategoryId: $this->guide_category_id, isActive: $this->is_active, paginate: $paginate);
        $guides->loadMissing(['category']);

        return $guides;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.guide') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new GuideService();
        $guides = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $guides->loadMissing(['category', 'createdBy', 'updatedBy']);

        return Excel::download(new GuideExport(guides: $guides), trans('page.guide') . '.xlsx');
    }
};
?>

@section('title', trans('page.guide'))

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
                    <div class="col-12 col-sm">
                        <label class="form-label" for="guide_category_id">
                            {{ trans('field.guide_category_id') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="guide_category_id" name="guide_category_id"
                                wire:key="guide_category_id" wire:model.lazy="guide_category_id"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">{{ trans('index.all') }} {{ trans('page.guide_category') }}
                                </option>
                                @foreach ($this->guideCategories() as $guideCategory)
                                    <option value="{{ $guideCategory->id }}"
                                        {{ $guideCategory->id == $guide_category_id ? 'selected' : '' }}
                                        wire:key="guide-category-{{ $guideCategory->id }}">
                                        {{ $guideCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
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

                    <div class="col-auto">
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
                @can('guide.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.guide.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('guide.export')
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
                            <th width="1%">{{ trans('field.image') }}</th>
                            <th width="1%">{{ trans('field.guide_category_id') }}</th>
                            <th>{{ trans('field.title') }}</th>
                            <th width="1%">{{ trans('field.created_at') }}</th>
                            <th width="1%">{{ trans('field.show') }}</th>
                            <th width="1%">{{ trans('field.active') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->guides() as $guide)
                            <tr wire:key="guide-{{ $guide->id }}">
                                <td class="text-center">
                                    {{ ($this->guides()->currentPage() - 1) * $this->guides()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false" href="{{ route('cms.guide.detail', ['guide' => $guide]) }}"
                                        wire:navigate>
                                        {{ $guide->id }}
                                    </a>
                                </td>
                                <td class="p-0">
                                    @if ($guide->image_url)
                                        <a draggable="false" href="{{ $guide->image_url }}" target="_blank">
                                            <div class="ratio ratio-1x1">
                                                <img draggable="false" loading="lazy" decoding="async"
                                                    class="img-fluid w-100 h-100 object-fit-cover"
                                                    src="{{ $guide->image_url }}"
                                                    alt="{{ trans('page.guide') }} - {{ $guide->id }}"
                                                    onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                                            </div>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($guide->category)
                                        <a draggable="false"
                                            href="{{ route('cms.guide-category.detail', ['guideCategory' => $guide->category]) }}"
                                            wire:navigate>
                                            {{ $guide->category->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a draggable="false" href="{{ route('cms.guide.detail', ['guide' => $guide]) }}"
                                        wire:navigate>
                                        {{ $guide->title }}
                                    </a>
                                    @if ($guide->is_show && $guide->is_active)
                                        <a draggable="false"
                                            href="{{ route('guide.detail', ['slug' => $guide->slug]) }}"
                                            target="_blank">
                                            <span class="fas fa-external-link fa-fw"></span>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $guide->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    @can('guide.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_show_{{ $guide->id }}" name="is_show" value="1"
                                                {{ $guide->is_show ? 'checked' : '' }}
                                                wire:click="changeShow({{ $guide->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label class="form-check-label text-{{ Str::successDanger($guide->is_show) }}"
                                                for="is_show_{{ $guide->id }}">
                                                {{ Str::yesNo($guide->is_show) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($guide->is_show) }}">
                                            {{ Str::yesNo($guide->is_show) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    @can('guide.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_active_{{ $guide->id }}" name="is_active" value="1"
                                                {{ $guide->is_active ? 'checked' : '' }}
                                                wire:click="changeActive({{ $guide->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($guide->is_active) }}"
                                                for="is_active_{{ $guide->id }}">
                                                {{ Str::yesNo($guide->is_active) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($guide->is_active) }}">
                                            {{ Str::yesNo($guide->is_active) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('guide.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.guide.detail', ['guide' => $guide]) }}" wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('guide.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.guide.edit', ['guide' => $guide]) }}" wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('guide.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $guide->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $guide->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $guide->id }})"
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

            {{ $this->guides()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#guide_category_id").on("change", function() {
            @this.set("guide_category_id", $(this).val())
        })
    </script>
@endscript
