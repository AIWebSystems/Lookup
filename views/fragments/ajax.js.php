<script type="text/javascript">
    $(document).ready(function () {

        // Select
        $(document).on('click', '[data-toggle="select"]', function (e) {
            e.preventDefault();

            var selection = $(this);
            var formSlug = '<?php echo $formSlug; ?>';

            $(opener.document).find('input[name="' + formSlug + '"]').val(selection.data('id'));
            $(opener.document).find('input[name="' + formSlug + '_template"]').val(selection.data('template'));

            window.close();
        });
    });
</script>