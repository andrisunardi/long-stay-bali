@push('css')
    <link href="{{ asset('vendors/bootstrap-5.3.3/css/bootstrap.min.css') }}" rel="stylesheet">

    <script src="{{ asset('vendors/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endpush

@push('script')
@endpush
