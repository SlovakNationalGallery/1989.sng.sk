<!-- items sortable -->
@php
    $options = \App\Models\Item::all();
@endphp

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>

    <table class="table table-sm table-striped" id="table">
        <tbody>
        @foreach ($field['value'] as $item)
            <tr class="array-row item">
                <td>
                    {{ $item->full_name  }}
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

    <div class="input-group">
    <select multiple name="items[]" id="items" class="form-control select2_multiple">
       @foreach ($options as $option)
           {{-- list only unused options --}}
           @if( !(in_array($option->getKey(), $field['value']->pluck($option->getKeyName(), $option->getKeyName())->toArray())))
               <option value="{{ $option->getKey() }}" data-type="{{ $option->type }}">{{ $option->full_name }}</option>
           @endif
       @endforeach
    </select>
    <span class="input-group-btn">
      <button id="addItems" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp; add items</button>
    </span>
    </div><!-- /input-group -->

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

        <!-- include select2 css-->
        <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')
        <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2_multiple box
                $('.select2_multiple').each(function (i, obj) {
                    if (!$(obj).hasClass("select2-hidden-accessible"))
                    {
                        var $obj = $(obj).select2({
                            theme: "bootstrap"
                        });

                        var options = [];
                        @if (count($options))
                            @foreach ($options as $option)
                                options.push({{ $option->getKey() }});
                            @endforeach
                        @endif
                    }
                });

                $('#addItems').on('click', function (e) {
                     e.preventDefault();
                     $('#items  > option:selected').each(function() {
                         $('#table > tbody').append('<tr class="array-row item"><td>' + $(this).text() + '</td><td>' + $(this).data('type') + '</td><td><input class="sorter form-control" size="2" data-id="' + $(this).val() + '" value="0" name="items_sort[' + $(this).val() + ']"></td><td><span class="btn btn-sm btn-light sort-handle pull-right ui-sortable-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span></td><td><button data-id="' + $(this).val() + '" class="btn btn-sm btn-light removeItem" type="button"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button></td></tr>');
                     });
                     reorder();
                     $("#items").val([]).change();
                 });


            });
        </script>

        <script src="{{ asset('vendor/adminlte/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

        <script type="text/javascript">
            $('.removeItem').unbind().click(function () {
                let id = $(this).attr('data-id');
                $(this).parent().parent().remove();
                reorder();
            });
            $('#table tbody').sortable({
                connectWith: "#items_sort option",
                axis: "y",
                handle: ".sort-handle",
                placeholder: "array-row item item-placeholder ui-state-highlight",
                cursor: "move",
                opacity: 0.8,
                update: function() {
                  reorder();
                }
             }).disableSelection();

             $('input.sorter').on('keypress', function (e) {
                 if(e.key === "Enter"){
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
