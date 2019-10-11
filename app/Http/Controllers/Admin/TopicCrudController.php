<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TopicRequest as StoreRequest;
use App\Http\Requests\TopicRequest as UpdateRequest;
use App\Http\Requests\TopicRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TopicCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TopicCrudController extends CrudController
{
    private static $ITEMS_COLUMN = [
        'name' => 'items',
        'label' => 'Items',
        'type' => 'select_multiple',
        'entity' => 'items',
        'attribute' => 'name',
        'model' => 'App\Models\Topic'
    ];

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Topic');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/topic');
        $this->crud->setEntityNameStrings('topic', 'topics');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->setColumns(['name', self::$ITEMS_COLUMN]);
        $this->crud->allowAccess('show'); // to show a "preview" button https://backpackforlaravel.com/docs/3.4/crud-buttons#default-buttons

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Topic name'
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from the topic name, if left empty.',
        ]);
        $this->crud->addField([
            'name' => 'description',
            'type' => 'simplemde',
            'label' => 'Description'
        ]);
        $this->crud->addField([
            'name' => 'cover_image',
            'type' => 'browse',
            'label' => 'Cover Image'
        ]);
        $this->crud->addField([
            'name' => 'items',
            'type' => 'items_sortable',
            'label' => 'Items'
        ], 'update');

        $this->crud->addField([
            'name' => 'previous_topic',
            'label' => 'Previous Topic',
            'type' => 'topic_link',
            'entity' => 'previousTopic',
        ]);

        $this->crud->addField([
            'name' => 'previous_topic_blurb',
            'label' => '',
            'type' => 'textarea',
            'attributes' => [
                'placeholder' => 'Intro text about previous topic',
            ],
            'wrapperAttributes' => [
                'style' => 'margin-top: -2em',
            ]
        ]);

        $this->crud->addField([
            'label' => 'Next Topic',
            'type' => 'select',
            'name' => 'next_topic_id',
            'entity' => 'nextTopic',
            'attribute' => 'name',
            'model' => 'App\Models\Topic',
            'options'   => (function ($query) {
                $entryId = $this->crud->getCurrentEntryId();
                if ($entryId) $query = $query->where('id', '!=', $entryId);

                return $query->orderBy('name', 'ASC')->get();
             }),
        ]);

        $this->crud->addField([
            'name' => 'next_topic_blurb',
            'label' => '',
            'type' => 'textarea',
            'attributes' => [
                'placeholder' => 'Intro text about next topic',
            ],
            'wrapperAttributes' => [
                'style' => 'margin-top: -2em',
            ]
        ]);

        // add asterisk for fields that are required in TopicRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $this->setPreviousTopic($request);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);

        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $entry = $this->crud->getCurrentEntry();
        $items = [];
        foreach ($request->get('items_sort', []) as $item_id => $order) {
            $items[$item_id] = ['order' => $order];
        }
        $entry->items()->sync($items);

        $this->setPreviousTopic($request);

        return $redirect_location;
    }

    public function show($id)
    {
        $content = parent::show($id);
        $this->crud->setColumns([
            'name',
            'slug',
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'markdown'
            ],
            [
                'name' => 'cover_image',
                'type' => 'image',
                'width' => '400px',
                'height' => '300px',
            ],
            self::$ITEMS_COLUMN,
            [
                'name' => 'previous_topic',
                'label' => 'Previous Topic',
                'type' => 'topic_link',
                'entity' => 'previousTopic',
            ],
            'previous_topic_blurb',
            [
                'label' => 'Next Topic',
                'name' => 'next_topic',
                'type' => 'topic_link',
                'entity' => 'nextTopic',
            ],
            'next_topic_blurb',
        ]);

        return $content;
    }

    private function setPreviousTopic(TopicRequest $request) {
        if ($request->get('next_topic_id') == null) return;

        $topic = $this->crud->entry;
        $nextTopic = $topic->nextTopic;
        $nextTopic->previousTopic()->associate($topic)->save();
    }
}
