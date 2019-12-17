<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-danger my-3" data-toggle="modal" data-target="#pendencia"><i class="fas fa-plus-circle"></i> Pendências</button>
            <table class="table table-striped text-center" id="mostra_retirado">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Vencimento</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-success my-3" data-toggle="modal" data-target="#historico"><i class="fas fa-plus-circle"></i> Histórico</button>
            <table class="table table-striped text-center" id="mostra_inserido">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Vencimento</th>
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

<div class="modal fade text-dark" id="valorRetirado" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar valor retirado</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <p id="mostra_msg_retirado"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nome">Qual foi o valor retirado?</label>
                                <input type="text" class="form-control" id="valor_retirado" data-decimal="." value="" placeholder="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descreva o motivo (Se for compras detalhe os produtos e qtde.)</label>
                                <textarea class="form-control" id="descricao_retirado" value="" placeholder="" autocomplete="off"></textarea>
                            </div>
                            <br>
                            <button type="button" id="salvar_retirado" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-dark" id="valorInserido" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar valor inserido</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <p id="mostra_msg_inserido"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nome">Qual o valor inserido?</label>
                                <input type="text" class="form-control" id="valor_inserido" data-decimal="." value="" placeholder="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descreva o motivo (Troco, devolvendo...)</label>
                                <textarea class="form-control" id="descricao_inserido" value="" placeholder="" autocomplete="off"></textarea>
                            </div>
                            <br>
                            <button type="button" id="salvar_inserido" class="btn btn-primary">
                                Registrar
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
<script src="<?php echo base_url("assets/js/pendencias.js"); ?>"></script>
</body>

</html>