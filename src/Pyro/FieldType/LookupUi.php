<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\Ui\EntryUi;

class LookupUi extends EntryUi
{
    /**
     * Create a new LookupUi instance
     */
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * Boot
     *
     * @return array|void
     */
    public function boot()
    {
        parent::boot();

        // Title
        if (!$this->getTitle()) {
            $this->title(lang('streams:lookup.name'));
        } else {
            $this->title($this->getTitle());
        }

        // Clone
        $ui = $this;

        // On query
        $this->onQuery(
            function ($query) use ($ui) {
                if ($ui->getScope()) {
                    return $query->{$ui->getScope()}();
                }
            }
        );

        // Buttons
        $this->buttons = array(
            array(
                'url'           => '#',
                'label'         => '<i class="fa fa-check"></i>',
                'data-toggle'   => 'select',
                'data-id'       => '{{ id }}',
                'data-template' => $this->template,
                'class'         => 'btn-sm btn-success',
            ),
        );
    }
}
