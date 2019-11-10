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

        $this->crud->setColumns(['name', 'category']);

        $this->crud->addColumn([
            'name' => 'is_active',
            'label' => 'Is active',
            'type' => 'boolean',
        ]);
        
        $this->crud->addColumn([
            'name' => 'is_visible',
            'label' => 'Is visible',
            'type' => 'boolean',
        ]);

        $this->crud->addColumn([
            'name' => 'items',
            'label' => 'Items',
            'type' => 'array_count',
        ]);

        $this->crud->addColumn([
            'name' => 'updated_at',
            'label' => 'Updated at',
            'type' => 'datetime',
        ]);

        $this->crud->addFilter([
            'name' => 'category',
            'type' => 'dropdown',
            'label' => 'Category'
        ], function () {
            return \App\Models\Topic::$available_categories;
        }, function ($value) {
            $this->crud->addClause('where', 'category', $value);
        });

        $this->crud->addFilter(
            [
                'type' => 'simple',
                'name' => 'active',
                'label' => 'Active'
            ],
            false,
            function () {
                $this->crud->addClause('active');
            }
        );


        $this->crud->allowAccess('show'); // to show a "preview" button https://backpackforlaravel.com/docs/3.4/crud-buttons#default-buttons

        $this->crud->addButtonFromView('line', 'position', 'position', 'beginning');

        $this->crud->addField([
            'name' => 'category',
            'type' => 'select_from_array',
            'label' => 'Category',
            'allows_null' => true,
            'options' => \App\Models\Topic::$available_categories,
        ]);
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
        $this->crud->addField([
            'name' => 'is_active',
            'type' => 'checkbox',
            'label' => 'Is active',
            'hint' => 'Will be not displayed on frontend until is published'
        ]);
        $this->crud->addField([
            'name' => 'is_visible',
            'type' => 'checkbox',
            'label' => 'Is visible',
            'hint' => 'Will not be listed in list until checked'
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
        $model = $this->crud->getModel();

        $this->crud->setColumns([
            [
                'name' => 'category',
                'label' => 'Category',
                'type' => 'select_from_array',
                'options' => $model::$available_categories,
            ],
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
                'height' => 'auto',
            ],
            [
                'name' => 'items',
                'label' => 'Items',
                'type' => 'items_table',
            ],
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
            [
                'label' => 'Is active',
                'name' => 'is_active',
                'type' => 'boolean',
            ],
            [
                'label' => 'Is visible',
                'name' => 'is_visible',
                'type' => 'boolean',
            ],
            [
                'label' => 'Created at',
                'name' => 'created_at',
                'type' => 'datetime',
            ],
            [
                'label' => 'Updated at',
                'name' => 'updated_at',
                'type' => 'datetime',
            ],
        ]);

        return $content;
    }

    private function setPreviousTopic(TopicRequest $request)
    {
        if ($request->get('next_topic_id') == null) return;

        $topic = $this->crud->entry;
        $nextTopic = $topic->nextTopic;
        $nextTopic->previousTopic()->associate($topic)->save();
    }
}
