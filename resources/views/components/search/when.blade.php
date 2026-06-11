@props([
    'rentalType' => null,
    'month' => null,
    'calendars' => [],
    'startDate' => null,
    'endDate' => null,
])

<div>
    <label class="form-label">
        <span class="fas fa-calendar fa-fw"></span>
        {{ trans('home.search.when') }}
    </label>
    <div class="input-group">
        <button type="button" data-when-dropdown
            class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" data-bs-display="static">
            <span>
                {{ Date::parse($startDate)->isoFormat('DD MMM YYYY') }}
                <span> - </span>
                {{ Date::parse($endDate)->isoFormat('DD MMM YYYY') }}
            </span>
        </button>

        <div class="dropdown-menu w-100 mt-3 p-3">
            <div class="row g-3 mb-3">
                @foreach (collect(PropertyRentalType::cases())->reject(fn(PropertyRentalType $propertyRentalType) => $propertyRentalType == PropertyRentalType::Both) as $propertyRentalType)
                    <div class="col">
                        <button type="button"
                            class="btn btn-outline-success btn-sm w-100 rounded-pill {{ ((!$rentalType || $rentalType == PropertyRentalType::Both->value) && $propertyRentalType == PropertyRentalType::Monthly) || $propertyRentalType->value == $rentalType ? 'active' : '' }}"
                            wire:click="changeRentalType({{ $propertyRentalType->value }})"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            {{ $propertyRentalType->translate() }}
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-link text-success p-0" wire:click="previousMonth">
                            <i class="fas fa-caret-left fa-fw"></i>
                        </button>

                        <span class="fw-semibold">
                            {{ Date::parse($month)->format('F Y') }}
                        </span>

                        <button type="button" class="btn btn-link text-success p-0" wire:click="nextMonth">
                            <i class="fas fa-caret-right fa-fw"></i>
                        </button>
                    </div>

                    <table class="table table-sm table-borderless text-center align-middle mb-0">
                        <thead>
                            <tr class="text-secondary">
                                <th>S</th>
                                <th>M</th>
                                <th>T</th>
                                <th>W</th>
                                <th>T</th>
                                <th>F</th>
                                <th>S</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($calendars->chunk(7) as $week)
                                <tr>
                                    @foreach ($week as $day)
                                        <td>
                                            @if ($day->isSameDay(Carbon\Carbon::create(2026, 6, 4)))
                                                <button type="button" class="btn btn-primary btn-sm rounded">
                                                    {{ $day->day }}
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="btn btn-sm border-0 {{ !$day->isSameMonth($month) ? 'text-danger' : 'text-success' }}">
                                                    {{ $day->day }}
                                                </button>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('keep-when-dropdown-open', () => {
            document.querySelectorAll('[data-when-dropdown]').forEach(el => {
                const dropdown =
                    bootstrap.Dropdown.getInstance(el) ??
                    new bootstrap.Dropdown(el)
                dropdown.show()
            })
        })
    });
</script>
