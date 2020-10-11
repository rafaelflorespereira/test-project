<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>The Rabbit Test</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <table-contents
                subjects="{{json_encode($subjects)}}"
                messages="{{json_encode($messages)}}"
            ></table-contents>
        </div>
       {{--  <table style="width:100%">
            <tr>
                <th>Subjects: </th>
                <th>Messages: </th>
            </tr>
            @foreach ($subjects as $key => $subject)
            @if (is_array($subject))
            @foreach ($subject as $i => $item)
                <tr>
                    <td> {{ $item }}</td>
                    <td> {{ $messages[$key][$i] }} </td>
                </tr>
                @endforeach
                @endif
            @endforeach
        
        </table> --}}
    </body>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        th, td {
        padding: 5px;
        text-align: left;    
        }
    </style>
</html>
