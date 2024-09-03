<script>
   
    $(document).ready(function() {
        toastr.success("{{ session('success') }}", "Success")
    });
</script>
