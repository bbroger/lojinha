<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produtos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produtos_model');
    }

    public function index()
    {
        $this->load->view('cadastrar_produtos');
    }

    public function tabela_produtos()
    {
        $produtos = $this->Produtos_model->tabela_produtos();

        echo json_encode($produtos);
    }

    public function salvar_produto()
    {
        $this->form_validation->set_rules("nome", "<b>Nome</b>", "trim|required|min_length[3]|max_length[255]");
        $this->form_validation->set_rules("descricao", "<b>Nome Descrição</b>", "trim|min_length[3]|max_length[255]");
        $this->form_validation->set_rules("valor", "<b>Valor</b>", "trim|required|decimal|min_length[3]|max_length[6]");
        $this->form_validation->set_rules("quantidade", "<b>Quantidade</b>", "trim|integer|max_length[11]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $data['nome'] = $this->input->post("nome");
            $data['descricao'] = $this->input->post("descricao");
            $data['valor'] = $this->input->post("valor");
            $data['quantidade'] = $this->input->post("quantidade");

            $this->Produtos_model->salvar_produto($data);

            $data['msg'] = "<p><b>" . $data['nome'] . " cadastrado com sucesso!</b></p>";
            $data['status'] = true;
            echo json_encode($data);

            return true;
        }
    }

    public function editar_produto()
    {
        $this->form_validation->set_rules("id_produto", "ID produto", "trim|required|max_length[11]");
        $this->form_validation->set_rules("nome", "Nome", "trim|required|min_length[3]|max_length[255]");
        $this->form_validation->set_rules("descricao", "Descrição", "trim|min_length[3]|max_length[255]");
        $this->form_validation->set_rules("valor", "Valor", "trim|required|decimal|min_length[3]");
        $this->form_validation->set_rules("quantidade", "Quantidade", "trim|integer|max_length[11]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" "," ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_produto = $this->input->post("id_produto");
            $data['nome'] = $this->input->post("nome");
            $data['descricao'] = $this->input->post("descricao");
            $data['valor'] = $this->input->post("valor");
            $data['quantidade'] = $this->input->post("quantidade");

            $re = $this->Produtos_model->editar_produto($data, $id_produto);

            if ($re) {
                $data['status'] = true;
                echo json_encode($data);
            } else{
                $data_erro['msg'] = "Erro! O id_produto ($id_produto) não foi localizado";
                $data_erro['status'] = false;
                echo json_encode($data_erro);
            }
        }
    }
}
