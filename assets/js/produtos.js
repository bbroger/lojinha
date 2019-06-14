$(document).ready(function () {
    $("#valor").maskMoney();
    tabela_produto();
});

function tabela_produto() {
    $.getJSON(url_ajax("Produtos/tabela_produtos"), function (result) {
        var tr = null;
        $.each(result, function (key, value) {
            tr += "<tr>";
            tr += "<td>" + value.id_produto + "</td>";
            tr += "<td id='nome" + value.id_produto + "'>" + value.nome + "</td>";
            tr += "<td id='descricao" + value.id_produto + "'>" + value.descricao + "</td>";
            tr += "<td id='valor" + value.id_produto + "'>R$ " + value.valor.replace(".", ",") + "</td>";
            tr += "<td id='quantidade" + value.id_produto + "'>" + value.quantidade + "</td>";
            tr += "<td>" + value.status + "</td>";
            tr += '<td><button style="padding: 0 5px;" id="save' + value.id_produto + '" class="btn btn-success" onclick="save(' + value.id_produto + ')" disabled><i class="fas fa-save"></i></button> ' +
                '<button style="padding: 0 5px;" id="edit' + value.id_produto + '" class="btn btn-warning" onclick="edit(' + value.id_produto + ')"><i class="fas fa-edit"></i></button> ' +
                '<button style="padding: 0 5px;" id="block' + value.id_produto + '" class="btn btn-danger" onclick="block(' + value.id_produto + ')"><i class="fas fa-ban"></i></button></td>';
            tr += '</tr>';
        });

        $("#mostra_tabela").html(tr);
    });
}

function edit(id_produto) {
    var id_produtoNome = $("#nome" + id_produto);
    var inputNome = "<input type='text' class='form-control' value='" + id_produtoNome.html() + "'>";
    id_produtoNome.html("");
    id_produtoNome.html(inputNome);

    var id_produtoDescricao = $("#descricao" + id_produto);
    var inputDescricao = "<input type='text' class='form-control' value='" + id_produtoDescricao.html() + "'>";
    id_produtoDescricao.html("");
    id_produtoDescricao.html(inputDescricao);

    var id_produtoValor = $("#valor" + id_produto);
    var pegaValor = id_produtoValor.html().replace(",", ".").replace("R$ ", "");
    var inputValor = "<input type='text' class='form-control' style='width: 70%; margin: auto auto;' data-decimal='.' id='money" + id_produto + "' value='" + pegaValor + "'>";
    id_produtoValor.html("");
    id_produtoValor.html(inputValor);
    $("#money" + id_produto).maskMoney();

    var id_produtoQtd = $("#quantidade" + id_produto);
    var valorQtd = id_produtoQtd.html();
    var inputQtd = "<input type='number' class='form-control' style='width: 50%; margin: auto auto;' value='" + valorQtd + "'>";
    id_produtoQtd.html("");
    id_produtoQtd.html(inputQtd);

    $("#edit" + id_produto).prop("disabled", true);
    $("#save" + id_produto).prop("disabled", false);
}

function save(id_produto) {
    var id_produtoNome = $("#nome" + id_produto);
    var pegaNome = $("#nome" + id_produto + " input").val();

    var id_produtoDescricao = $("#descricao" + id_produto);
    var pegaDescricao = $("#descricao" + id_produto + " input").val();

    var id_produtoValor = $("#valor" + id_produto);
    var pegaValor = $("#valor" + id_produto + " input").val();
    //console.log($.isNumeric(pegaValor.substring(2).replace(",", ".")));

    var id_produtoQtd = $("#quantidade" + id_produto);
    var pegaQtd = $("#quantidade" + id_produto + " input").val();

    $.ajax({
        url: url_ajax("Produtos/editar_produto"),
        type: "Post",
        data: {
            id_produto: id_produto,
            nome: pegaNome,
            descricao: pegaDescricao,
            valor: pegaValor,
            quantidade: pegaQtd
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {

            id_produtoNome.html("");
            id_produtoNome.html(pegaNome);

            id_produtoDescricao.html("");
            id_produtoDescricao.html(pegaDescricao);

            id_produtoValor.html("");
            id_produtoValor.html("R$ "+pegaValor.replace(".",","));

            id_produtoQtd.html("");
            id_produtoQtd.html(pegaQtd);
        } else {
            console.log(data);
        }
    }).fail(function (data) {
        console.log(data);
    });

    $("#save" + id_produto).prop("disabled", true);
    $("#edit" + id_produto).prop("disabled", false);
}

$("#salvar_produto").click(function () {
    var nome = $("#nome");
    var descricao = $("#descricao");
    var valor = $("#valor");
    var quantidade = $("#quantidade");

    $("#mostra_msg").removeClass();
    $.ajax({
        url: url_ajax("Produtos/salvar_produto"),
        type: "Post",
        data: {
            nome: nome.val(),
            descricao: descricao.val(),
            valor: valor.val(),
            quantidade: quantidade.val()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            $("#mostra_msg").html(data.msg).addClass("text-success").fadeIn();
            $("#mostra_msg").fadeOut(4000);
            nome.val("");
            descricao.val("");
            valor.val("");
            quantidade.val(0);
        } else {
            $("#mostra_msg").html(data.msg).addClass("text-danger").fadeIn();
        }

        tabela_produto();
    }).fail(function (data) {
        console.log(data);
    });
});