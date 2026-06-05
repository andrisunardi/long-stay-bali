<div>
    @if ($errors?->any() ?? null)
        <div class="alert alert-danger text-capitalize">
            @foreach ($errors->all() as $message)
                {{ is_array($message) ? implode(' ', $message) : $message }}<br>
                @if (!$loop->last)
                    <br />
                @endif
            @endforeach
        </div>
    @endif
