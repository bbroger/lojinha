<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produtos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->login){
            redirect(base_url("Login"));
        }
        $this->load->model('Produtos_model');
    }

    public function index()
    {
        $this->load->view('cadastrar_produtos');
    }

    public function tabela_produtos()
    {
        $produtos = $this->Produtos_model->tabela_produtos();

        if ($produtos) {
            foreach ($produtos as $key => $value) {
                foreach ($value as $chave => $valor) {
                    $data['data'][$key][$chave] = $valor;
                    if($chave == 'nova_quantidade' && !is_null($valor)){
                        $data['data'][$key]['quantidade'] = $valor;
                    }
                }
                if($value['status'] == 'ativo'){
                    $buttonStatus= '<button style="padding: 0 5px;" class="btn btn-warning edit"><i class="fas fa-edit"></i></button> 
                    <button style="padding: 0 5px;" class="btn btn-danger block"><i class="fas fa-ban"></i></button>';
                } else{
                    $buttonStatus= '<button style="padding: 0 5px;" class="btn btn-warning edit" disabled><i class="fas fa-edit"></i></button> 
                    <button style="padding: 0 5px;" class="btn btn-danger activ"><i class="fas fa-check"></i></button>';
                }
                $data['data'][$key]['button'] = '<button style="padding: 0 5px;" class="btn btn-success save" disabled><i class="fas fa-save"></i></button> 
                    '.$buttonStatus
                    .' <button style="padding: 0 5px;" class="btn btn-primary add"><i class="fas fa-shopping-cart"></i></button>';
            }

            echo json_encode($data);
        } else {
            echo json_encode(["data" => false]);
        }
    }

    public function tabela_promocao()
    {
        $promocao = $this->Produtos_model->tabela_promocao();

        if ($promocao) {
            foreach ($promocao as $key => $value) {
                foreach ($value as $chave => $valor) {
                    $data['data'][$key][$chave] = $valor;
                }
                if($value['status'] == 'ativo'){
                    $buttonStatus= '<button style="padding: 0 5px;" class="btn btn-danger block"><i class="fas fa-ban"></i></button>';
                } else{
                    $buttonStatus= '<button style="padding: 0 5px;" class="btn btn-danger activ"><i class="fas fa-check"></i></button>';
                }
                $data['data'][$key]['button'] = $buttonStatus;
            }

            echo json_encode($data);
        } else {
            echo json_encode(["data" => false]);
        }
    }

    public function salvar_produto()
    {
        $this->form_validation->set_rules("nome", "<b>Nome</b>", "trim|required|min_length[3]|max_length[255]|is_unique[produtos.nome]");
        $this->form_validation->set_rules("descricao", "<b>Nome Descrição</b>", "trim|min_length[3]|max_length[255]");
        $this->form_validation->set_rules("valorVarejo", "<b>Valor Varejo</b>", "trim|decimal|min_length[3]|callback_check_valores");
        $this->form_validation->set_rules("valorAtacado", "<b>Valor Atacado</b>", "trim|decimal|min_length[3]|callback_check_valores");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $data['nome'] = $this->input->post("nome");
            $data['descricao'] = $this->input->post("descricao");
            $vare= $this->input->post("valorVarejo");
            $data['valorVarejo'] = ($vare) ? $vare : 0;
            $ata= $this->input->post("valorAtacado");
            $data['valorAtacado'] = ($ata) ? $ata : 0;

            $this->Produtos_model->salvar_produto($data);

            $data['msg'] = "<p><b>" . $data['nome'] . " cadastrado com sucesso!</b></p>";
            $data['status'] = true;
            echo json_encode($data);

            return true;
        }
    }

    public function check_valores(){
        $varejo= $this->input->post("valorVarejo");
        $atacado= $this->input->post("valorAtacado");

        if($varejo || $atacado){
            return true;
        } else{
            $this->form_validation->set_message("check_valores", "Erro nos <b>valores</b>. Informe pelo menos um <b>Valor</b>");
            return false;
        }
    }

    public function editar_produto()
    {
        $this->form_validation->set_rules("id_produto", "ID produto", "trim|required|max_length[11]|combines[produtos.id_produto]");
        $this->form_validation->set_rules("descricao", "Descrição", "trim|min_length[3]|max_length[255]");
        $this->form_validation->set_rules("valorVarejo", "Valor Varejo", "trim|required|decimal|min_length[3]");
        $this->form_validation->set_rules("valorAtacado", "Valor Atacado", "trim|required|decimal|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_produto = $this->input->post("id_produto");
            $data['nome'] = $this->input->post("nome");
            $data['descricao'] = $this->input->post("descricao");
            $data['valorVarejo'] = $this->input->post("valorVarejo");
            $data['valorAtacado'] = $this->input->post("valorAtacado");

            $this->Produtos_model->editar_produto($data, $id_produto);
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function desativar_produto()
    {
        $this->form_validation->set_rules("id_produto", "ID produto", "trim|required|max_length[11]|combines[produtos.id_produto]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_produto = $this->input->post("id_produto");
            $data['status'] = 'desativado';

            $this->Produtos_model->desativar_produto($data, $id_produto);
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function ativar_produto()
    {
        $this->form_validation->set_rules("id_produto", "ID produto", "trim|required|max_length[11]|combines[produtos.id_produto]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_produto = $this->input->post("id_produto");
            $data['status'] = 'ativo';

            $this->Produtos_model->ativar_produto($data, $id_produto);
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function acao_estoque()
    {
        $this->form_validation->set_rules("id_produto", "ID produto", "trim|required|integer|max_length[11]|combines[produtos.id_produto]");
        $this->form_validation->set_rules("quantidade", "Quantidade", "trim|required|integer|greater_than[0]|max_length[11]", ["required"=> "Você precisa <b>inserir</b> um valor para Adicionar/Remover"]);
        $this->form_validation->set_rules("qtdeAtual", "Quantidade atual", "trim|required|integer|max_length[11]");
        $this->form_validation->set_rules("acao", "Ação", "trim|in_list[add,remover]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_produto = $this->input->post("id_produto");
            $acao= $this->input->post("acao");
            $data['quantidade'] = $this->input->post("quantidade");

            $this->Produtos_model->acao_estoque($data, $acao, $id_produto);

            $data2['id_produto']= $id_produto;
            $data2['quantidade_atual']= $this->input->post("qtdeAtual");
            $data2['quantidade_inserido']= $this->input->post("quantidade");
            $data2['acao']= $acao;

            $this->Produtos_model->save_acao_estoque($data2, $id_produto);

            $data['msg'] = ($acao == 'add') ? "<p><b>Estoque adicionado com sucesso!</b></p>" : "<p><b>Estoque removido com sucesso!</b></p>";
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function salvar_promocao()
    {
        $this->form_validation->set_rules("id_produto", "ID produto", "trim|required|max_length[11]|combines[produtos.id_produto]");
        $this->form_validation->set_rules("quantidade", "<b>Quantidade</b>", "trim|required|integer|max_length[11]");
        $this->form_validation->set_rules("valor", "<b>Valor</b>", "trim|required|decimal|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $data['id_produto'] = $this->input->post("id_produto");
            $data['quantidade'] = $this->input->post("quantidade");
            $data['valor'] = $this->input->post("valor");

            $this->Produtos_model->salvar_promocao($data);

            $data['msg'] = "<p><b>Promoçao cadastrado com sucesso!</b></p>";
            $data['status'] = true;
            echo json_encode($data);

            return true;
        }
    }

    public function editar_promocao()
    {
        $this->form_validation->set_rules("id_promocao", "ID promocao", "trim|required|max_length[11]|combines[promocao.id_promocao]");
        $this->form_validation->set_rules("quantidade", "Quantidade", "trim|integer|max_length[11]");
        $this->form_validation->set_rules("valor", "Valor", "trim|required|decimal|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_promocao = $this->input->post("id_promocao");
            $data['quantidade'] = $this->input->post("quantidade");
            $data['valor'] = $this->input->post("valor");

            $this->Produtos_model->editar_promocao($data, $id_promocao);
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function desativar_promocao()
    {
        $this->form_validation->set_rules("id_promocao", "ID promocao", "trim|required|max_length[11]|combines[promocao.id_promocao]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_promocao = $this->input->post("id_promocao");
            $data['status'] = 'desativado';

            $this->Produtos_model->desativar_promocao($data, $id_promocao);
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function ativar_promocao()
    {
        $this->form_validation->set_rules("id_promocao", "ID promocao", "trim|required|max_length[11]|combines[promocao.id_promocao]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_promocao = $this->input->post("id_promocao");
            $data['status'] = 'ativo';

            $this->Produtos_model->ativar_promocao($data, $id_promocao);
            $data['status'] = true;
            echo json_encode($data);
        }
    }
}
