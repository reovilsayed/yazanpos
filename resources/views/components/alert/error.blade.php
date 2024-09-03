<script>
    $(document).ready(function() {
        @if (session()->has('errors'))
            var errors = {!! json_encode($errors->all()) !!};
            errors.forEach(function(error) {
                toastr.error(error, "Error");
            });
        @endif
    });
</script>