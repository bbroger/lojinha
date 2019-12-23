$("#valor").maskMoney();

var table_pendencia= $("#mostra_pendencia").DataTable({
    "processing": true,
    "ordering": false,
    "order": [[0, "desc"]],
    ajax: url_ajax("Pendencias/tabela_pendencias"),
    "columns": [
        { "data": "tipo" },
        { "data": "nome" },
        { "data": "valor" },
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

table_pendencia.on('click', '.save', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdValor = tr.find("td").eq(1);
    var tdDesc = tr.find("td").eq(2);

    $.ajax({
        url: url_ajax("Pendencias/editar_valor_retirado"),
        type: "Post",
        data: {
            id_movimentacao: tdID.html(),            
            valor: tdValor.find('input').val().replace(",", ""),
            descricao: firstUp(tdDesc.find('textarea').val())
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdValor.html("R$ " + tdValor.find('input').val().replace(",", ""));
            tdDesc.html(firstUp(tdDesc.find('textarea').val()));

            tr.find("td").eq(4).find('button').eq(0).prop('disabled', true);
            tr.find("td").eq(4).find('button').eq(1).prop('disabled', false);
        } else {
            tdValor.find('input').css({ border: "1px solid red", color: "red" });
            tdDesc.find('textarea').css({ border: "1px solid red", color: "red" });
            alert(data.msg);
        }
    });
});

$("#salvar_retirado").click(function () {
    var valor = $("#valor_retirado");
    var descricao = $("#descricao_retirado");

    $("#mostra_msg_retirado").html("").removeClass();
    $.ajax({
        url: url_ajax("Pendencias/salvar_valor_retirado"),
        type: "Post",
        data: {
            valor: valor.val().replace(",", ""),
            descricao: firstUp(descricao.val()),
            tipo: 'retirado'
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            $("#mostra_msg_retirado").html(data.msg).addClass("text-success");
            valor.val("");
            descricao.val("");
            table_pendencia.ajax.reload();
        } else {
            $("#mostra_msg_retirado").html(data.msg).addClass("text-danger");
        }
    }).fail(function (data) {
        alert('Erro ao criar o valor retirado. Tente mais tarde');
    });
});

var table_historico = $("#mostra_inserido").DataTable({
    "processing": true,
    "order": [[0, "desc"]],
    ajax: url_ajax("Pendencias/tabela_inseridos"),
    "columns": [
        { "data": "id_movimentacao" },
        { "data": "valor" },
        { "data": "descricao" },
        { "data": "timestamp" },
        { "data": "button" }
    ],
    "columnDefs": [
        { "width": "40%", "targets": 2 }
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