@push('css')
@endpush

@push('script')
    <script src="{{ asset('vendors/panzoom-4.6.0/js/panzoom.min.js') }}"></script>

    <script>
        function initPanzoom() {
            document.querySelectorAll('.zoom img').forEach(img => {
                if (img.panzoomInstance) {
                    img.parentElement.removeEventListener('wheel', img.panzoomWheelHandler);
                    img.panzoomInstance.destroy();
                }

                const panzoom = Panzoom(img, {
                    maxScale: 5,
                    minScale: 1,
                    contain: 'outside',
                    touchAction: 'pan-y pinch-zoom',
                });

                const wheelHandler = panzoom.zoomWithWheel;
                img.parentElement.addEventListener('wheel', wheelHandler);

                img.panzoomInstance = panzoom;
                img.panzoomWheelHandler = wheelHandler;
            });
        }

        document.addEventListener("livewire:navigated", initPanzoom);
    </script>
@endpush
