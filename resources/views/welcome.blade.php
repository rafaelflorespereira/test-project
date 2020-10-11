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
        <table style="width:100%">
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
        
        </table>
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
