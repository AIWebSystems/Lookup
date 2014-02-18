<script type="text/javascript">
    $(document).ready(function(){

        // Lookup
        $(document).on('click', '[data-toggle="lookup"]', function(e){
            e.preventDefault();

            window.open($(this).data('href'), 'Lookup', '<?php echo $options; ?>');

            return false;
        });
    });
</script>