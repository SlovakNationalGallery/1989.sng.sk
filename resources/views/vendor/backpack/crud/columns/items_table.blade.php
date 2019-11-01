@php
    $results = data_get($entry, $column['name']);
@endphp

<span>
    <table class="table table-sm table-striped" id="table">
        <tbody>
        @foreach ($results as $item)
            <tr class="array-row item">
                <td>
                    {{ $item->full_name  }}
                </td>
                <td>
                    {{ $item->type  }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</span>