<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TopicRequest as StoreRequest;
use App\Http\Requests\TopicRequest as UpdateRequest;
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

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();
        $this->crud->setColumns(['name', 'slug']);
        $this->crud->allowAccess('show'); // to show a "preview" button https://backpackforlaravel.com/docs/3.4/crud-buttons#default-buttons


        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Topic name"
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
            'label' => "Description"
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
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function show($id)
    {
        $content = parent::show($id);

        // $this->crud->with('items');

        // $this->crud->addColumn([
        //     'name' => 'items',
        //     'label' => 'Items',
        //     'type' => 'table',
        //     'columns' => [
        //         'id'  => 'ID',
        //         'type'  => 'Type',
        //         'name'  => 'Name',
        //         'text'  => 'Text',
        //     ]
        // ]);

        $this->crud->addColumn('name');
        // $this->crud->addColumn('type');
        $this->crud->addColumn([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'markdown'
        ]);
        $this->crud->addColumn([
            'label' => "Items",
            'type' => "select_multiple",
            'name' => 'items',
            'entity' => 'items',
            'attribute' => "name",
            'model' => "App\Models\Topic", // foreign key model
        ]);
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Created At',
            'type' => 'datetime'
        ]);



        return $content;
    }
}
