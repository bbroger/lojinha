var chartMonth = new Chart($("#graphMonth"), {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: false,

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
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
        
                    if (label) {
                        label += ': R$ ';
                    }
                    label += tooltipItem.yLabel.toFixed(2);
                    return label;
                }
            }
        },
        maintainAspectRatio: false,
    }

});

var chartTotalTrans = new Chart($("#graphTotalTrans"), {
    type: 'doughnut',
    data: false,
    options: {
        responsive: true,
        legend: {
            position: 'none',
        },
        title: {
            display: true,
            text: 'Total de transação mensal'
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
    data: false,
    options: {
        responsive: true,
        legend: {
            position: 'none',
        },
        title: {
            display: true,
            text: 'Total de produtos vendidos mensal'
        },
        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 5000
        },
        maintainAspectRatio: false
    }
});

circliful();

constroi_table_semanal(false);
constroi_table_diario(false);

var chartWeek = new Chart($("#graphWeek"), {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: false,

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
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
        
                    if (label) {
                        label += ': R$ ';
                    }
                    label += tooltipItem.yLabel.toFixed(2);
                    return label;
                }
            }
        },
        maintainAspectRatio: false,
    }

});

var chartDay = new Chart($("#graphDay"), {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: false,

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
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
        
                    if (label) {
                        label += ': R$ ';
                    }
                    label += tooltipItem.yLabel.toFixed(2);
                    return label;
                }
            }
        },
        maintainAspectRatio: false,
    }

});

atualiza_graph('vendas');

$(".filtro").click(function () {
    $(".filtro").removeClass("active");
    var id = $(this)[0].id;
    $("#" + id).addClass("active");

    var tipo = (id == 'btndinheiro') ? 'dinheiro' : ((id == 'btncartao') ? 'cartao' : 'vendas');

    atualiza_graph(tipo);
});

function atualiza_graph(tipo = null) {
    $.ajax({
        url: url_ajax("Relatorios/monta_relatorio/" + tipo),
        type: 'Get',
        dataType: 'json'
    }).done(function (data) {

        chartMonth.data = data.relatorios.mensal.data;
        chartMonth.update({
            duration: 2000,
            easing: 'linear'
        });

        chartTotalTrans.data = data.relatorios.transacao.data;
        chartTotalTrans.update({
            duration: 2000,
            easing: 'linear'
        });

        chartTotalVendas.data = data.relatorios.total_produtos.data;
        chartTotalVendas.update({
            duration: 2000,
            easing: 'linear'
        });

        chartWeek.data = data.relatorios.semanal.data;
        chartWeek.update({
            duration: 2000,
            easing: 'linear'
        });

        chartDay.data = data.relatorios.diario.data;
        chartDay.update({
            duration: 2000,
            easing: 'linear'
        });

        circliful(data.relatorios.circliful);

        constroi_table_semanal(data.tabela_semanal);
        constroi_table_diario(data.tabela_diario);

    }).fail(function (data) {
       alert("Erro ao trazer os relatórios. Não foi possível carregar as informaçoes");
        console.log(data);
    });
}

function circliful(data= false){
    $("#circlefulMoney").html("");
    $("#circlefulCard").html("");
    $("#circlefulAtacado").html("");
    $("#circlefulVarejo").html("");

    var circliful= {};
    if(data){
        circliful= data;
    } else{
        circliful={
            dinheiro:{porc:0,decimal:0},
            cartao:{porc:0},decimal:0,
            atacado:{porc:0},decimal:0,
            varejo:{porc:0},decimal:0
        }
    }

    $("#circlefulMoney").circliful({
        animationStep: 3,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: circliful.dinheiro.porc,
        decimals: circliful.dinheiro.decimal,
        text: 'Dinheiro',
        textY: 85
    });
    
    $("#circlefulCard").circliful({
        animationStep: 3,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: circliful.cartao.porc,
        decimals: circliful.cartao.decimal,
        text: 'Cartão',
        textY: 85
    });
    
    $("#circlefulAtacado").circliful({
        animationStep: 3,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: circliful.atacado.porc,
        decimals: circliful.atacado.decimal,
        text: 'Atacado',
        textY: 85
    });
    
    $("#circlefulVarejo").circliful({
        animationStep: 3,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: circliful.varejo.porc,
        decimals: circliful.varejo.decimal,
        text: 'Varejo',
        textY: 85
    });
}

function constroi_table_semanal(pega_data= false) {
    if ($.fn.dataTable.isDataTable('#mostra_tabela_semanal')) {
        $('#mostra_tabela_semanal').dataTable().fnClearTable();
        $('#mostra_tabela_semanal').dataTable().fnDestroy();
    }

    $("#mostra_tabela_semanal").dataTable({
        "info": false,
        "ordering": false,
        "dom": "ftip",
        pageLength: 4,
        data: pega_data,
        columns: [
            { "data": 'string' },
            { "data": 'valor_pago' },
            { "data": 'desconto' },
            { "data": 'vendas' }
        ],
        "columnDefs": [
            { "width": "35%", "targets": 0 },
            { "width": "20%", "targets": 1 },
            { "width": "20%", "targets": 2 },
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
}

function constroi_table_diario(pega_data= false) {
    if ($.fn.dataTable.isDataTable('#mostra_tabela_diario')) {
        $('#mostra_tabela_diario').dataTable().fnClearTable();
        $('#mostra_tabela_diario').dataTable().fnDestroy();
    }

    $("#mostra_tabela_diario").dataTable({
        "info": false,
        "ordering": false,
        "dom": "ftip",
        pageLength: 4,
        data: pega_data,
        columns: [
            { "data": 'dia_venda' },
            { "data": 'valor_pago' },
            { "data": 'desconto' },
            { "data": 'itens' },
            { "data": 'ver' }
        ],
        "columnDefs": [
            { "width": "20%", "targets": 1 },
            { "width": "20%", "targets": 2 },
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
}

$("#mostra_tabela_diario").on('click', '.ver_detalhes', function(){
    var id= $(this)[0].id;

    var table= $("#modal_details_table");
    table.html("");

    $.ajax({
        url: url_ajax("Relatorios/consulta_venda_diario/"+id),
        type: 'Get',
        dataType: 'json'
    }).done(function(data){

        table.html(data.table);
        $("#modal_details").modal('show');
    }).fail(function(data){
        alert("Erro ao trazer os detalhes. Não foi possível trazer os detalhes da venda.");
        console.log(data);
    });
});