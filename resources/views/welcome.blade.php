<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->  
    </head>
    <body>
        <table>
            <tr>
                @foreach ($headers as $header)
                    @foreach ($header as $item)
                        <th>{{$item}}</th>
                    @endforeach
                @endforeach
            </tr>
            @foreach ($rows as $row)
                <tr>
                    @if (is_array($row))
                        @foreach ($row as $key => $col)
                            {{-- @dd($row, $col, $key) --}}
                            <td>{{$col ?? '' }}</td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
        </table>
    </body>
</html>
