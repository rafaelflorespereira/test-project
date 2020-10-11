<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Rabbit Test</title>
</head>
<body>
    <form action="{{ route('storeFile') }}" enctype="multipart/form-data" method="POST">
        <div>
            <label for="myFile">Select a CSV file:</label>
            <input type="file" id="myFile" name="myFile">

            {{-- the template must be in here --}}
            <div>

                <label for="subject">1 - Input a subject:</label>
                <input type="text" id="subject" name="subject[]">
            </div>
            <div>

                <label for="message1">1 - Input a message:</label>
                <textarea name="message[]" id="message1" cols="30" rows="10"></textarea>
            </div>
            <br>
            <div>

                <label for="subject2">2 - Input a subject:</label>
                <input type="text" id="subject2" name="subject[]">
            </div>
            <div>

                <label for="message2">2 - Input a message:</label>
                <textarea name="message[]" id="message2" cols="30" rows="10"></textarea>
            </div>
        </div>
        <button type="submit">Enviar</button>
        {{ csrf_field()  }}
    </form>
</body>
</html>