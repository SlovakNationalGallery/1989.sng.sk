<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ItemRequest as StoreRequest;
use App\Http\Requests\ItemRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ItemCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Item');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/item');
        $this->crud->setEntityNameStrings('item', 'items');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();
        $this->crud->setColumns(['name', 'type']);
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Item name"
        ]);
        $this->crud->addField([
            'name' => 'type',
            'type' => 'enum',
            'label' => "Type"
        ]);
        $this->crud->addField([
            'name' => 'text',
            'type' => 'simplemde',
            'label' => "Text"
        ]);
        $this->crud->addField([
            'name' => 'file',
            'type' => 'browse',
            'label' => "Media"
        ]);

        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'topics', // the relationship name in your Model
            'entity' => 'topics', // the relationship name in your Model
            'attribute' => 'name', // attribute on Article that is shown to admin
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ], 'update');


        // add asterisk for fields that are required in ItemRequest
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
}
