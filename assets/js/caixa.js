var produtos_inseridos = [];
$("#insere_valor_pago").maskMoney();

var table = $("#catalogo").DataTable({
    "processing": true,
    "pageLength": "10",
    "ordering": false,
    "info": false,
    "dom": "ftip",
    ajax: url_ajax("Caixa/catalogo"),
    "columns": [
        { "data": "id_produto" },
        { "data": "nome" },
        { "data": "valor" }
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

$("#search_inserir").click(function () {
    $("#msg_search_id_produto").html("");
    $("#msg_search_quantidade").html("");

    var id_produto = $("#search_id_produto");
    id_produto.css({ border: "1px solid #ccc", color: "#737373" });

    var quantidade = $("#search_quantidade");
    quantidade.css({ border: "1px solid #ccc", color: "#737373" });

    var valid = true;

    if (id_produto.val().length == 0) {
        valid = false;
        id_produto.css({ border: "1px solid red", color: "red" });
        $("#msg_search_id_produto").html("Código do produto é obrigatório");
    } else if (id_produto.val() <= 0) {
        valid = false;
        id_produto.css({ border: "1px solid red", color: "red" });
        $("#msg_search_id_produto").html("Produto precisa ser maior que 0");
    }

    if (quantidade.val().length == 0) {
        valid = false;
        quantidade.css({ border: "1px solid red", color: "red" });
        $("#msg_search_quantidade").html("Quantidade é obrigatório");
    } else if (quantidade.val() <= 0) {
        valid = false;
        quantidade.css({ border: "1px solid red", color: "red" });
        $("#msg_search_quantidade").html("Quantidade precisa ser maior que 0");
    }

    if (valid) {
        $.getJSON(url_ajax("Caixa/tabela_produtos/" + id_produto.val()), function (result) {
            if (!result) {
                id_produto.css({ border: "1px solid red", color: "red" });
                $("#msg_search_id_produto").html("Código produto não encontrado.<br> Confira na tabela ao lado");

            } else {
                var valorPromo= 0;
                $.each(result, function (i, value){
                    if(parseInt(quantidade.val()) >= parseInt(value.qtdPromo)){
                        valorPromo= value.valorPromo;
                    }
                });

                result[0]['quantidade'] = quantidade.val();
                result[0]['valor_total'] = (valorPromo === 0) ? (quantidade.val() * result[0]['valor']).toFixed(2) : (quantidade.val() * valorPromo).toFixed(2);
                result[0]['valorPromo'] = valorPromo;

                produtos_inseridos.push(result[0]);

                monta_tabela();

                id_produto.val("");
                quantidade.val("");
                console.log(table);
                table.search('').draw();
            }
        });
    }
});

function delete_produto(row) {
    produtos_inseridos.splice(row, 1);
    monta_tabela();
}

$("#insere_valor_pago").keyup(function () {
    calcula_todos_valores();
});

$("#finalizar_venda").click(function () {
    var valor_pago = $("#insere_valor_pago");
    var tipo_pag = ($("#pagcartao").is(':checked')) ? 'cartao' : 'dinheiro';

    $.ajax({
        url: url_ajax("Caixa/finalizar_venda"),
        type: 'Post',
        dataType: 'json',
        data: { valor_pago: valor_pago.val(), tipo_pag: tipo_pag, itens_produto: produtos_inseridos }
    }).done(function (data) {
        if (data.status) {
            valor_pago.val("");
            produtos_inseridos = [];
            $("#tabela_produtos_inseridos").html("");
            $("#mostra_valor_total").html("R$ 0,00");
            $("#mostra_valor_pago").html("R$ 0,00");
            $("#pagcartao").prop('checked', false);
            $("#mostra_troco").html("R$ 0,00");
        }
    }).fail(function (data) {
        console.log(data);
    });

});

function monta_tabela(){
    var tr = null;
    $.each(produtos_inseridos, function (i, value) {
        tr += "<tr scope='row' id='row" + i + "'>";
        tr += "<td>" + value.id_produto + "</td>";
        tr += "<td>" + value.nome + "</td>";
        tr += "<td>" + value.descricao + "</td>";
        tr += "<td>R$ " + value.valor.replace(".", ",") + "</td>";
        tr += "<td>R$ " + ((value.valorPromo === 0) ? "0.00" : value.valorPromo.replace(".", ",")) + "</td>";
        tr += "<td>" + value.quantidade + "</td>";
        tr += "<td>R$ " + value.valor_total.replace(".", ",") + "</td>";
        tr += '<td><button onclick="delete_produto(' + i + ')" style="padding: 0 5px;" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>';
        tr += "</tr>";
    });

    $("#tabela_produtos_inseridos").html("");
    $("#tabela_produtos_inseridos").html(tr);

    calcula_todos_valores();
}

function calcula_todos_valores(){
    $("#mostra_valor_total").html("R$ 0,00");
    $("#mostra_valor_pago").html("R$ 0,00");
    $("#mostra_troco").html("R$ 0,00");
    if (produtos_inseridos.length > 0) {
        var pega_valor_pago = parseFloat($("#insere_valor_pago").val().replace(",", ""));
        var valor_pago= ($.isNumeric(pega_valor_pago)) ? pega_valor_pago : 0;
        var valor_total = 0;
        $.each(produtos_inseridos, function (i, value) {
            valor_total += parseFloat(value.valor_total);
        });

        $("#mostra_valor_total").html("R$ " + valor_total.toFixed(2).replace(".", ","));
        $("#mostra_valor_pago").html("R$ " + valor_pago.toFixed(2).replace(".", ","));

        var troco = (valor_pago - valor_total).toFixed(2);

        if (troco > 0 && valor_total > 0) {
            $("#mostra_troco").html("R$ " + troco.replace(".", ","));
        } else {
            $("#mostra_troco").html("R$ 0,00");
        }
    } else{
        $("#insere_valor_pago").val("");
    }
}

setInterval(function(){ table.ajax.reload(); }, 30000);