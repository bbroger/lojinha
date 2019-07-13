var chartMonth = new Chart($("#graphMonth"), {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: data_dinamico.mensal.data,

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

var chartTotalTrans = new Chart($("#graphTotalTrans"), {
    type: 'doughnut',
    data: data_dinamico.transacao.data,
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

var chartTotalVendas = new Chart($("#graphTotalVendas"), {
    type: 'doughnut',
    data: data_dinamico.total_produtos.data,
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
    percent: data_dinamico.circliful.dinheiro.porc,
    decimals: data_dinamico.circliful.dinheiro.decimal,
    text: 'Dinheiro',
    textY: 85
});

$("#circlefulCard").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: data_dinamico.circliful.cartao.porc,
    decimals: data_dinamico.circliful.cartao.decimal,
    text: 'Cartão',
    textY: 85
});

$("#circlefulAtacado").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: data_dinamico.circliful.atacado.porc,
    decimals: data_dinamico.circliful.atacado.decimal,
    text: 'Atacado',
    textY: 85
});

$("#circlefulVarejo").circliful({
    animationStep: 3,
    foregroundBorderWidth: 20,
    backgroundBorderWidth: 20,
    percent: data_dinamico.circliful.varejo.porc,
    decimals: data_dinamico.circliful.varejo.decimal,
    text: 'Varejo',
    textY: 85
});

var table = $("#mostra_tabela").dataTable({
    "info": false,
    "ordering": false,
    "dom": "ftip",
    data: table_dinamico,
    columns:[
        {"data":'data_venda'},
        {"data":'valor_total'},
        {"data":'itens'},
        {"data":'ver'}
    ],
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

function kk()
{
    if($.fn.dataTable.isDataTable('#mostra_tabela')){
        table.dataTable().fnUpdate();
    }
}

var idWeek = $("#graphWeek");
var chartWeek = new Chart(idWeek, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: data_dinamico.semanal.data,

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

var idDay = $("#graphDay");
var chartDay = new Chart(idDay, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: data_dinamico.diario.data,

    // Configuration options go here
    options: {
        title: {
            display: true,
            text: 'Vendas diario',
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

$(".filtro").click(function(){
    $(".filtro").removeClass("active");
    var id= $(this)[0].id;
    $("#"+id).addClass("active");
});