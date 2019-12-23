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

    public function tabela_pendencias()
    {
        $pendencias = $this->Pendencias_model->pendencias();
        if ($pendencias) {
            usort($pendencias, function($a, $b) {
                return $b['vencimento'] <=> $a['vencimento'];
            });
            foreach ($pendencias as $key => $value) {
                foreach ($value as $chave => $valor) {
                    if ($chave == 'vencimento') {
                        $data['data'][$key][$chave] = DateTime::createFromFormat('Y-m-d', $valor)->format('d/m');
                    } else {
                        $data['data'][$key][$chave] = $valor;
                    }
                }
                $data['data'][$key]['button'] = '<button style="padding: 0 5px;" class="btn btn-success save"><i class="fas fa-check"></i>';
            }

            echo json_encode($data);
        } else {
            echo json_encode(["data" => false]);
        }
    }

    public function tabela_historico()
    {
        $historico = $this->Pendencias_model->tabela_historico();
        if ($historico) {
            foreach ($historico as $key => $value) {
                foreach ($value as $chave => $valor) {
                    if ($chave == 'vencimento') {
                        $data['data'][$key][$chave] = DateTime::createFromFormat('Y-m-d ', $valor)->format('d/m');
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

    public function salvar_pendencia()
    {
        $this->form_validation->set_rules("nome", "<b>Nome</b>", "trim|required|min_length[3]");
        $this->form_validation->set_rules("valor", "<b>Valor</b>", "trim|decimal|min_length[3]");
        $this->form_validation->set_rules("vencimento", "<b>Vencimento</b>", "trim|required|exact_length[10]", ["exact_length"=> "Data inválida"]);

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $data['nome'] = $this->input->post("nome");
            $data['valor'] = $this->input->post("valor");
            $data['vencimento'] = $this->input->post("vencimento");

            $this->Pendencias_model->salvar_pendencia($data);

            $data['msg'] = "<p><b>Pendencia registrado com sucesso!</b></p>";
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

            $this->Pendencias_model->editar_valor_retirado($data, $id_movimentacao);
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

            $this->Pendencias_model->salvar_valor_inserido($data);

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

            $this->Pendencias_model->editar_valor_inserido($data, $id_movimentacao);
            $data['status'] = true;
            echo json_encode($data);
        }
    }
}
