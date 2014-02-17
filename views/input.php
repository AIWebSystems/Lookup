<div class="input-group">
    <a class="btn btn-danger input-group-addon" data-dismiss="lookup">
        <i class="fa fa-times"></i>
    </a>

    <?php echo form_hidden($field->formSlug, $field->value); ?>
    <?php echo form_input($field->formSlug.'_template', $template, 'class="form-control" disabled'); ?>

    <a data-href="<?php echo $url; ?>" class="btn btn-success input-group-addon" data-toggle="lookup">
        <i class="fa fa-search"></i>
    </a>
</div>