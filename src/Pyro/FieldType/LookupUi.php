<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\Ui\EntryUi;

class LookupUi extends EntryUi
{
    /**
     * Template
     *
     * @var null
     */
    public $template = null;

    /**
     * Create a new ContactEntryLookupUi instance
     */
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

        ci()->lang->load('people/people');
    }

    /**
     * Boot
     *
     * @return array|void
     */
    public function boot()
    {
        parent::boot();

        // Scope
        $scope = $this->getScope();

        // Default template
        if (!$this->template) {
            $this->template = '{{ ' . $this->getTitleColumn() . ' }}';
        }

        // On query
        $this->onQuery(
            function ($query) use ($scope) {
                if ($scope) {
                    return $query->{$scope}();
                }
            }
        );

        // Buttons
        $this->buttons = array(
            array(
                'label'         => '<i class="fa fa-check"></i>',
                'data-toggle'   => 'select',
                'data-id'       => '{{ id }}',
                'data-template' => $this->template,
                'class'         => 'btn-sm btn-success',
            ),
        );
    }
}
