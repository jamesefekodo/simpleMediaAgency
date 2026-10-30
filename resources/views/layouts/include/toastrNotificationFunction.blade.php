<script>
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>

@if (session()->has('success'))
    <script>
        toastr.success(
            @json(session('success')),
            @json('Success')
        );
    </script>
@endif

@if (session()->has('error'))
    <script>
        toastr.error(
            @json(session('error')),
            @json('Error')
        );
    </script>
@endif

@if (session()->has('info'))
    <script>
        toastr.info(
            @json(session('info')),
            @json('Info')
        );
    </script>
@endif

@if (session()->has('warning'))
    <script>
        toastr.warning(
            @json(session('warning')),
            @json('Warning')
        );
    </script>
@endif
