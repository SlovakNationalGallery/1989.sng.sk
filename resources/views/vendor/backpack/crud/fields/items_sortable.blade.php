{{-- @redlist:
https://backpackforlaravel.com/docs/3.6/crud-fields#creating-a-custom-field-type
https://stackoverflow.com/questions/51136019/how-to-make-sortable-select-multiply-in-laravel-backpack

 --}}

<!-- field_type_name -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    {{--
    <input
        type="text"
        name="{{ $field['name'] }}"
        value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
        @include('crud::inc.field_attributes')
    >
     --}}

     <table class="table table-sm table-striped" id="table">
         {{-- <p>Connected items:</p> --}}
         <select hidden multiple name="items[]" id="items">
            @foreach ($field['value'] as $item)
                <option selected data-id="{{ $item->id  }}"  value="{{ $item->id  }}">{{ $item->name  }}</option>
            @endforeach
        </select>

        <select hidden multiple name="items_sort[]" id="items_sort">
            @foreach  ($field['value'] as $item)
                <option data-id="{{ $item->id }}" selected  value="{{ $item->pivot->order  }}">{{ $item->pivot->order  }}</option>
            @endforeach
        </select>

        {{-- <thead>
            <tr>
                <th style="font-weight: 600!important;">
                    Name
                </th>
                <th style="font-weight: 600!important;">
                    Type
                </th>
                <th class="text-center">  </th>
                <th class="text-center">  </th>
                <th class="text-center">  </th>
            </tr>
        </thead> --}}

        <tbody>
        @foreach ($field['value'] as $item)
            <tr class="array-row item">
                <td>
                    {{ $item->name  }}
                </td>
                <td>
                    {{ $item->type  }}
                </td>
                <td>
                    <input class="sorter form-control" size="2" data-id="{{ $item->id }}" value="{{ $item->pivot->order }}">
                </td>
                <td>
                    <span class="btn btn-sm btn-light sort-handle pull-right ui-sortable-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                </td>
                <td>
                    {{-- <span data-id="{{ $item->id  }}" class="btn btn-primary remover">Remove</span> --}}
                    <button data-id="{{ $item->id  }}" class="btn btn-sm btn-light removeItem" type="button"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@if ($crud->checkIfFieldIsFirstOfItsType($field))
  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

      @push('crud_fields_styles')
          <style type="text/css">
              .array-row.item-placeholder {
                background: #fdfd96;
                margin: 0;
                height: 50px;
              }
          </style>
      @endpush

  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

      @push('crud_fields_scripts')
          <script src="{{ asset('vendor/adminlte/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

          <script type="text/javascript">
              $('.removeItem').unbind().click(function () {
                  let id = $(this).attr('data-id');
                  $(`#items [data-id=${id}], #items_sort [data-id=${id}]`).remove();
                  $(this).parent().parent().remove();
              });
              $('#table tbody').sortable({
                  // connectWith: "",
                  containment: "parent",
                  handle: ".sort-handle",
                  placeholder: "array-row item item-placeholder ui-state-highlight"
               }).disableSelection();
          </script>
      @endpush
@endif
