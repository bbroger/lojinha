<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12" style="background-color: rgba(255,255,255,0.4)">
            <div class="row">
                <div class="col-2">
                    <nav class="nav flex-column">
                        <button class="btn btn-outline-dark btn-lg filtro active" id="btnvendas" href="#">Vendas</button>

                        <button class="btn btn-outline-primary btn-lg filtro mt-5" id="btndinheiro" href="#">Dinheiro</button>

                        <button class="btn btn-outline-success btn-lg filtro mt-5" id="btncartao" href="#">Cartão</button>
                    </nav>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="graphMonth" style="height: 380px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="graphTotalTrans" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="graphTotalVendas" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6" style="padding-right: 0;">
                                            <div id="circlefulMoney" style="height: 150px; width: 150px; margin: 0 auto;"></div>
                                        </div>
                                        <div class="col-6" style="padding-left: 0;">
                                            <div id="circlefulCard" style="height: 150px; width: 150px; margin: 0 auto;"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6" style="padding-right: 0;">
                                            <div id="circlefulAtacado" style="height: 150px; width: 150px; margin: 0 auto;"></div>
                                        </div>
                                        <div class="col-6" style="padding-left: 0;">
                                            <div id="circlefulVarejo" style="height: 150px; width: 150px; margin: 0 auto;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="graphWeek" style="height: 380px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <p style="font-size: 13px; font-weight: bold; text-align: center; color: rgb(102,102,102)">Vendas semanal</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped text-center" id="mostra_tabela_semanal">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">Data</th>
                                                            <th scope="col">Valor</th>
                                                            <th scope="col">Desconto</th>
                                                            <th scope="col">Vendas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p style="font-size: 13px; font-weight: bold; text-align: center; color: rgb(102,102,102)">Vendas diário</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped text-center" id="mostra_tabela_diario">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">Data</th>
                                                            <th scope="col">Valor</th>
                                                            <th scope="col">Desconto</th>
                                                            <th scope="col">Itens</th>
                                                            <th scope="col">Ver</th>
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
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="graphDay" style="height: 380px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalhes</h5>
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
<script src="<?php echo base_url("assets/js/chartjs.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/circliful.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/relatorios.js"); ?>"></script>
</body>

</html>