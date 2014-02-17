<script type="text/javascript">
    $(document).ready(function(){

        // Dismiss lookup
        $(document).on('click', '[data-dismiss="lookup"]', function(){
            e.preventDefault();

            $(this).closest('div').find('input').val('');

            return false;
        });

        // Lookup
        $(document).on('click', '[data-toggle="lookup"]', function(e){
            e.preventDefault();

            window.open($(this).data('href'), 'Lookup', '<?php echo $options; ?>');

            return false;
        });
    });
</script>