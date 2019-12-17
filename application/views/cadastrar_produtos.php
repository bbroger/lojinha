
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success clearModal" data-toggle="modal" data-target="#novoProduto"><i class="fas fa-plus-circle"></i> Cadastrar novo produto</button>
                    <button type="button" class="btn btn-info clearModal" data-toggle="modal" data-target="#novaPromocao"><i class="fas fa-plus-circle"></i> Cadastrar nova promoção</button>
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
                                        <label for="valorVarejo">Valor varejo</label>
                                        <input type="text" class="form-control" id="valorVarejo" data-decimal="." value="" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="col">
                                    <label for="valorAtacado">Valor atacado</label>
                                        <input type="text" class="form-control" id="valorAtacado" data-decimal="." value="" placeholder="" autocomplete="off">
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

    <div class="modal fade text-dark" id="addEstoque" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estoque</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <p id="mostra_msg_estoque"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="id_produto_estoque" value="">
                                <label for="nome">O que você quer fazer?</label>
                                <div class="form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="adicionar_estoque" name="acao_estoque" value="add" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="adicionar_estoque">Adicionar estoque</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="remover_estoque" name="acao_estoque" value="remover" class="custom-control-input">
                                        <label class="custom-control-label" for="remover_estoque">Remover estoque</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nome_produto_estoque">Nome produto</label>
                                    <input type="text" class="form-control" id="nome_produto_estoque" min="0" value="" placeholder="" autocomplete="off" disabled>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="qtde_atual_estoque">Qtde atual</label>
                                        <input type="number" class="form-control" id="qtde_atual_estoque" value="" placeholder="" autocomplete="off" disabled>
                                    </div>
                                    <div class="col">
                                        <label for="qtde_acao_estoque" id="label_acao_estoque">Adicionar</label>
                                        <input type="number" class="form-control" id="qtde_acao_estoque" min="0" value="" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="qtde_total_estoque">Qtde total</label>
                                        <input type="number" class="form-control" id="qtde_total_estoque" value="" placeholder="" autocomplete="off" disabled>
                                    </div>
                                </div>
                                <br>
                                <button type="button" id="salvar_novo_estoque" class="btn btn-primary">
                                    Adicionar estoque
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