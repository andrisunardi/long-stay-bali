@push('css')
@endpush

@push('script')
    <script src="{{ asset('vendors/panzoom-4.6.0/js/panzoom.min.js') }}"></script>

    <script>
        document.addEventListener("livewire:navigated", () => {
            document.querySelectorAll('.zoom img').forEach(img => {
                const panzoom = Panzoom(img, {
                    maxScale: 5,
                    minScale: 1,
                    contain: 'outside',
                });

                img.parentElement.addEventListener('wheel', panzoom.zoomWithWheel);

            });
        });
    </script>
@endpush
