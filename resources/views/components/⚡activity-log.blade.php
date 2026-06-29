<?php

use App\Livewire\Component;
use Illuminate\Database\Eloquent\Model;

new class extends Component {
    public Model $model;
};
?>

<div class="d-grid gap-3 mt-3">
    @foreach ($model->activities as $activity)
        <div class="card card-body" wire:key="activity-{{ $activity->id }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold">
                    {{ $activity->log_name }} ({{ $activity->subject_id }})
                </div>
                <div class="badge text-bg-primary rounded-pill text-capitalize">
                    {{ $activity->event }}
                </div>
            </div>

            <p>{!! $activity->description !!}</p>

            <small>
                <span class="fas fa-clock fa-fw"></span>
                {{ $activity->created_at->isoFormat('LLLL') }}
            </small>

            <hr />

            <div class="row g-3">
                <div class="col-sm-6">
                    @if (Arr::exists($activity->changes, ['old']))
                        <h6>old</h6>
                        <pre><code>{{ json_encode($activity->changes['old'], JSON_PRETTY_PRINT) }}</code></pre>
                    @endif
                </div>
                <div class="col-sm-6">
                    @if (Arr::exists($activity->changes, ['attributes']))
                        <h6>attributes</h6>
                        <pre><code>{{ json_encode($activity->changes['attributes'], JSON_PRETTY_PRINT) }}</code></pre>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
