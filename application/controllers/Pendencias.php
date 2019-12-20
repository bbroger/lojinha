<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendencias extends CI_Controller
{
    public $produtos;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pendencias_model');
    }

    public function index()
    {
        $this->load->view('head');
        $this->load->view('pendencias');
    }

    public function tabela_pendecias()
    {
        $pendencias = $this->Gerenciamento_model->pendencias();
        if ($pendencias) {
            foreach ($pendencias as $key => $value) {
                foreach ($value as $chave => $valor) {
                    if ($chave == 'timestamp') {
                        $data['data'][$key][$chave] = DateTime::createFromFormat('Y-m-d H:i:s', $valor)->format('d/m');
                    } else {
                        $data['data'][$key][$chave] = $valor;
                    }
                }
                $data['data'][$key]['button'] = '<button style="padding: 0 5px;" class="btn btn-success save" disabled><i class="fas fa-save"></i></button> 
                    <button style="padding: 0 5px;" class="btn btn-warning edit"><i class="fas fa-edit"></i></button>';
            }

            echo json_encode($data);
        } else {
            echo json_encode(["data" => false]);
        }
    }

    public function tabela_inseridos()
    {
        $inseridos = $this->Gerenciamento_model->tabela_inseridos();
        if ($inseridos) {
            foreach ($inseridos as $key => $value) {
                foreach ($value as $chave => $valor) {
                    if ($chave == 'timestamp') {
                        $data['data'][$key][$chave] = DateTime::createFromFormat('Y-m-d H:i:s', $valor)->format('d/m');
                    } else {
                        $data['data'][$key][$chave] = $valor;
                    }
                }
                $data['data'][$key]['button'] = '<button style="padding: 0 5px;" class="btn btn-success save" disabled><i class="fas fa-save"></i></button> 
                    <button style="padding: 0 5px;" class="btn btn-warning edit"><i class="fas fa-edit"></i></button>';
            }

            echo json_encode($data);
        } else {
            echo json_encode(["data" => false]);
        }
    }

    public function salvar_valor_retirado()
    {
        $this->form_validation->set_rules("valor", "<b>Valor</b>", "trim|required|decimal|min_length[3]");
        $this->form_validation->set_rules("descricao", "<b>Nome Descrição</b>", "trim|required|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $data['valor'] = $this->input->post("valor");
            $data['descricao'] = $this->input->post("descricao");
            $data['tipo'] = 'retirado';

            $this->Gerenciamento_model->salvar_valor_retirado($data);

            $data['msg'] = "<p><b>Valor retirado registrado com sucesso!</b></p>";
            $data['status'] = true;
            echo json_encode($data);

            return true;
        }
    }

    public function editar_valor_retirado()
    {
        $this->form_validation->set_rules("id_movimentacao", "Movimentação", "trim|required|max_length[11]|combines[movimentacao.id_movimentacao]");
        $this->form_validation->set_rules("valor", "Valor", "trim|required|decimal|min_length[3]");
        $this->form_validation->set_rules("descricao", "Descrição", "trim|required|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_movimentacao = $this->input->post("id_movimentacao");
            $data['valor'] = $this->input->post("valor");
            $data['descricao'] = $this->input->post("descricao");

            $this->Gerenciamento_model->editar_valor_retirado($data, $id_movimentacao);
            $data['status'] = true;
            echo json_encode($data);
        }
    }

    public function salvar_valor_inserido()
    {
        $this->form_validation->set_rules("valor", "<b>Valor</b>", "trim|required|decimal|min_length[3]");
        $this->form_validation->set_rules("descricao", "<b>Nome Descrição</b>", "trim|required|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $data['valor'] = $this->input->post("valor");
            $data['descricao'] = $this->input->post("descricao");
            $data['tipo'] = 'inserido';

            $this->Gerenciamento_model->salvar_valor_inserido($data);

            $data['msg'] = "<p><b>Valor inserido registrado com sucesso!</b></p>";
            $data['status'] = true;
            echo json_encode($data);

            return true;
        }
    }

    public function editar_valor_inserido()
    {
        $this->form_validation->set_rules("id_movimentacao", "Movimentação", "trim|required|max_length[11]|combines[movimentacao.id_movimentacao]");
        $this->form_validation->set_rules("valor", "Valor", "trim|required|decimal|min_length[3]");
        $this->form_validation->set_rules("descricao", "Descrição", "trim|required|min_length[3]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id_movimentacao = $this->input->post("id_movimentacao");
            $data['valor'] = $this->input->post("valor");
            $data['descricao'] = $this->input->post("descricao");

            $this->Gerenciamento_model->editar_valor_inserido($data, $id_movimentacao);
            $data['status'] = true;
            echo json_encode($data);
        }
    }
}
