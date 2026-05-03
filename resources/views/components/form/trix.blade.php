@props(['model'])

<div wire:ignore x-data x-init="$refs.trix.editor.loadHTML(@js(data_get($this, $model) ?? ''));
$refs.trix.addEventListener('trix-change', e =>
    $wire.set('{{ $model }}', e.target.value)
);">
    <trix-editor x-ref="trix" {{ $attributes->merge(['class' => 'form-control']) }}></trix-editor>
</div>
