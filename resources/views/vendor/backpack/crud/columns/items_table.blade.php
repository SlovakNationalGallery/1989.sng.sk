@php
    $results = data_get($entry, $column['name']);
@endphp

<span>
    <table class="table table-sm table-striped" id="table">
        <tbody>
        @foreach ($results as $item)
            <tr class="array-row item">
                <td>
                    @if ($item->preview)
                        <img src="{{ asset($item->preview) }}" alt="{{ $item->full_name }}" style="height: 50px; width: auto">
                    @endif
                </td>
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