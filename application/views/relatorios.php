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
                        <div class="col-4">
                            <table class="table table-striped text-center" id="mostra_tabela">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Data</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Itens</th>
                                        <th scope="col">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="graphWeek" style="height: 290px;"></canvas>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <canvas id="graphDay" style="height: 290px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="<?php echo base_url("assets/js/chartjs.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/circliful.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/relatorios.js"); ?>"></script>
</body>

</html>