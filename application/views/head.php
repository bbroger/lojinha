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
        <div class="navbar-collapse justify-content-md-center collapse" id="navbarsExample10">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("Pedidos/"); ?>">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('Produtos/'); ?>">Cadastrar produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('Pendencias/'); ?>">Lembrete</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("Contas/"); ?>">Relatório</a>
                </li>
            </ul>
            <a class="navbar-brand mr-auto" href="#">Tato Sorvetes</a>
            <ul class="navbar-nav">
                <li class="nav-item mr-1">
                    <?php echo $lembretes['lembretes']; ?>
                </li>
                <li class="nav-item">
                <?php echo $lembretes['vencidos']; ?>
                </li>
            </ul>
        </div>
    </nav>