<script type="text/javascript">
    $(document).ready(function(){

        // Dismiss lookup
        $(document).on('click', '[data-dismiss="lookup"]', function(e){
            e.preventDefault();

            $(this).closest('div').find('input').val('');

            return false;
        });
    });
</script>