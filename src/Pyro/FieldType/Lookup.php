<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Lookup Field Type
 *
 * @author      Ryan Thompson - AI Web Systems, Inc.
 * @copyright   Copyright (c) 2008 - 2014, AI Web Systems, Inc.
 * @link        http://www.aiwebsystems.com/
 */
class Lookup extends FieldTypeAbstract
{
    /**
     * Field type slug
     *
     * @var string
     */
    public $field_type_slug = 'lookup';

    /**
     * Database column type
     *
     * @var bool
     */
    public $db_col_type = 'integer';

    /**
     * Version
     *
     * @var string
     */
    public $version = '1.1';

    /**
     * Custom parameters
     *
     * @var array
     */
    public $custom_parameters = array(
        'title',
        'template',
        'relation_class',
        'ui',
    );

    /**
     * Author
     *
     * @var array
     */
    public $author = array(
        'name' => 'Ryan Thompson - AI Web Systems, Inc.',
        'url'  => 'http://www.aiwebsystems.com/'
    );

    /**
     * Relation
     *
     * @return object The relation object
     */
    public function relation()
    {
        return $this->belongsTo($this->getRelationClass());
    }

    /**
     * Field event
     */
    public function fieldEvent()
    {
        $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,';
        $options .= 'width=800,';
        $options .= 'height=500';

        $data = array(
            'options' => $options,
        );

        $this->appendMetadata($this->view('fragments/lookup.js.php', $data));
    }

    /**
     * Form input
     *
     * @return array
     */
    public function formInput()
    {
        $relation = $this->getParameter('relation_class');
        $relation = new $relation;

        $ui = $this->getParameter('ui_class');
        $ui = new $ui;

        $stream = $relation->getStream();

        if ($this->value) {
            $entry = $relation->find($this->value);

            $template = $this->getParameter('template', $ui->template ? : '{{ ' . $stream->title_column . ' }}');
            $template = ci()->parser->parse_string($template, $entry, true, false, false);
        } else {
            $entry = $template = null;
        }

        $uri = 'streams_core/ajax/field/lookup/table/' . $this->getFormSlugPrefix() . $this->field->field_slug;
        $url = site_url($uri);

        $data = array(
            'field'    => $this,
            'template' => $template,
            'url'      => $url,
        );

        return $this->view($this->getParameter('input_view', 'input'), $data);
    }

    /**
     * String output
     *
     * @return  mixed   null or string
     */
    public function stringOutput()
    {
        if ($relatedModel = $this->getRelationResult()) {
            if (!$relatedModel instanceof RelationshipInterface) {
                throw new ClassNotInstanceOfRelationshipInterfaceException;
            }

            return $relatedModel->getFieldTypeRelationshipTitle();
        }

        return null;
    }

    /**
     * Plugin output
     *
     * @return array
     */
    public function pluginOutput()
    {
        if ($relatedModel = $this->getRelationResult()) {
            return $relatedModel;
        }

        return null;
    }

    /**
     * Data output
     *
     * @return RelationClassModel
     */
    public function dataOutput()
    {
        if ($relatedModel = $this->getRelationResult()) {
            return $relatedModel;
        }

        return null;
    }

    /**
     * Ajax table
     *
     * @return string
     */
    public function ajaxTable()
    {
        list($namespace, $stream, $slug) = explode('-', ci()->uri->segment(6));

        $fieldStream = StreamModel::findBySlugAndNamespace($stream, $namespace);

        $field = FieldModel::findBySlugAndNamespace($slug, $namespace);
        $field = $field->getType();

        $field->setStream($fieldStream);

        $relation = $field->getParameter('relation_class');
        $relation = new $relation;

        $stream = $relation->getStream();

        $attributes = $this->getAttributes($field);

        $ui = $field->getParameter('ui_class', 'Pyro\FieldType\LookupUi');
        $ui = new $ui($attributes);

        $table = $ui->table($relation)->render(true);

        $data = array(
            'field'   => $field,
            'content' => $table,
        );

        return ci()->template
            ->set_layout('popup')
            ->append_metadata($field->view('fragments/ajax.js.php', $data))
            ->build('admin/partials/blank_section', $data);
    }

    /**
     * Get column name
     *
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }

    /**
     * Get attributes
     *
     * @param $field
     */
    private function getAttributes($stream)
    {
        $attributes = array(
            'titleColumn' => $stream->title_column,
        );

        // Title
        if ($title = $this->getParameter('title')) {
            $attributes['title'] = $title;
        }

        // Template
        if ($template = $this->getParameter('template')) {
            $attributes['template'] = $template;
        }

        // Scope
        if ($scope = $this->getParameter('scope')) {
            $attributes['scope'] = $scope;
        }

        return $attributes;
    }
}
