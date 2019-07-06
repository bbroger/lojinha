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
                    <a class="nav-link" href="<?php echo base_url(); ?>">Caixa Varejo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("Caixa/atacado"); ?>">Caixa Atacado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('Produtos/'); ?>">Cadastrar produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Relatórios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("Gerenciamento/"); ?>">Gerenciamento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="<?php echo base_url("Gerenciamento/sair"); ?>">Sair</a>
                </li>
            </ul>
        </div>
    </nav>