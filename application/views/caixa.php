<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lojinha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/dataTables.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css") ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
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
                                    <th scope="col">VALOR UNIT.</th>
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
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="search_id_produto">CÓDIGO PRODUTO</label>
                            <input type="number" id="search_id_produto" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">QUANTIDADE</label>
                            <input type="number" id="search_quantidade" class="form-control">
                        </div>
                        <button class="btn btn-primary" id="search_inserir" style="width: 100%;">INSERIR PRODUTO</button>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="insere_valor_pago">VALOR PAGO</label>
                            <input type="text" data-thousands="." id="insere_valor_pago" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" id="finalizar_venda" style="width: 100%;">FINALIZAR VENDA</button>
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
                                <?php foreach ($produtos as $key => $value) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $value['id_produto'] ?></th>
                                        <td><?php echo $value['nome'] ?></td>
                                        <td>R$ <?php echo str_replace(".", ",", $value['valor']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
    <script src="<?php echo base_url("assets/js/caixa.js"); ?>"></script>
</body>

</html>