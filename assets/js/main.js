$(document).ready(function() {

});

function edit(linha) {
    var linhaProduto = $("#produto" + linha);
    var valorProduto = linhaProduto.html();
    var inputProduto = "<input type='text' class='form-control' value='" + valorProduto + "'>";
    linhaProduto.html("");
    linhaProduto.html(inputProduto);

    var linhaDescricao = $("#descricao" + linha);
    var valorDescricao = linhaDescricao.html();
    var inputDescricao = "<input type='text' class='form-control' value='" + valorDescricao + "'>";
    linhaDescricao.html("");
    linhaDescricao.html(inputDescricao);

    var linhaQtd = $("#quantidade" + linha);
    var valorQtd = linhaQtd.html();
    var inputQtd = "<input type='number' class='form-control' style='width: 30%; margin: auto auto;' value='" + valorQtd + "'>";
    linhaQtd.html("");
    linhaQtd.html(inputQtd);

    $("#edit" + linha).prop("disabled", true);
    $("#save" + linha).prop("disabled", false);
}

function save(linha) {
    var linhaProduto = $("#produto" + linha);
    var valorProduto = $("#produto" + linha + " input").val();
    linhaProduto.html("");
    linhaProduto.html(valorProduto);

    var linhaDescricao = $("#descricao" + linha);
    var valorDescricao = $("#descricao" + linha + " input").val();
    linhaDescricao.html("");
    linhaDescricao.html(valorDescricao);

    var linhaQtd = $("#quantidade1");
    var valorQtd = $("#quantidade" + linha + " input").val();
    linhaQtd.html("");
    linhaQtd.html(valorQtd);

    $("#save" + linha).prop("disabled", true);
    $("#edit" + linha).prop("disabled", false);
}