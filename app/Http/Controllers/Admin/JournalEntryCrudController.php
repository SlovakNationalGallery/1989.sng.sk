<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\JournalEntryRequest as StoreRequest;
use App\Http\Requests\JournalEntryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class JournalEntryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class JournalEntryCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\JournalEntry');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/journal-entries');
        $this->crud->setEntityNameStrings('Journal Entry', 'Journal Entries');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            ['name' => 'written_at', 'type' => 'date'],
            ['name' => 'weather', 'type' => 'string'],
            ['name' => 'content', 'type' => 'string'],
        ]);

        $this->crud->addFields([
            ['name' => 'written_at', 'type' => 'text', 'attributes' => ['readonly' => 'readonly']],
            ['name' => 'weather'],
            [
                'name' => 'excerpt',
                'type' => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['insert', ['link']],
                    ],
                ]
            ],
            [
                'name' => 'content',
                'type' => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['insert', ['link']],
                    ],
                ]
            ],
        ]);

        // add asterisk for fields that are required in JournalEntryRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->allowAccess('show');
        $this->crud->denyAccess('delete');
    }

    public function show($id)
    {
        $content = parent::show($id);

        $this->crud->addColumns([
            [
                'name' => 'content',
                'type' => 'model_function',
                'function_name' => 'getFormattedContent',
                'limit' => -1,
            ],
        ]);


        return $content;
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
