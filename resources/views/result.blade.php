<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'roboto';
            font-weight: 400;
            font-style: normal; 
            src: url('./roboto/Roboto-Light.ttf') format("truetype");
        }

        @font-face {
            font-family: 'robotoBold';
            font-weight: bold;
            font-style: normal; 
            src: url('./roboto/Roboto-Bold.ttf') format("truetype");
        }

        /** Defina ahora los márgenes reales de cada página en el PDF **/
        body {
            font-family: 'robotoBold','roboto'!important;
            margin-top: 5cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Definir las reglas del encabezado **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;

            /** Estilos extra personales **/
            color: white;
            text-align: center;
            line-height: 1.5cm;
        }

        /** Definir las reglas del pie de página **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            /** Estilos extra personales **/
            background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 1.5cm;
        }

        /* aaaaaaaaa */
        .info-left {
            float: left;
            width: 50%;
            display: inline-block;
        }

        .info-right {
            float: right;
            width: 50%;
        }
        .img-header{
            /* background-image: url('./header.png'); */
            width: 100%!important;
        }
    </style>

    <title>Test Report</title>
</head>

<body>
    <header>
        <img class="img-header" src="./header.png" alt="">
        <br>
    </header>

    <main>
        <div>
            <div class="float-parent-element">
                <span class="info-left">
                    <p><b>Nombre</b>: {{ $test->patient->name }}</p>
                </span>
                <span class="info-right">
                    <p style="padding-left: 40%;">{{ $test->date }}</p>
                </span>
            </div>
        </div>

        <br>
        <br>
        <div>
            <div class="float-parent-element">
                <span class="info-left">
                    <p><b>Programa Integral de Cultura de Paz</b></p>
                </span>
                <span class="info-right">
                    <p style="padding-left: 40%;"><b>Folio</b>: {{ $test->patient->invoice }}</p>
                </span>
            </div>
        </div>
        <x-test_escala_de_ansiedad_de_hamilton :test="$test"></x-test_escala_de_ansiedad_de_hamilton>

        <footer>
            <p>bbb</p>
        </footer>
    </main>
</body>

</html>
