$("#valor").maskMoney();

var table_pendencia= $("#mostra_pendencia").DataTable({
    "processing": true,
    "ordering": false,
    "order": [[0, "desc"]],
    ajax: url_ajax("Pendencias/tabela_pendencias"),
    "columns": [
        { "data": "id" },
        { "data": "tipo" },
        { "data": "nome" },
        { "data": "valor" },
        { "data": "ende" },
        { "data": "obs" },
        { "data": "vencimento" },
        { "data": "button" }
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

var table_historico= $("#mostra_historico").DataTable({
    "processing": true,
    "ordering": false,
    "order": [[0, "desc"]],
    ajax: url_ajax("Pendencias/tabela_historico"),
    "columns": [
        { "data": "id" },
        { "data": "tipo" },
        { "data": "nome" },
        { "data": "valor" },
        { "data": "ende" },
        { "data": "obs" },
        { "data": "vencimento" }
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

table_pendencia.on('click', '.save', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdTipo = tr.find("td").eq(1);

    $.ajax({
        url: url_ajax("Pendencias/tirar_pendencia"),
        type: "Post",
        data: {
            tipo: tdTipo.html(),
            id: tdID.html()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            table_pendencia.ajax.reload();
            table_historico.ajax.reload();            
        } else {
            alert(data.msg);
        }
    }).fail(function (data){
        console.log(data);
    });
});

$("#salvar_pendencia").click(function () {
    var nome = $("#nome");
    var valor = $("#valor");
    var vencimento = $("#vencimento");

    $("#mostra_msg_penddencia").html("").removeClass();
    $.ajax({
        url: url_ajax("Pendencias/salvar_pendencia"),
        type: "Post",
        data: {
            nome: firstUp(nome.val()),
            valor: valor.val().replace(",", ""),
            vencimento: vencimento.val()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            $("#mostra_msg_pendencia").html(data.msg).addClass("text-success");
            
            $("#nome").val("");
            valor.val("");
            vencimento.val("");
            table_pendencia.ajax.reload();
        } else {
            $("#mostra_msg_pendencia").html(data.msg).addClass("text-danger");
        }
    }).fail(function (data) {
        alert('Erro ao registrar a pendencia. Tente mais tarde');
    });
});

function allUp(text) {
    var words = $.trim(esp(text)).split(" ");
    for (var a = 0; a < words.length; a++) {
        var w = words[a];
        words[a] = w[0].toUpperCase() + w.slice(1);
    }
    return words.join(" ");
}

function firstUp(text) {
    var words = $.trim(esp(text)).split(" ");
    words[0] = words[0].charAt(0).toUpperCase() + words[0].slice(1);
    return words.join(" ");
}

function esp(vlr) {

    while (vlr.indexOf("  ") != -1)
        vlr = vlr.replace("  ", " ");

    while (vlr.indexOf("   ") != -1)
        vlr = vlr.replace("   ", " ");

    return vlr;
}