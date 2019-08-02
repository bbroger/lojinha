<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-6">
            <h1>Varejo dinheiro</h1>
            <table class="table table-striped text-center" id="varejo_dinheiro">
                <thead class="thead-dark">
                    <tr>fia</th>
                        <th scope="col">Valor total</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Itens</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h1>Varejo cartao</h1>
            <table class="table table-striped text-center" id="varejo_cartao">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Dia</th>
                        <th scope="col">Valor total</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Itens</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-6">
            <h1>Atacado dinheiro</h1>
            <table class="table table-striped text-center" id="atacado_dinheiro">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Dia</th>
                        <th scope="col">Valor total</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Itens</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h1>Atacado cartao</h1>
            <table class="table table-striped text-center" id="atacado_cartao">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Dia</th>
                        <th scope="col">Valor total</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Itens</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalhes da venda</h5>
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
<script src="<?php echo base_url("assets/js/dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/relatorios.js"); ?>"></script>
</body>

</html>