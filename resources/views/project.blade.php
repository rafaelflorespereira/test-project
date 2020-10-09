<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Rabbit Test</title>
</head>
<body>
    <form action="{{ route('readFile') }}" enctype="multipart/form-data" method="POST">
        <div>
            <label for="myFile">Select a file:</label>
            <input type="file" id="myFile" name="myFile">
        </div>
        <button type="submit">Enviar</button>
        {{ csrf_field()  }}
    </form>
</body>
</html>