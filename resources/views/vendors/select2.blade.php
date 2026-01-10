@push('css')
    <link href="{{ asset('vendors/select2-4.1.0/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/select2-4.1.0/css/select2-bootstrap4.min.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('vendors/select2-bootstrap5/css/select2-bootstrap5.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('vendors/select2-bootstrap5/css/select2-bootstrap5-dark.min.css') }}" rel="stylesheet"> --}}
@endpush

@push('script')
    <script src="{{ asset('vendors/select2-4.1.0/js/select2.min.js') }}"></script>
    <script>
        $(".select2").select2({
            theme: "bootstrap4",
            dropdownAutoWidth: true,
            width: "auto",
        });
    </script>

    <script>
        document.addEventListener("livewire:navigated", () => {
            Livewire.hook('commit', ({
                component,
                commit,
                respond,
                succeed,
                fail
            }) => {
                succeed(({
                    snapshot,
                    effect
                }) => {
                    queueMicrotask(() => {
                        $(".select2").select2({
                            theme: "bootstrap4",
                            dropdownAutoWidth: true,
                            width: "auto",
                        });
                    })
                })
            })
        })
    </script>
@endpush
