moment.locale('pt-BR');

var produtos_inseridos = [];
$("#insere_valor_pago").maskMoney();
//Serve para limitar o numero de botoes da paginaçao
$.fn.DataTable.ext.pager.numbers_length = 3;
var table = $("#catalogo").DataTable({
    "processing": true,
    "ordering": false,
    "info": false,
    "dom": "ftip",
    ajax: url_ajax("Pedidos/catalogo/"),
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
        $.getJSON(url_ajax("Pedidos/busca_produto/" + id_produto.val()), function (result) {
            if (!result) {
                id_produto.css({ border: "1px solid red", color: "red" });
                $("#msg_search_id_produto").html("Código produto não encontrado.<br> Confira na tabela ao lado");

            } else {
                var valorPromo = 0;
                $.each(result, function (i, value) {
                    if (parseInt(quantidade.val()) >= parseInt(value.qtdPromo)) {
                        valorPromo = value.valorPromo;
                    }
                });

                result[0]['quantidade'] = quantidade.val();
                result[0]['valor_total'] = (valorPromo === 0) ? (quantidade.val() * result[0]['valor']).toFixed(2) : (quantidade.val() * valorPromo).toFixed(2);
                result[0]['valorPromo'] = valorPromo;

                produtos_inseridos.push(result[0]);

                monta_tabela();

                id_produto.val("");
                quantidade.val("");

                table.search('').draw();
            }
        });
    }
    $("#msg_finalizar_pedido").html("");
});

function delete_produto(row) {
    produtos_inseridos.splice(row, 1);
    monta_tabela();
}

$("#insere_valor_pago").keyup(function () {
    calcula_todos_valores();
});

$("#finalizar_pedido").click(function () {
    table.search('').draw();
    $("#msg_finalizar_pedido").html("");

    var nome = $("#nome");
    nome.css({ border: "1px solid #ccc", color: "#737373" });
    var endereco = $("#endereco");
    var entrega = $("#entrega");
    var obs = $("#obs");

    var valor_pago = $("#insere_valor_pago");
    valor_pago.css({ border: "1px solid #ccc", color: "#737373" });
    var valor_pago_real= (valor_pago.val().length > 0) ? valor_pago.val().replace(",","") : '0.00';

    var tipo_pag = ($("#pagcartao").is(':checked')) ? 'cartao' : 'dinheiro';

    var valid = true;

    if(produtos_inseridos.length == 0){
        valid = false;
        $("#msg_finalizar_pedido").html("Não existem produtos inseridos.");
    } else if (nome.val().length == 0) {
        valid = false;
        nome.css({ border: "1px solid red", color: "red" });
        $("#msg_finalizar_pedido").html("Nome é obrigatório");
    }

    if (valid) {
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Finalizando').prop('disabled', true);
        $.ajax({
            url: url_ajax("Pedidos/finalizar_pedido"),
            type: 'Post',
            dataType: 'json',
            data: { nome: nome.val(), endereco: endereco.val(), entrega: entrega.val(), obs: obs.val(), valor_pago: valor_pago_real, tipo_pag: tipo_pag, itens_produto: produtos_inseridos }
        }).done(function (data) {
            if (data.status) {
                valor_pago.val("");
                produtos_inseridos = [];
                $("#tabela_produtos_inseridos").html("");
                $("#mostra_valor_total").html("R$ 0,00");
                $("#mostra_valor_pago").html("R$ 0,00");
                $("#mostra_troco").html("R$ 0,00");

                $("#nome").val("");
                $("#endereco").val("");
                $("#entrega").val(moment().format('YYYY-MM-DD'));
                $("#obs").val("");
                $("#insere_valor_pago").val("");
                
                $("#msg_search_id_produto").html("");
                $("#msg_search_quantidade").html("");
                $("#search_id_produto").val("").css({ border: "1px solid #ccc", color: "#737373" });
                $("#search_quantidade").val("").css({ border: "1px solid #ccc", color: "#737373" });
                $("#finalizar_pedido").html("FINALIZAR PEDIDO").prop('disabled', false);
            } else{
                alert(data.msg);
                $("#finalizar_pedido").html("FINALIZAR PEDIDO").prop('disabled', false);
            }
        }).fail(function (data) {
            console.log(data);
            alert("Erro! Não foi possível finalizar a transação. Tente mais tarde.");
            $("#finalizar_pedido").html("FINALIZAR PEDIDO").prop('disabled', false);
        });
    }
});

function monta_tabela() {
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

function calcula_todos_valores() {
    $("#mostra_valor_total").html("R$ 0,00");
    $("#mostra_valor_pago").html("R$ 0,00");
    $("#mostra_troco").html("R$ 0,00");
    if (produtos_inseridos.length > 0) {
        var pega_valor_pago = parseFloat($("#insere_valor_pago").val().replace(",", ""));
        var valor_pago = ($.isNumeric(pega_valor_pago)) ? pega_valor_pago : 0;
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
    } else {
        $("#insere_valor_pago").val("");
    }
}

setInterval(function () { table.ajax.reload(); }, 3000);