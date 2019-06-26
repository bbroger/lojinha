$("#valor").maskMoney();
$("#valor_inserido").maskMoney();

var table = $("#mostra_retirado").DataTable({
    "processing": true,
    "order": [[0, "desc"]],
    ajax: url_ajax("Gerenciamento/tabela_retirados"),
    "columns": [
        { "data": "valor" },
        { "data": "descricao" },
        { "data": "timestamp" },
        { "data": "button" }
    ],
    "columnDefs": [
        { "width": "40%", "targets": 1 }
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