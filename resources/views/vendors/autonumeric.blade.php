@push('script')
    <script src="{{ asset('vendors/autonumeric-1.9.26/js/autoNumeric.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".autonumeric").autoNumeric("init", {
                aSep: ".",
                aDec: ",",
                mDec: "0"
            });
        });
    </script>
@endpush
