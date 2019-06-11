<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lojinha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css") ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/popper.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/moment.min.js"); ?>"></script>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Centered nav only <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <div class="row mt-3">

            <div class="col-md-12">

                <button type="button" class="btn btn-success"><i class="fas fa-plus-circle"></i> Cadastrar novo produto</button>

            </div>

        </div>

        <div class="row mt-3">

            <div class="col-md-12">

                <table class="table table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td id="produto1">Pipa 0,50</td>
                            <td id="descricao1">Pipa médido.</td>
                            <td id="quantidade1">231</td>
                            <td>Ativo</td>
                            <td>
                                <button style="padding: 0 5px;" id="save1" class="btn btn-success" onclick="save(1)" disabled><i class="fas fa-save"></i></button>
                                <button style="padding: 0 5px;" id="edit1" class="btn btn-warning" onclick="edit(1)"><i class="fas fa-edit"></i></button>
                                <button style="padding: 0 5px;" id="block1" class="btn btn-danger" onclick="block(1)"><i class="fas fa-ban"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <script src="<?php echo base_url("assets/js/main.js"); ?>"></script>
</body>

</html>