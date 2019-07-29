$("#varejo_dinheiro").DataTable({
    "processing": true,
    "ordering": false,
    ajax: url_ajax("Relatorios/gera_tabelas/varejo/dinheiro"),
    "columns": [
        { "data": "dia" },
        { "data": "valor_total" },
        { "data": "desconto" },
        { "data": "itens" },
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

$("#varejo_cartao").DataTable({
    "processing": true,
    "ordering": false,
    ajax: url_ajax("Relatorios/gera_tabelas/varejo/cartao"),
    "columns": [
        { "data": "dia" },
        { "data": "valor_total" },
        { "data": "desconto" },
        { "data": "itens" },
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

$("#atacado_dinheiro").DataTable({
    "processing": true,
    "ordering": false,
    ajax: url_ajax("Relatorios/gera_tabelas/atacado/dinheiro"),
    "columns": [
        { "data": "dia" },
        { "data": "valor_total" },
        { "data": "desconto" },
        { "data": "itens" },
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

$("#atacado_cartao").DataTable({
    "processing": true,
    "ordering": false,
    ajax: url_ajax("Relatorios/gera_tabelas/atacado/cartao"),
    "columns": [
        { "data": "dia" },
        { "data": "valor_total" },
        { "data": "desconto" },
        { "data": "itens" },
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