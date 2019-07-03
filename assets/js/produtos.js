$("#valorVarejo").maskMoney();
$("#valorAtacado").maskMoney();
$("#valor_promo").maskMoney();

var table = $("#mostra_tabela").DataTable({
    "processing": true,
    "order": [[0, "desc"]],
    ajax: url_ajax("Produtos/tabela_produtos"),
    "columns": [
        { "data": "id_produto" },
        { "data": "nome" },
        { "data": "descricao" },
        { "data": "valorVarejo" },
        { "data": "valorAtacado" },
        { "data": "quantidade" },
        { "data": "status" },
        { "data": "button" }
    ],
    "columnDefs": [
        { "width": "5%", "targets": 0 }
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

table.on('click', '.edit', function () {
    var tr = $(this).closest("tr");
    var tdNome = tr.find("td").eq(1);
    var tdDesc = tr.find("td").eq(2);
    var tdVarejo = tr.find("td").eq(3);
    var tdAtacado = tr.find("td").eq(4);

    tdNome.html("<input type='text' class='form-control' value='" + tdNome.html() + "'>");
    tdDesc.html("<input type='text' class='form-control' value='" + tdDesc.html() + "'>");
    tdVarejo.html("<input type='text' data-decimal='.' class='form-control' value='" + tdVarejo.html().replace("R$ ", "") + "'>");
    tdVarejo.find("input").maskMoney();
    tdAtacado.html("<input type='text' data-decimal='.' class='form-control' value='" + tdAtacado.html().replace("R$ ", "") + "'>");
    tdAtacado.find("input").maskMoney();

    $(this).closest("td").find('button').eq(0).prop('disabled', false);
    $(this).closest("td").find('button').eq(1).prop('disabled', true);
    $(this).closest("td").find('button').eq(2).prop('disabled', true);
    $(this).closest("td").find('button').eq(3).prop('disabled', true);
});

table.on('click', '.save', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdNome = tr.find("td").eq(1);
    var nome;
    var tdDesc = tr.find("td").eq(2);
    var desc;
    var tdVarejo = tr.find("td").eq(3);
    var tdAtacado = tr.find("td").eq(4);

    if (tdNome.find('input').val().length <= 0) {
        nome = null;
    } else {
        nome = allUp(tdNome.find('input').val());
    }

    if (tdDesc.find('input').val().length <= 0) {
        desc = null;
    } else {
        desc = firstUp(tdDesc.find('input').val());
    }

    $.ajax({
        url: url_ajax("Produtos/editar_produto"),
        type: "Post",
        data: {
            id_produto: tdID.html(),
            nome: nome,
            descricao: desc,
            valorVarejo: tdVarejo.find('input').val().replace(",", ""),
            valorAtacado: tdAtacado.find('input').val().replace(",", "")
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdNome.html(allUp(tdNome.find('input').val()));
            tdDesc.html(firstUp(tdDesc.find('input').val()));
            tdVarejo.html("R$ " + tdVarejo.find('input').val().replace(",", ""));
            tdAtacado.html("R$ " + tdAtacado.find('input').val().replace(",", ""));

            tr.find("td").eq(7).find('button').eq(0).prop('disabled', true);
            tr.find("td").eq(7).find('button').eq(1).prop('disabled', false);
            tr.find("td").eq(7).find('button').eq(2).prop('disabled', false);
            tr.find("td").eq(7).find('button').eq(3).prop('disabled', false);
        } else {
            tdNome.find('input').css({ border: "1px solid red", color: "red" });
            tdDesc.find('input').css({ border: "1px solid red", color: "red" });
            tdVarejo.find('input').css({ border: "1px solid red", color: "red" });
            tdAtacado.find('input').css({ border: "1px solid red", color: "red" });
            alert(data.msg);
        }
    });
});

table.on('click', '.block', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdStatus = tr.find("td").eq(5);
    var tdButtonStatusEdit = tr.find("td").eq(6).find('button').eq(1);
    var tdButtonStatus = tr.find("td").eq(6).find('button').eq(2);

    $.ajax({
        url: url_ajax("Produtos/desativar_produto"),
        type: "Post",
        data: {
            id_produto: tdID.html()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdStatus.html("desativado");
            tdButtonStatusEdit.prop('disabled', true);
            tdButtonStatus.removeClass('block').addClass('activ').html('<i class="fas fa-check-square"></i>');
        } else {
            alert(data.msg);
        }
    });
});

table.on('click', '.activ', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdNome = tr.find("td").eq(1);
    var tdStatus = tr.find("td").eq(5);
    var tdButtonStatusEdit = tr.find("td").eq(6).find('button').eq(1);
    var tdButtonStatus = tr.find("td").eq(6).find('button').eq(2);

    $.ajax({
        url: url_ajax("Produtos/ativar_produto"),
        type: "Post",
        data: {
            id_produto: tdID.html()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdStatus.html("ativo");
            tdButtonStatusEdit.prop('disabled', false);
            tdButtonStatus.removeClass('btn-primary activ').addClass('btn-danger block').html('<i class="fas fa-ban"></i>');
        } else {
            alert(data.msg);
        }
    });
});

table.on('click', '.add', function () {
    var radioAdd = $("#adicionar_estoque");
    radioAdd.prop('checked', true);

    var IDProduto = $("#id_produto_estoque");
    IDProduto.val("");

    var nomeProduto = $("#nome_produto_estoque");
    nomeProduto.val("");

    var qtdeAtual = $("#qtde_atual_estoque");
    qtdeAtual.val("");

    var labelAcao = $("#label_acao_estoque");
    labelAcao.html("Adicionar");

    var qtdeNova = $("#qtde_acao_estoque");
    qtdeNova.val("");

    var qtdeTotal = $("#qtde_total_estoque");
    qtdeTotal.val("");

    var btnEstoque = $("#salvar_novo_estoque");
    btnEstoque.html("Adicionar estoque").removeClass('btn-danger').addClass('btn-primary');

    var tr = $(this).closest("tr");

    var tdID = tr.find("td").eq(0);
    IDProduto.val(tdID.html());

    var tdNome = tr.find("td").eq(1);
    nomeProduto.val(tdNome.html());

    var tdQtde = tr.find("td").eq(4);
    qtdeAtual.val(tdQtde.html());

    $("#addEstoque").modal('show');
});

$("input[name='acao_estoque'").click(function () {
    $("#qtde_total_estoque").val("");
    $("#qtde_acao_estoque").val("");
    if ($(this).val() == 'add') {
        $("#label_acao_estoque").html("Adicionar");
        $("#salvar_novo_estoque").removeClass('btn-danger').addClass('btn-primary').html("Adicionar estoque");
    } else {
        $("#label_acao_estoque").html("Remover");
        $("#salvar_novo_estoque").removeClass('btn-primary').addClass('btn-danger').html("Remover estoque");
    }
});

$("#qtde_acao_estoque").keyup(function () {
    var qtdeAtual = parseInt($("#qtde_atual_estoque").val());

    var radioAcao;
    if ($("#adicionar_estoque").is(':checked')) {
        radioAcao = 'add';
    } else {
        radioAcao = 'remover';
    }

    var qtdeNova = parseInt($(this).val());

    if (Number.isInteger(qtdeNova) && radioAcao == 'add') {
        $("#qtde_total_estoque").val(qtdeAtual + qtdeNova);
    } else if (Number.isInteger(qtdeNova) && radioAcao == 'remover') {
        $("#qtde_total_estoque").val(qtdeAtual - qtdeNova);
    } else {
        $("#qtde_total_estoque").val("");
    }
});

var table_promocao = $("#mostra_tabela_promocao").DataTable({
    "processing": true,
    "order": [[0, "desc"]],
    ajax: url_ajax("Produtos/tabela_promocao"),
    "columns": [
        { "data": "id_promocao" },
        { "data": "id_produto" },
        { "data": "nomeProduto" },
        { "data": "quantidade" },
        { "data": "valor" },
        { "data": "status" },
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

table_promocao.on('click', '.edit', function () {
    var tr = $(this).closest("tr");
    var tdQtde = tr.find("td").eq(3);
    var tdValor = tr.find("td").eq(4);

    tdQtde.html("<input type='number' style='width: 60%; margin: auto auto;' class='form-control' value='" + tdQtde.html() + "'>");
    tdValor.html("<input type='text' style='width: 70%; margin: auto auto;' data-decimal='.' class='form-control' value='" + tdValor.html().replace("R$ ", "") + "'>");
    tdValor.find("input").maskMoney();

    $(this).closest("td").find('button').eq(0).prop('disabled', false);
    $(this).closest("td").find('button').eq(1).prop('disabled', true);
    $(this).closest("td").find('button').eq(2).prop('disabled', true);
});

table_promocao.on('click', '.save', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdQtde = tr.find("td").eq(3);
    var tdValor = tr.find("td").eq(4);

    $.ajax({
        url: url_ajax("Produtos/editar_promocao"),
        type: "Post",
        data: {
            id_promocao: tdID.html(),
            quantidade: tdQtde.find('input').val(),
            valor: tdValor.find('input').val().replace(",", "")
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdQtde.html(tdQtde.find('input').val());
            tdValor.html("R$ " + tdValor.find('input').val().replace(",", ""));

            tr.find("td").eq(6).find('button').eq(0).prop('disabled', true);
            tr.find("td").eq(6).find('button').eq(1).prop('disabled', false);
            tr.find("td").eq(6).find('button').eq(2).prop('disabled', false);
        } else {
            tdQtde.find('input').css({ border: "1px solid red", color: "red" });
            tdValor.find('input').css({ border: "1px solid red", color: "red" });
            alert(data.msg);
        }
    });
});

table_promocao.on('click', '.block', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdStatus = tr.find("td").eq(5);
    var tdButtonStatusEdit = tr.find("td").eq(6).find('button').eq(1);
    var tdButtonStatus = tr.find("td").eq(6).find('button').eq(2);

    $.ajax({
        url: url_ajax("Produtos/desativar_promocao"),
        type: "Post",
        data: {
            id_promocao: tdID.html()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdStatus.html("desativado");
            tdButtonStatusEdit.prop('disabled', true);
            tdButtonStatus.removeClass('btn-danger block').addClass('btn-secondary activ').html('<i class="fas fa-check-square"></i>');
        } else {
            alert(data.msg);
        }
    });
});

table_promocao.on('click', '.activ', function () {
    var tr = $(this).closest("tr");
    var tdID = tr.find("td").eq(0);
    var tdNome = tr.find("td").eq(2);
    var tdStatus = tr.find("td").eq(5);
    var tdButtonStatusEdit = tr.find("td").eq(6).find('button').eq(1);
    var tdButtonStatus = tr.find("td").eq(6).find('button').eq(2);

    $.ajax({
        url: url_ajax("Produtos/ativar_promocao"),
        type: "Post",
        data: {
            id_promocao: tdID.html()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdStatus.html("ativo");
            tdButtonStatusEdit.prop('disabled', false);
            tdButtonStatus.removeClass('btn-primary activ').addClass('btn-danger block').html('<i class="fas fa-ban"></i>');
        } else {
            alert(data.msg);
        }
    }).fail(function (data) {
        console.log(data);
    });
});

$(".clearModal").click(function () {
    $("#produto_promo").val("");
    $("#nome").val("");
    $("#descricao").val("");
    $("#valorVarejo").val("");
    $("#quantidade_promo").val("");
    $("#valor_promo").val("");
    $("#mostra_msg").html("");
    $("#mostra_msg_promo").html();
});

$("#salvar_produto").click(function () {
    var pega_nome = $("#nome");
    var nome;
    var pega_descricao = $("#descricao");
    var descricao;
    var pega_varejo = $("#valorVarejo");
    var valorVarejo;
    var pega_atacado = $("#valorAtacado");
    var valorAtacado;

    if ($.trim(pega_nome.val()).length <= 0) {
        nome= null;
    } else{
        nome= allUp($.trim(pega_nome.val()));
    }
    if ($.trim(pega_descricao.val()).length <= 0) {
        descricao = null;
    } else {
        descricao = firstUp($.trim(pega_descricao.val()));
    }
    if (pega_varejo.val().length <= 0) {
        valorVarejo = null;
    } else {
        valorVarejo = pega_varejo.val().replace(",", "");
    }
    if (pega_atacado.val().length <= 0) {
        valoratacado = null;
    } else {
        valorAtacado = pega_atacado.val().replace(",", "");
    }

    $("#mostra_msg").html("").removeClass();
    $.ajax({
        url: url_ajax("Produtos/salvar_produto"),
        type: "Post",
        data: {
            nome: nome,
            descricao: descricao,
            valorVarejo: valorVarejo,
            valorAtacado: valorAtacado
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            $("#mostra_msg").html(data.msg).addClass("text-success").fadeIn();
            $("#mostra_msg").fadeOut(4000);
            pega_nome.val("");
            pega_descricao.val("");
            pega_varejo.val("");
            pega_atacado.val("");
            table.ajax.reload();
        } else {
            $("#mostra_msg").html(data.msg).addClass("text-danger").fadeIn();
        }
    }).fail(function (data) {
        console.log(data);
        alert('Erro ao criar o produto. Tente mais tarde');
    });

});

$("#salvar_promocao").click(function () {
    var id_produto = $("#produto_promo");
    var quantidade = $("#quantidade_promo");
    var valor = $("#valor_promo");

    $("#mostra_msg").removeClass();
    $.ajax({
        url: url_ajax("Produtos/salvar_promocao"),
        type: "Post",
        data: {
            id_produto: id_produto.val(),
            quantidade: quantidade.val(),
            valor: valor.val().replace(",", "")
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            $("#mostra_msg_promo").html(data.msg).addClass("text-success").fadeIn();
            $("#mostra_msg_promo").fadeOut(4000);
            id_produto.val("");
            quantidade.val(0);
            valor.val("");
            table_promocao.ajax.reload();
        } else {
            $("#mostra_msg_promo").html(data.msg).addClass("text-danger").fadeIn();
        }
    }).fail(function (data) {
        alert('Erro ao criar o produto. Tente mais tarde');
    });
});

$("#salvar_novo_estoque").click(function () {
    var id_produto = $("#id_produto_estoque");
    var qtdeAtual = $("#qtde_atual_estoque");
    var qtdeNova = $("#qtde_acao_estoque");
    var qtdeTotal = $("#qtde_total_estoque");
    var radioAcao;
    if ($("#adicionar_estoque").is(':checked')) {
        radioAcao = 'add';
    } else {
        radioAcao = 'remover';
    }

    $("#mostra_msg_estoque").removeClass();
    $.ajax({
        url: url_ajax("Produtos/acao_estoque"),
        type: "Post",
        data: {
            id_produto: id_produto.val(),
            quantidade: qtdeNova.val(),
            acao: radioAcao
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            $("#mostra_msg_estoque").html(data.msg).addClass("text-success").fadeIn();
            $("#mostra_msg_estoque").fadeOut(4000);
            qtdeAtual.val(qtdeTotal.val());
            qtdeNova.val("");
            qtdeTotal.val("");
            table.ajax.reload();
        } else {
            $("#mostra_msg_estoque").html(data.msg).addClass("text-danger").fadeIn();
        }
    }).fail(function (data) {
        alert('Erro ao criar o produto. Tente mais tarde');
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