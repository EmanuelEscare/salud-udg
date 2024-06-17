<!DOCTYPE html>
<html>
<head>
    <title>Salud Mental Universitaria - UDG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #0056b3;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .button:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $mailData['title'] }}</h1>
        <p>{{ $mailData['body'] }}</p>
        <a href="{{ route('verificar-cita',$mailData['token']) }}" class="button">Confirmar</a>
        <br>
        <p>Saludos,</p>
        <p>Equipo de Salud Mental Universitaria - UDG</p>
    </div>
</body>
</html>

