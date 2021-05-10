<script type="text/javascript">
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
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
    }
</script>
@if (session('success'))
<script>
    toastr.success("{{ session('success') }}")
</script>
@elseif (session('info'))
<script>
    toastr.info("{{ session('info') }}")
</script>
@elseif (session('warning'))
<script>
    toastr.warning("{{ session('warning') }}")
</script>
@elseif (session('error'))
<script>
    toastr.error("{{ session('error') }}")
</script>
@endif
