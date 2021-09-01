import Chart from 'chart.js/auto';
import XLSX from 'xlsx';
import ChartDataLabels from 'chartjs-plugin-datalabels';

window.onload = loadData;
function formatNumber(number) {

    return number.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
    });
}
loadData();

window.setInterval(function () {
    loadData();
}, 60000);

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
var month = date.getMonth() + 1;
var day = date.getDate();
document.getElementById('monthText').innerText = day + ' de ' + MONTHS_LIST[month];

async function tableCreate({
    data = null
}) {


    const tbl = document.getElementById('table-sellers').getElementsByTagName('tbody')[0];
    tbl.innerHTML = '';
    console.log(data)

    // Esto se debe cambiar si entra un vendedor nuevo
    for (var i = 2; i <= 9; i++) {
        if (data[i]['__EMPTY'] === "JOSE") {
            continue;
        }
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
    // Esto se debe cambiar si entra un vendedor nuevo
    for (var i = 0; i < data.length - 1; i++) {
        var tr = tbl.insertRow();
        if (data[i]['__EMPTY_3'] === 'JOSE') {
            tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_8']));
            tr.insertCell().appendChild(document.createTextNode('NURERVIS'));
            tr.insertCell().appendChild(document.createTextNode(formatNumber(data[i]['__EMPTY_11'])));

        } else {
            tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_8']));
            tr.insertCell().appendChild(document.createTextNode(data[i]['__EMPTY_3']));
            tr.insertCell().appendChild(document.createTextNode(formatNumber(data[i]['__EMPTY_11'])));

        }
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

async function loadData() {


    let acum = 0;
    let goalTotal = 0;


    async function graphCreate({
        dataMonth = null
    }) {
        let labels = [];
        let data = [];
        const tbl = document.getElementById('table-goals').getElementsByTagName('tbody')[0];
        tbl.innerHTML = '';
        // Esto se debe cambiar si entra un vendedor nuevo
        for (var i = 2; i <= 9; i++) {
            if ((i <= 9)) {
                if (dataMonth[i].__EMPTY_1 === 'JESUS MONTOYA' || dataMonth[i].__EMPTY_1 === 'JOSE') {
                    continue;
                }
                console.log(dataMonth[i])
                var tr = tbl.insertRow();
                tr.insertCell().appendChild(document.createTextNode(dataMonth[i].__EMPTY_1.split(/\s(.+)/)[0]));
                tr.insertCell().appendChild(document.createTextNode(formatNumber(dataMonth[i].__EMPTY_7)));
                tr.insertCell().appendChild(document.createTextNode(formatNumber(dataMonth[i].__EMPTY_9)));
                labels.push(dataMonth[i].__EMPTY_1.split(/\s(.+)/)[0]);
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
            plugins: [ChartDataLabels],

            data: {
                datasets: [{
                    labels: ['Porcentaje faltante', 'Porcentaje completado'],
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
                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        color: '#ffffff',
                        formatter: function (value, context) {
                            return value + ' %';
                        },
                        rotation: 270,

                        font: {
                            style: 'bold',
                            weight: 'bold',
                            size: '24px'
                        }
                    }
                },
                responsive: false,

                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                        },
                    }],


                }


            },
        });

        var myChart = new Chart(ctx, {

            type: 'bar',
            plugins: [ChartDataLabels],

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
                indexAxis: 'x',
                layout: {
                    padding: {
                        top: 40
                    }
                },
                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        formatter: function (value, context) {
                            return formatNumber(value);
                        },
                        anchor: 'end',
                        align: 'end',
                        font: {
                            style: 'bold',
                            weight: 'bold',

                            size: '40px'
                        }
                    },
                    legend: {
                        display: false,
                        position: 'top',
                        align: 'end',
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 30
                            }
                        }

                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 35,
                            }

                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 40,
                            }
                        }
                    }
                }
            }
        });
    }


    const readExcel = async (file) => {
        let oReq = new XMLHttpRequest();
        oReq.open("GET", "storage/Cotizaciones.xlsx", true);
        oReq.responseType = "arraybuffer";

        oReq.onload = function (e) {
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

    const result = await readExcel("storage/Cotizaciones.xlsx")
}
