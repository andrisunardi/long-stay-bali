@props([
    'id' => null,
    'value' => null,
])

<div wire:ignore>
    <textarea id="{{ $id }}">{{ $value }}</textarea>
</div>

<script>
    function initTinyMce() {
        const existing = tinymce.get('{{ $id }}');

        if (existing) {
            existing.remove();
        }

        tinymce.init({
            selector: '#{{ $id }}',
            height: 300,
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
            images_file_types: 'png,jpg,jpeg,gif,svg,webp',
            file_picker_types: 'file image media',
            images_upload_url: '/cms/upload/image',
            images_upload_credentials: true,
            block_unsupported_drop: true,
            automatic_uploads: true,
            setup: function(editor) {
                editor.on('change keyup', function() {
                    @this.set('form.{{ $id }}', editor.getContent());
                });
            }
        });
    }

    initTinyMce();

    document.addEventListener('livewire:navigated', () => {
        queueMicrotask(() => {
            initTinyMce();
        });
    });
</script>
