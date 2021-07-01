<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cargar Excel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ URL::asset('/css/bootstrap.min.css') }}" rel="stylesheet">


    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bg-body1 {
            background-color: #2d2e5e;
        }
    </style>
</head>

<body class="antialiased bg-body1">
    <div class="container">
        <div class="row my-3">
            <div class="col-6">
                <img src="/logo-impro.png" class="img-fluid" />
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-body">

                        <canvas id="myChart" width="100" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card shadow">
                    <div class="card-header">
                        Actividad del día
                    </div>
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
        </div>
    </div>



    <script>
        window.onload = async function() {
            let labels = [];
            let data = [];
            let test1 = null;

            function tableCreate({
                data = null
            }) {

                const tbl = document.getElementById('table-sellers');

                // Esto se debe cambiar si entra un vendedor nuevo
                for (var i = 2; i <= 7; i++) {
                    var tr = tbl.insertRow();
                    if (!(i > 6)) {
                        labels.push(data[i].__EMPTY);
                    }
                    for (var j = 0; j < 7; j++) {
                        var td = tr.insertCell();
                        if (j >= 4) {
                            td.appendChild(document.createTextNode('$' + data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                        } else {

                            td.appendChild(document.createTextNode(data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                        }
                    }
                }



                console.log(data[7])

                console.log(labels);
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '# of Votes',
                            data: [12, 19, 3, 5, 2, 3],
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


            function graphCreate({
                dataMonth = null
            }) {

                console.log(dataMonth);
                // Esto se debe cambiar si entra un vendedor nuevo
                /*   for (var i = 2; i <= 7; i++) {
                      var tr = tbl.insertRow();
                      if (!(i > 6)) {
                          labels.push(data[i].__EMPTY);
                      }
                      for (var j = 0; j < 7; j++) {
                          var td = tr.insertCell();
                          if (j >= 4) {
                              td.appendChild(document.createTextNode('$' + data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                          } else {

                              td.appendChild(document.createTextNode(data[i]['__EMPTY' + (j !== 0 ? '_' + j : '')]));
                          }
                      }
                  }



                  console.log(data[7])

                  console.log(labels);
                  var ctx = document.getElementById('myChart').getContext('2d');
                  var myChart = new Chart(ctx, {
                      type: 'bar',
                      data: {
                          labels: labels,
                          datasets: [{
                              label: '# of Votes',
                              data: [12, 19, 3, 5, 2, 3],
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
                  }); */
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
                    const ws = workbook.Sheets[wsname];
                    const wsMonth = workbook.Sheets[wsnameMonth];
                    const test = XLSX.utils.sheet_to_json(ws);
                    const dataMonth = XLSX.utils.sheet_to_json(wsMonth);

                    tableCreate({
                        data: test
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