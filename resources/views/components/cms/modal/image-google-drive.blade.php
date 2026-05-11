@props([
    'image' => null,
])

<div class="modal fade" id="modal-image-{{ $image }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <span class="fas fa-image fa-fw"></span>
                    {{ trans('index.image') }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <a draggable="false" href="https://lh3.googleusercontent.com/d/{{ $image }}" target="_blank">
                    <img draggable="false" loading="lazy" decoding="async" class="img-fluid w-100"
                        src="https://lh3.googleusercontent.com/d/{{ $image }}" alt="Google Drive">
                </a>
            </div>
        </div>
    </div>
</div>
