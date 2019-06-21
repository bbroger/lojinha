$("#valor").maskMoney();

var table = $("#mostra_tabela").DataTable({
    "processing": true,
    "order": [[0, "desc"]],
    ajax: url_ajax("Produtos/tabela_produtos"),
    "columns": [
        { "data": "id_produto" },
        { "data": "nome" },
        { "data": "descricao" },
        { "data": "valor" },
        { "data": "quantidade" },
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

table.on('click', '.edit', function () {
    var tr = $(this).closest("tr");
    var tdNome = tr.find("td").eq(1);
    var tdDesc = tr.find("td").eq(2);
    var tdValor = tr.find("td").eq(3);
    var tdQtde = tr.find("td").eq(4);

    tdNome.html("<input type='text' class='form-control' value='" + tdNome.html() + "'>");
    tdDesc.html("<input type='text' class='form-control' value='" + tdDesc.html() + "'>");
    tdValor.html("<input type='text' style='width: 70%; margin: auto auto;' data-decimal='.' class='form-control' value='" + tdValor.html().replace("R$ ", "") + "'>");
    tdValor.find("input").maskMoney();
    tdQtde.html("<input type='number' style='width: 60%; margin: auto auto;' class='form-control' value='" + tdQtde.html() + "'>");

    $(this).closest("td").find('button').eq(0).prop('disabled', false);
    $(this).closest("td").find('button').eq(1).prop('disabled', true);
});

table.on('click', '.save', function () {
    var tr = $(this).closest("tr");
    var tdID= tr.find("td").eq(0);
    var tdNome = tr.find("td").eq(1);
    var tdDesc = tr.find("td").eq(2);
    var tdValor = tr.find("td").eq(3);
    var tdQtde = tr.find("td").eq(4);
    
    $.ajax({
        url: url_ajax("Produtos/editar_produto"),
        type: "Post",
        data: {
            id_produto : tdID.html(),
            nome: tdNome.find('input').val(),
            descricao: tdDesc.find('input').val(),
            valor: tdValor.find('input').val(),
            quantidade: tdQtde.find('input').val()
        },
        dataType: "Json"
    }).done(function (data) {
        if (data.status) {
            tdNome.html(tdNome.find('input').val());
            tdDesc.html(tdDesc.find('input').val());
            tdValor.html("R$ " + tdValor.find('input').val());
            tdQtde.html(tdQtde.find('input').val());

            tr.find("td").eq(6).find('button').eq(0).prop('disabled', true)
            tr.find("td").eq(6).find('button').eq(1).prop('disabled', false)
        } else{
            tdNome.find('input').css({border: "1px solid red", color: "red"});
            tdDesc.find('input').css({border: "1px solid red", color: "red"});
            tdValor.find('input').css({border: "1px solid red", color: "red"});
            tdQtde.find('input').css({border: "1px solid red", color: "red"});
            alert(data.msg);
        }
    });
});

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
            valor: valor.val().replace(",", ""),
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
        alert('Erro ao criar o produto. Tente mais tarde');
    });
});