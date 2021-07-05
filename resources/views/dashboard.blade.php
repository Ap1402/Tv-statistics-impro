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
    </style>
</head>

<body class="antialiased">

    <div class="reveal">
        <div class="slides">
            <div class="row my-3">
                <div class="col-6 my-auto">
                    <img src="/logo-impro.png" class="img-logo" />
                </div>
                <div class="col-6 my-auto row">
                    <h3 id="monthText" class="col-auto mx-auto p-3 rounded text-light fw-bold" style="background-color:#004880;"></h3>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6 row">
                    <img src="/goal.png" class="col-6 " style="height:50px; width:auto; margin: auto 0 auto auto;" />
                    <h3 class="goalText fw-bold col-6 me-auto" id="goalText">



                    </h3>
                </div>
                <div class="col-6 row">
                    <h3 class="selledText col-auto mx-auto fw-bold" id="selledText"></h3>
                </div>
            </div>
            <section data-background-image="/logo-impro.png" data-background-size="600px" data-background-opacity="0.3" data-background-position="100% 100%">
                <div class="container">
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
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section data-background-image="/logo-impro.png" data-background-size="600px" data-background-opacity="0.3" data-background-position="0% 100%">
                <div class="container">

                    <div class="row">
                        <div class="col-6 mx-auto">
                            <div class="card shadow">
                                <div class="card-header table-header text-light fs-3 my-3">
                                    Ventas en el mes
                                </div>
                                <div class="card-body" id="myChartDiv">
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
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
            <section data-background-image="/logo-impro.png" data-background-size="600px" data-background-opacity="0.3" data-background-position="100% 100%">
                <div class="container">

                    <div class="row">
                        <div class="col-6 mx-auto">
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
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
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
                                        <tbody></tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </section>
        </div>
    </div>




    <script>
        window.onload = loadData;

        function formatNumber(number) {

            return number.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });
        }

        window.setInterval(function() {
            loadData();
        }, 60000);

        async function loadData() {

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

            var date = new Date();
            var month = date.getMonth();
            var day = date.getDate();
            console.log('date:', date)

            document.getElementById('monthText').innerText = day + ' de ' + MONTHS_LIST[month];

            let acum = 0;
            let test1 = null;
            let goalTotal = 0;

            async function tableCreate({
                data = null
            }) {


                const tbl = document.getElementById('table-sellers').getElementsByTagName('tbody')[0];
                tbl.innerHTML = '';

                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 2; i <= 7; i++) {
                    var tr = tbl.insertRow();
                    for (var j = 0; j < 7; j++) {
                        var td = tr.insertCell();
                        if (j >= 4) {
                            td.appendChild(document.createTextNode(formatNumber(data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')])));
                        } else {

                            td.appendChild(document.createTextNode(data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                        }
                    }
                }
            }

            async function tableCreateLastQuotes({
                data = null
            }) {
                const tbl = document.getElementById('table-quotations').getElementsByTagName('tbody')[0];
                tbl.innerHTML = '';

                console.log(data)
                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 0; i < data.length; i++) {
                    var tr = tbl.insertRow();
                    tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_8']));
                    tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_3']));
                    tr.insertCell().appendChild(document.createTextNode(formatNumber(data[i]['__EMPTY_11'])));
                }
            }



            async function tableCreateLastOrders({
                data = null
            }) {
                const tbl = document.getElementById('table-orders').getElementsByTagName('tbody')[0];
                tbl.innerHTML = '';
                let lastOrders = [];
                for (var i = data.length - 1; i >= -1; i--) {
                    if (data[i].__EMPTY_4 === 'O.C') {
                        lastOrders.push(data[i]);
                        if (lastOrders.length > 3) {
                            break;
                        }
                    }
                }

                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 0; i < lastOrders.length; i++) {
                    var tr = tbl.insertRow();
                    tr.insertCell().appendChild(document.createTextNode(lastOrders[i]['__EMPTY_8']));
                    tr.insertCell().appendChild(document.createTextNode(lastOrders[i]['__EMPTY_3']));
                    tr.insertCell().appendChild(document.createTextNode(formatNumber(lastOrders[i]['__EMPTY_11'])));
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

                document.getElementById('goalText').innerText = 'Meta: ' + formatNumber(goalTotal);
                document.getElementById('selledText').innerText = 'Vendidos: ' + formatNumber(Math.round(acum));

                var ctx = document.createElement('canvas');
                document.getElementById('myChartDiv').innerHTML = '';
                document.getElementById('myChartDiv').appendChild(ctx);


                var ctxGoal = document.createElement('canvas');
                ctxGoal.setAttribute('class', 'mx-auto')
                document.getElementById('goalChartDiv').innerHTML = '';
                document.getElementById('goalChartDiv').appendChild(ctxGoal);

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
                        responsive: false,

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

                    tableCreateLastOrders({
                        data: dataLastQuotes
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