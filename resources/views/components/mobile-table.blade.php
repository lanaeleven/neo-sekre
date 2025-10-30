@props([
    'tableHeader' => [],
    'rows' => [],
])

@foreach ($rows as $row)
        <div class="card shadow mb-2">
            <table class="table table-bordered">
                @foreach ($tableHeader as $index => $label)
                    @if ($loop->last)
                        <tr>
                            <td colspan="2" class="text-center">
                                {!! $row[$index] !!}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>{{ $label }}</th>
                            <td>{{ $row[$index] }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
@endforeach
