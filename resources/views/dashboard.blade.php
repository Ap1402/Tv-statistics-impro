<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cargar Excel</title>

    <!-- Fonts -->
    <link href="{{ URL::asset('/css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bg-body1 {
            background-color: #2d2e5e;
        }

        .img-logo {
            height: 130px;
        }

        tbody {
            font-size: 24px;
        }

        thead {
            font-size: 20px;
        }

        .table-header {
            background-color: #2d2e5e;
        }

        .bg-orange {
            background-color: #003d8c;
        }

        .strip>tbody>tr:nth-child(2n+1)>td,
        .strip>tbody>tr:nth-child(2n+1)>th {
            background-color: rgb(99, 93, 133, 0.1);
        }

        .total-row>tbody>tr:last-child>td {
            background-color: rgb(34, 62, 107, 0.8);
            color: white;
        }

        .selledText,
        .goalText {
            font-size: 45px;
        }
    </style>
</head>

<body class="antialiased">

    <div class="reveal">
        <div class="slides">
            <div class="row my-3">
                <div class="col-6 my-auto">
                    <img src="/logo-impro.png" class="img-logo" />

                </div>
                <div class="col-5 my-auto row mx-auto">
                    <h3 class="goalText fw-bold col-auto mx-auto" id="goalText" style="margin-top:30px;">
                        <h3 class="selledText col-auto mx-auto fw-bold" id="selledText"></h3>

                        <h3 id="monthText" class="col-auto mx-auto p-3 rounded text-light fw-bold d-none" style="background-color:#004880;"></h3>
                </div>
            </div>
            <div class="row mb-3 d-none">
                <div class="col-6 row">
                    <h3 class="goalText fw-bold col-6 me-auto" id="goalText">

                    </h3>
                </div>
                <div class="col-6 row">
                    <h3 class="selledText col-auto mx-auto fw-bold" id="selledText"></h3>
                </div>
            </div>
            <section data-transition="convex" data-background-image="/logo-impro.png" data-background-size="700px" data-background-opacity="0.3" data-background-position="50% 100%">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class=" text-light my-3 mx-auto row ms-1">
                                <h4 class="mx-auto col-auto table-header fs-2">
                                    Actividad del día

                                </h4>
                            </div>
                            <div class="card shadow">
                                <div class="card-body">

                                    <table class="table strip total-row" id="table-sellers">
                                        <thead class="table-header text-light">
                                            <tr>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Cot Enviadas</th>
                                                <th scope="col">Cot Perdidas</th>
                                                <th scope="col">Ordenes recibidas</th>
                                                <th scope="col">Total COT</th>
                                                <th scope="col">Total COT perdidas</th>
                                                <th scope="col">Total OC</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:45px;">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section data-transition="convex" data-background-image="/logo-impro.png" data-background-size="700px" data-background-opacity="0.3" data-background-position="50% 100%">
                <div class="container">

                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card shadow">
                                <div class="card-header table-header text-light fs-3 my-3">
                                    Ventas en el mes
                                </div>
                                <div class="card-body" id="myChartDiv">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mx-auto d-none">
                            <div class="card shadow">
                                <div class="card-header bg-orange text-light fs-3 my-3">
                                    Total completado de la meta
                                </div>
                                <div class="card-body" id="goalChartDiv">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </section>
            <section data-transition="convex" data-background-image="/logo-impro.png" data-background-size="700px" data-background-opacity="0.3" data-background-position="50% 100%">
                <div class="container">

                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card shadow">
                                <div class="card-header bg-orange text-light fs-3 my-3">
                                    Últimas cotizaciones
                                </div>

                                <div class="card-body">
                                    <table class="table strip" id="table-quotations">
                                        <thead class="table-header text-light">
                                            <tr>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:50px;">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </section>
            <section data-transition="convex" data-background-image="/logo-impro.png" data-background-size="700px" data-background-opacity="0.3" data-background-position="50% 100%">
                <div class="container">

                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card shadow">
                                <div class="card-header table-header text-light fs-3 my-3">
                                    Últimas ordenes
                                </div>
                                <div class="card-body">
                                    <table class="table strip" id="table-orders">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:50px;">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </section>
            <section data-transition="convex" data-background-image="/logo-impro.png" data-background-size="700px" data-background-opacity="0.3" data-background-position="50% 100%">
                <div class="container">

                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table class="table strip" id="table-goals">
                                        <thead class="table-header text-light" style="font-size:40px;">
                                            <tr>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Vendido</th>
                                                <th scope="col">Meta</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:50px;"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </section>
        </div>
    </div>



    <script src="{{ URL::asset('/js/app.js') }}"></script>


    <script src="{{ URL::asset('/js/presentation.js') }}"></script>

</body>

</html>