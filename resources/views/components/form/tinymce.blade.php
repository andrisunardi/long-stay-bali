@props([
    'id' => null,
    'value' => null,
])

<div wire:ignore>
    <textarea id="{{ $id }}">{{ $value }}</textarea>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        tinymce.init({
            selector: '#{{ $id }}',
            height: 500,
            plugins: [
                'code',
                'table',
                'image',
                'link',
                'lists',
                'code',
                'fullscreen'
            ],
            toolbar: 'undo redo | blocks | styles | bold italic underline | indent outdent | alignleft aligncenter alignright | bullist numlist | link image table | | code fullscreen',
            setup: function(editor) {
                editor.on('change keyup', function() {
                    @this.set('form.{{ $id }}', editor.getContent());
                });
            }
        });
    });
</script>
