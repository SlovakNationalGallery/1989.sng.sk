<!-- field_type_name -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>

    <table class="table table-sm table-striped" id="table">
        {{-- <p>Connected items:</p> --}}
        <select hidden multiple name="items[]" id="items">
           @foreach ($field['value'] as $item)
               <option selected data-id="{{ $item->id  }}"  value="{{ $item->id  }}">{{ $item->name  }}</option>
           @endforeach
        </select>

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
                    <input class="sorter form-control" size="2" data-id="{{ $item->id }}" value="{{ $item->pivot->order }}" name="items_sort[{{ $item->id }}]">
                </td>
                <td>
                    <span class="btn btn-sm btn-light sort-handle pull-right ui-sortable-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                </td>
                <td>
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
                $(`#items [data-id=${id}]`).remove();
                $(this).parent().parent().remove();
                reorder();
            });
            $('#table tbody').sortable({
                connectWith: "#items_sort option",
                containment: "parent",
                handle: ".sort-handle",
                placeholder: "array-row item item-placeholder ui-state-highlight",
                cursor: "move",
                opacity: 0.8,
                update: function() {
                  reorder();
                }
             }).disableSelection();

             $('input.sorter').on('keypress', function (e) {
                 if(e.which === 13){
                    var position = $(this).val();
                    $(this).closest('tr').insertAfter($(`#table tbody tr:eq(${position})`));
                    reorder();
                    e.preventDefault();
                 }
              });

             function reorder() {
                 var i = 0;
                  $("input.sorter").each(function() {
                     $(this).val(i);
                     i++;
                  });
             }
        </script>
    @endpush
@endif
