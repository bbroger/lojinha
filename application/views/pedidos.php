<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Caixa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/dataTables.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/fontawesome.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css") ?>">
    <script>
        function url_ajax(destino) {
            return "<?php echo base_url(); ?>" + destino;
        }
    </script>
    <style>
        body {
            background-image: url('<?php echo base_url('assets/images/background.jpg'); ?>');
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-7">
                <div class="row">
                    <div class="col-4" style="text-align: center; padding: 20px; border-right: 1px solid black;">
                        <h1>VALOR TOTAL</h1>
                        <h2 id="mostra_valor_total">R$ 0,00</h2>
                    </div>
                    <div class="col-4" style="text-align: center; padding: 20px; border-right: 1px solid black;">
                        <h1>VALOR PAGO</h1>
                        <h2 id="mostra_valor_pago">R$ 0,00</h2>
                    </div>
                    <div class="col-4" style="text-align: center; padding: 20px;">
                        <h1>TROCO</h1>
                        <h2 id="mostra_troco">R$ 0,00</h2>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderless table-striped text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">PRODUTO</th>
                                    <th scope="col">DESCRIÇÃO</th>
                                    <th scope="col">VALOR UNID.</th>
                                    <th scope="col">VALOR PROM.</th>
                                    <th scope="col">QTD</th>
                                    <th scope="col">VALOR TOTAL</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="tabela_produtos_inseridos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-2" style="padding-top: 20px;">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="search_id_produto">CÓDIGO</label>
                                <input type="number" min="0" id="search_id_produto" class="form-control">
                                <small style="color: white; background: red;" id="msg_search_id_produto"></small>
                            </div>
                            <div class="col">
                                <label for="exampleFormControlInput1">QUANTIDADE</label>
                                <input type="number" min="0" id="search_quantidade" class="form-control">
                                <small style="color: white; background: red" id="msg_search_quantidade"></small>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="search_inserir" style="width: 100%;">INSERIR PRODUTO</button>
                    </div>
                </div>
                <hr>
                <div class="row bg-light pb-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" placeholder="Opcional" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="entrega">Data entrega</label>
                            <input type="date" id="entrega" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="obs">Observação</label>
                            <input type="text" id="obs" placeholder="Opcional" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Pedido ou venda?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input transacao" type="radio" name="tipo_transacao" id="tipo_pedido" value="pedido" checked>
                                <label class="form-check-label" for="tipo_pedido">Pedido</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input transacao" type="radio" name="tipo_transacao" id="tipo_venda" value="venda">
                                <label class="form-check-label" for="tipo_venda">Venda</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="insere_valor_pago">VALOR PAGO</label>
                            <input type="text" data-decimal="." id="insere_valor_pago" class="form-control" disabled>
                            <small style="color: white; background: red" id="msg_finalizar_venda"></small>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" value="pagcartao" id="pagcartao" disabled>
                                <label class="form-check-label" for="pagcartao" id="text-pagcartao" style="text-decoration: line-through;">
                                    Pagamento cartão
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="finalizar_venda" style="width: 100%;">FINALIZAR PEDIDO</button>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="row">
                    <div class="col-12" style="padding-top: 20px;">
                        <table class="table table-borderless table-striped text-center" id="catalogo">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">PRODUTO</th>
                                    <th scope="col">VALOR</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ultimasVendas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Últimas 3 vendas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table text-center" style="margin-bottom: 0; padding-bottom: 0;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Valor unid.</th>
                                    <th scope="col">Qtd</th>
                                    <th scope="col">Valor total</th>
                                </tr>
                            </thead>
                            <tbody id="modal_details_table">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/popper.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/moment.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/dataTables.bootstrap4.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/maskMoney.min.js"); ?>"></script>
    <script>
        var venda = '<?php echo $venda; ?>'
    </script>
    <script src="<?php echo base_url("assets/js/pedidos.js"); ?>"></script>
</body>

</html>