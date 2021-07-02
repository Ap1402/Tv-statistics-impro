<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cargar Excel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ URL::asset('/css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bg-body1 {
            background-color: #2d2e5e;
        }

        .img-logo {
            height: 100px;
        }
    </style>
</head>

<body class="antialiased">

    <div class="reveal">
        <div class="slides">
            <div class="row my-3">
                <div class="col-6">
                    <img src="/logo-impro.png" class="img-logo" />
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h3 class="goalText" id="goalText"></h3>
                </div>
                <div class="col-6">
                    <h3 class="selledText" id="selledText"></h3>
                </div>
            </div>
            <section>
                <div class="container">
                    <div class=" text-light my-3">
                        <h4 class="bg-primary">
                            Actividad del día

                        </h4>
                    </div>
                    <div class="card shadow">
                        <div class="card-body">

                            <table class="table" id="table-sellers">
                                <thead>
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
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">

                    <div class="row">
                        <div class="col-6 mx-auto">
                            <div class="card shadow">
                                <div class="card-body">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
                            <div class="card shadow">
                                <div class="card-body">
                                    <canvas id="goalChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </section>
            <section>
                <div class="container">

                    <div class="row">
                        <div class="col-8 mx-auto">
                            <div class="card shadow">
                                <div class="card-header">
                                    Últimas cotizaciones
                                </div>

                                <div class="card-body">
                                    <table class="table" id="table-quotations">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                       <!--  <div class="col-6 mx-auto">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table class="table" id="table-orders">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>

                </div>


            </section>
        </div>
    </div>




    <script>
        window.onload = async function() {

            const MONTHS_LIST = {
                1: 'ENERO',
                2: 'FEBRERO',
                3: 'MARZO',
                4: 'ABRIL',
                5: 'MAYO',
                6: 'JUNIO',
                7: 'JULIO',
                8: 'AGOSTO',
                9: 'SEPTIEMBRE',
                10: 'OCTUBRE',
                11: 'NOVIEMBRE',
                12: 'DICIEMBRE',
            }

            let acum = 0;
            let test1 = null;
            let goalTotal = 0;

            async function tableCreate({
                data = null
            }) {

                const tbl = document.getElementById('table-sellers');

                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 2; i <= 7; i++) {
                    var tr = tbl.insertRow();
                    for (var j = 0; j < 7; j++) {
                        var td = tr.insertCell();
                        if (j >= 4) {
                            td.appendChild(document.createTextNode('$' + data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                        } else {

                            td.appendChild(document.createTextNode(data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                        }
                    }
                }
            }

            async function tableCreateLastQuotes({
                data = null
            }) {
                const tbl = document.getElementById('table-quotations');
                console.log(data)
                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 0; i < data.length; i++) {
                    var tr = tbl.insertRow();
                    tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_8']));
                    tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_3']));
                    tr.insertCell().appendChild(document.createTextNode('$ ' + data[i]['__EMPTY_11']));
                }
            }


            async function graphCreate({
                dataMonth = null
            }) {
                let labels = [];
                let data = [];
                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 2; i <= 7; i++) {
                    if ((i <= 7)) {
                        labels.push(dataMonth[i].__EMPTY_1);
                        acum += dataMonth[i].__EMPTY_7;
                        goalTotal += dataMonth[i].__EMPTY_9;
                        data.push(dataMonth[i].__EMPTY_7);
                    }
                }

                document.getElementById('goalText').innerText = 'Meta: $' + goalTotal;
                document.getElementById('selledText').innerText = 'Vendidos: $' + Math.round(acum);

                var ctx = document.getElementById('myChart').getContext('2d');
                var ctxGoal = document.getElementById('goalChart').getContext('2d');

                let percentFilled = Math.round((acum / goalTotal) * 100);
                let percentLeft = ((100 - percentFilled) >= 0) ? (100 - percentFilled) : 0;

                var goalChart = new Chart(ctxGoal, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            label: 'Total en ventas',
                            data: [percentLeft, percentFilled],
                            backgroundColor: [
                                'rgba(207, 50, 33, 1)',
                                'rgba(34, 51, 99, 1)',
                            ],
                            borderColor: [
                                'rgba(207, 50, 33, 1)',
                                'rgba(34, 51, 99, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {

                        scales: {
                            yAxes: [{
                                gridLines: {
                                    drawBorder: false,
                                },
                            }]
                        }
                    }
                });

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total en ventas',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }


            const readExcel = async (file) => {
                let oReq = new XMLHttpRequest();
                oReq.open("GET", "{{asset('storage/Cotizaciones.xlsx')}}", true);
                oReq.responseType = "arraybuffer";

                oReq.onload = function(e) {
                    let arraybuffer = oReq.response;

                    /* convert data to binary string */
                    let data = new Uint8Array(arraybuffer);
                    let arr = new Array();
                    for (let i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
                    let bstr = arr.join("");
                    /* Call XLSX */
                    let workbook = XLSX.read(bstr, {
                        type: "binary"
                    });

                    let wsname = workbook.SheetNames[6];
                    let wsnameMonth = workbook.SheetNames[7];
                    let wsnameGoals = workbook.SheetNames[9];
                    let wsnameQuotations = workbook.SheetNames[1];

                    const ws = workbook.Sheets[wsname];
                    const wsMonth = workbook.Sheets[wsnameMonth];
                    const wsGoals = workbook.Sheets[wsnameGoals];

                    const wsQuotations = workbook.Sheets[wsnameQuotations];

                    const test = XLSX.utils.sheet_to_json(ws);
                    const dataMonth = XLSX.utils.sheet_to_json(wsMonth);
                    const dataGoals = XLSX.utils.sheet_to_json(wsGoals);
                    const dataLastQuotes = XLSX.utils.sheet_to_json(wsQuotations);

                    console.log(dataLastQuotes)
                    tableCreate({
                        data: test
                    });
                    tableCreateLastQuotes({
                        data: dataLastQuotes.slice(Math.max(dataLastQuotes.length - 6, 1))
                    });
                    graphCreate({
                        dataMonth: dataMonth
                    })
                };
                oReq.send();
            };

            const result = await readExcel("{{asset('storage/Cotizaciones.xlsx')}}")


        }
    </script>

    <script src="{{ URL::asset('/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.0/dist/xlsx.full.min.js"></script>
</body>

</html>