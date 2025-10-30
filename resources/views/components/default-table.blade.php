@props([
    'tableHeader' => [],
    'rows' => [],
])

<table class="table table-hover table-bordered mt-2">
    <thead>
        <tr>
            @foreach ($tableHeader as $th)
                <th scope="col" class="sticky-header" style="background-color: #f0f0f0; color: #000;">{{ $th }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($rows as $row)
            <tr>
                @foreach ($row as $cell)
                    @if ($loop->last)
                        <td class="py-0">{!! $cell !!}</td>
                    @else
                        <td>{{ $cell }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
