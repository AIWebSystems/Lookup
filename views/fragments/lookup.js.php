<script type="text/javascript">
    $(document).ready(function(){

        // Dismiss lookup
        $(document).on('click', '[data-dismiss="lookup"]', function(){
            $(this).closest('div').find('input').val('');

            return false;
        });

        // Lookup
        $(document).on('click', '[data-toggle="lookup"]', function(){
            window.open('<?php echo $url; ?>', 'Lookup', '<?php echo $options; ?>');

            return false;
        });
    });
</script>