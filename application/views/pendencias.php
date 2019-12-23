<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#lembrete"><i class="fas fa-plus-circle"></i> Lembrete</button>
            <table class="table table-striped table-bordered text-center" id="mostra_pendencia">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Vencimento</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-success my-3" data-toggle="modal" data-target="#historico"><i class="fas fa-plus-circle"></i> Histórico</button>
            <table class="table table-striped text-center" id="mostra_historico">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Vencimento</th>
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

<div class="modal fade text-dark" id="lembrete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar um lembrete</h5>
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
                                <label for="nome">Nome da pendencia</label>
                                <input type="text" class="form-control" id="nome" value="" placeholder="" autocomplete="off">
                            </div>
                            <div class="row">
                            <div class="col">
                                    <label for="descricao">Valor (opcional)</label>
                                    <input type="text" class="form-control" id="valor" data-decimal="." value="" placeholder="" autocomplete="off">
                                </div>
                                <div class="col">
                                    <label for="descricao">Vencimento</label>
                                    <input type="date" class="form-control" id="vencimento" value="" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <br>
                            <button type="button" id="salvar_pendencia" class="btn btn-primary">
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
<script src="<?php echo base_url("assets/js/pendencias.js"); ?>"></script>
</body>

</html>