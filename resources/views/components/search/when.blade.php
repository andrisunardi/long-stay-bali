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

            <hr />

            @php
                $minMonth =
                    $rentalType === PropertyRentalType::Yearly->value
                        ? now()->addMonth()->startOfMonth()
                        : now()->startOfMonth();

                $maxMonth =
                    $rentalType === PropertyRentalType::Yearly->value
                        ? now()->addMonths(7)->startOfMonth()
                        : now()->addMonths(6)->startOfMonth();

                $currentMonth = Date::parse($month)->startOfMonth();
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button type="button"
                    class="btn btn-link text-body {{ $currentMonth->lte($minMonth) ? 'disabled' : '' }}"
                    {{ $currentMonth->lte($minMonth) ? 'disabled' : '' }} wire:click="previousMonth"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="previousMonth">
                        <span class="fas fa-caret-left fa-fw"></span>
                    </span>
                    <span wire:loading wire:target="previousMonth" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>

                <span class="fw-semibold">
                    {{ Date::parse($month)->format('F Y') }}
                </span>

                <button type="button"
                    class="btn btn-link text-body {{ $currentMonth->gte($maxMonth) ? 'disabled' : '' }}"
                    {{ $currentMonth->gte($maxMonth) ? 'disabled' : '' }} wire:click="nextMonth"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="nextMonth">
                        <span class="fas fa-caret-right fa-fw"></span>
                    </span>
                    <span wire:loading wire:target="nextMonth" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

            @php
                $startOfWeek = now()
                    ->locale(app()->getLocale())
                    ->startOfWeek();
            @endphp

            <table class="table table-sm table-borderless text-center align-middle font-monospace mb-0">
                <thead>
                    <tr>
                        @foreach (range(0, 6) as $day)
                            <th wire:key="day-{{ $day }}">
                                {{ $startOfWeek->copy()->addDays($day)->isoFormat('dd') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($calendars->chunk(7) as $week)
                        <tr>
                            @foreach ($week as $day)
                                @php
                                    $date = $day->toDateString();

                                    $isStart = $date === $startDate;
                                    $isEnd = $date === $endDate;
                                    $isInRange = $date > $startDate && $date < $endDate;

                                    $isPast = $day->lt(
                                        $rentalType === PropertyRentalType::Yearly->value
                                            ? now()->addMonth()->startOfDay()
                                            : now()->startOfDay(),
                                    );

                                    $isToday = $day->isToday();

                                    $buttonClass = match (true) {
                                        $isStart && $isEnd => 'btn-success rounded-pill',
                                        $isStart => 'btn-success rounded-start-pill rounded-end-0',
                                        $isEnd => 'btn-success rounded-end-pill rounded-start-0',
                                        $isInRange => 'btn-success rounded-0 border-0',
                                        !$day->isSameMonth($month) => 'border-0 text-secondary text-opacity-50',
                                        $isToday => 'btn-outline-success rounded-pill',
                                        default => 'border-0 text-body',
                                    };
                                @endphp

                                <td class="p-0 {{ $isInRange ? 'bg-success bg-opacity-25' : '' }}"
                                    wire:key="day-{{ $date }}">
                                    <button type="button" wire:click="selectDate('{{ $date }}')"
                                        class="btn btn-sm w-100 {{ $buttonClass }}" @disabled($isPast)>
                                        {{ $day->format('d') }}
                                    </button>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
