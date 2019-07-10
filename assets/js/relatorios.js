var idMounth = $("#graphMonth");
var chartMounth = new Chart(idMounth, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                type: 'line',
                label: 'Total',
                backgroundColor: 'blue',
                data: [50, 43, 67, 86, 37, 70, 45]
            },
            {
                type: 'bar',
                label: 'Atacado',
                data: [0, 13, 5, 42, 23, 5, 32]
            },
            {
                type: 'bar',
                label: 'Varejo',
                data: [32, 32, 45, 13, 21, 50, 7]
            },
            {
                type: 'bar',
                label: 'Valor retirado',
                data: [0, 0, 5, 8, 0, 7, 5]
            },
            {
                type: 'bar',
                label: 'Valor inserido',
                data: ['10.50', 0, 5, 8, 0, 7, 5]
            }
        ]
    },

    // Configuration options go here
    options: {
        title: {
            display: true,
            text: 'Vendas mensal',
            position: 'top'
        },
        scales: {
            yAxes: [{
                ticks: {
                    callback: function (value, index, values) {
                        return 'R$' + value;
                    }
                }
            }]
        },
        animation: {
            duration: 5000
        },
        maintainAspectRatio: false,
    }

});

var idTotalTrans = $("#graphTotalTrans");
var chartTotalTrans = new Chart(idTotalTrans, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [21, 32, 5, 32, 53, 4, 7],
            backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue', 'black', 'pink'],
            labels:['January', 'February', 'March', 'April', 'May', 'June', 'July']
        }]
    },
    options: {
        responsive: true,
        legend: {
            position: 'none',
        },
        title: {
            display: true,
            text: 'Total de transação'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },
        animation: {
            duration: 5000
        },
        maintainAspectRatio: false
    }
});

var idTotalVendas = $("#graphTotalVendas");
var chartTotalVendas = new Chart(idTotalVendas, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [21, 32, 5, 32, 53, 4, 7],
            backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue', 'black', 'pink']
        }],
        labels:['January', 'February', 'March', 'April', 'May', 'June', 'July']
    },
    options: {
        responsive: true,
        legend: {
            position: 'none',
        },
        title: {
            display: true,
            text: 'Total de produtos vendidos'
        },
        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 5000
        },
        maintainAspectRatio: false
    }
});

$("#circlefulMoney").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: 75,
    text: 'Dinheiro',
    textY: 85
});

$("#circlefulCard").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: 20,
    text: 'Cartão',
    textY: 85
});

$("#circlefulAtacado").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: 75,
    text: 'Atacado',
    textY: 85
});

$("#circlefulVarejo").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: 20,
    text: 'Varejo',
    textY: 85
});

var table= $("#mostra_tabela").DataTable({
    "info": false,
    "ordering": false,
    "dom": "ftip",
    "language": {
        "sEmptyTable": "Nenhum registro encontrado",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "_MENU_ resultados por página",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sZeroRecords": "Nenhum registro encontrado",
        "sSearch": "Pesquisar",
        "oPaginate": {
            "sNext": "Próximo",
            "sPrevious": "Anterior",
            "sFirst": "Primeiro",
            "sLast": "Último"
        },
        "oAria": {
            "sSortAscending": ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
        }
    }
});

var idWeek = $("#graphWeek");
var chartWeek = new Chart(idWeek, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                fill: false,
                type: 'line',
                label: 'Total',
                backgroundColor: 'blue',
                borderColor: 'blue',
                data: [50, 43, 67, 86, 37, 70, 45]
            },
            {
                type: 'bar',
                label: 'Atacado',
                borderColor: 'white',
                borderWidth: 2,
                backgroundColor: 'yellow',
                data: [0, 13, 5, 42, 23, 5, 32]
            },
            {
                type: 'bar',
                label: 'Varejo',
                borderColor: 'white',
                borderWidth: 2,
                backgroundColor: 'green',
                data: [32, 32, 45, 13, 21, 50, 7]
            },
            {
                fill: false,
                type: 'bar',
                label: 'Desconto',
                borderColor: 'white',
                backgroundColor: 'red',
                borderWidth: 2,
                data: [0, 0, 5, 8, 0, 7, 5]
            },
        ]
    },

    // Configuration options go here
    options: {
        title: {
            display: true,
            text: 'Vendas semanal',
            position: 'top'
        },
        scales: {
            yAxes: [{
                ticks: {
                    callback: function (value, index, values) {
                        return 'R$' + value;
                    }
                }
            }]
        },
        animation: {
            duration: 5000
        },
        maintainAspectRatio: false,
    }

});

var idWeekTotalTrans = $("#graphWeekTotalTrans");
var chartWeekTotalTrans = new Chart(idWeekTotalTrans, {
    type: 'pie',
    data: {
        datasets: [{
            data: [21, 32, 5, 32, 53, 4, 7],
            backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue', 'black', 'pink'],
            labels:['January', 'February', 'March', 'April', 'May', 'June', 'July']
        }]
    },
    options: {
        responsive: true,
        legend: {
            position: 'none',
        },
        title: {
            display: true,
            text: 'Total de transação'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },
        animation: {
            duration: 5000
        },
        maintainAspectRatio: false
    }
});

var idWeekTotalVendas = $("#graphWeekTotalVendas");
var chartWeekTotalVendas = new Chart(idWeekTotalVendas, {
    type: 'pie',
    data: {
        datasets: [{
            data: [21, 32, 5, 32, 53, 4, 7],
            backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue', 'black', 'pink']
        }],
        labels:['January', 'February', 'March', 'April', 'May', 'June', 'July']
    },
    options: {
        responsive: true,
        legend: {
            position: 'none',
        },
        title: {
            display: true,
            text: 'Total de produtos vendidos'
        },
        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 5000
        },
        maintainAspectRatio: false
    }
});