<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BRIGHTLY KÁVÉGÉP</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Kavágép Automata</a>
            </div>
        </nav>

        <div id="app">
            <machine-component></machine-component>
        </div>
        

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-5">
            <div class="container justify-content-center">
                <span class="text-white text-center pt-3 pb-3">Copyright © 2019 - Minden jog fenntartva.</span>
            </div>
        </nav>
    
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
