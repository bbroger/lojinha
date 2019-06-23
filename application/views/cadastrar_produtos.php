<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse justify-content-md-center collapse" id="navbarsExample10" style="">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>">Caixa</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Cadastrar produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Relatórios</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
    <div class="row mt-3">
            <div class="col-md-12">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoProduto"><i class="fas fa-plus-circle"></i> Cadastrar novo produto</button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#novaPromocao"><i class="fas fa-plus-circle"></i> Cadastrar nova promoção</button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-striped text-center" id="mostra_tabela">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Qtde</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table table-striped text-center" id="mostra_tabela_promocao">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Código</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Valor (unid)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Modal criar produto-->
    <div class="modal fade text-dark" id="novoProduto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo produto</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <p id="mostra_msg"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" id="nome" value="" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control" id="descricao" value="" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="valor">Valor</label>
                                        <input type="text" class="form-control" id="valor" data-decimal="." value="" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="quantidade">Quantidade</label>
                                        <input type="number" class="form-control" id="quantidade" value="0" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <br>
                                <button type="button" id="salvar_produto" class="btn btn-primary">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal criar produto-->
    <div class="modal fade text-dark" id="novaPromocao" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova promoção</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <p id="mostra_msg_promo"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nome">ID produto</label>
                                    <input type="number" class="form-control" id="produto_promo" min="0" value="" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="quantidade">Quantidade mínima</label>
                                        <input type="number" class="form-control" id="quantidade_promo" value="0" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="valor">Valor promocional (unidade)</label>
                                        <input type="text" class="form-control" id="valor_promo" data-decimal="." value="" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <br>
                                <button type="button" id="salvar_promocao" class="btn btn-primary">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
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
    <script src="<?php echo base_url("assets/js/produtos.js"); ?>"></script>
</body>

</html>