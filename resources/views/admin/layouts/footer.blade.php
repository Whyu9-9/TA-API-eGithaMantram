<script type="text/javascript">
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
</script>
<script>tinymce.init({selector:'textarea'});</script>

<script src="/assets/js/jquery-1.11.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/custom.js"></script>
