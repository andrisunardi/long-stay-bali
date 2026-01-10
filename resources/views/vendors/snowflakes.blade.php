@push('css')
@endpush

@push('script')
    @if (now()->format('m') == 12)
        <script src="{{ asset('vendors/snowflakes/js/snowflakes.min.js') }}"></script>
        <script>
            new Snowflakes();
        </script>
    @endif
@endpush
