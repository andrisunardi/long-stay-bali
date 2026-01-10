@push('css')
    <link href="{{ asset('vendors/flatpickr-4.6.13/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script src="{{ asset('vendors/flatpickr-4.6.13/js/flatpickr.js') }}"></script>
    <script>
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            disableMobile: true,
        });
    </script>
@endpush
