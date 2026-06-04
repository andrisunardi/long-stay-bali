@push('css')
@endpush

@push('script')
    <script src="{{ asset('vendors/panzoom-4.6.0/js/panzoom.min.js') }}"></script>

    <script>
        document.addEventListener("livewire:navigated", () => {
            document.querySelectorAll('.zoom img').forEach((img) => {
                const panzoom = Panzoom(img, {
                    maxScale: 5,
                    minScale: 1,
                    contain: 'outside',
                    touchAction: 'pan-y pinch-zoom',
                });

                const parent = img.parentElement;

                parent.addEventListener('wheel', (e) => {
                    if (e.ctrlKey) {
                        panzoom.zoomWithWheel(e);
                    }
                }, {
                    passive: false
                });

                img.addEventListener('dblclick', (e) => {
                    const scale = panzoom.getScale();

                    if (scale === 1) {
                        panzoom.zoomToPoint(2, {
                            clientX: e.clientX,
                            clientY: e.clientY
                        });
                    } else {
                        panzoom.reset();
                    }
                });
            });
        });
    </script>
@endpush
