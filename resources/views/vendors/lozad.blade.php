@push('css')
@endpush

@push('script')
    <script src="{{ asset('vendors/lozad-1.14.0/js/lozad.min.js') }}"></script>
    <script>
        const observer = lozad();
        observer.observe();
    </script>
@endpush
