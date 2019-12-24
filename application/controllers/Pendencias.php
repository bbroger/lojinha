<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendencias extends CI_Controller
{
    public $produtos;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Lembrete_Lib');
        $this->load->model('Pendencias_model');
    }

    public function index()
    {
        $this->load->view('head', ["lembretes"=> $this->lembrete_lib->consulta_pendencias()]);
        $this->load->view('pendencias');
    }

    public function tabela_pendencias()
    {
        $pendencias = $this->Pendencias_model->pendencias();
        if ($pendencias) {
            usort($pendencias, function ($a, $b) {
                return $a['vencimento'] <=> $b['vencimento'];
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
        $pendencias = $this->Pendencias_model->historico();
        if ($pendencias) {
            usort($pendencias, function ($a, $b) {
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

    public function salvar_pendencia()
    {
        $this->form_validation->set_rules("nome", "<b>Nome</b>", "trim|required|min_length[3]");
        $this->form_validation->set_rules("valor", "<b>Valor</b>", "trim|decimal|min_length[3]");
        $this->form_validation->set_rules("vencimento", "<b>Vencimento</b>", "trim|required|exact_length[10]", ["exact_length" => "Data inválida"]);

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

    public function tirar_pendencia()
    {
        $this->form_validation->set_rules("tipo", "Tipo", "trim|required|in_list[pedido,lembrete]");
        $this->form_validation->set_rules("id", "ID", "trim|required|integer|max_length[11]");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        } else {
            $id = $this->input->post("id");
            $tipo = $this->input->post("tipo");
            if ($tipo == "lembrete") {
                $tabela = "pendencias";
                $id_tabela = "id_pendencia";
            } else {
                $tabela = "pedidos";
                $id_tabela = "id_pedido";
            }

            $this->Pendencias_model->tirar_pendencia($id, $tabela, $id_tabela);
            $data['status'] = true;
            echo json_encode($data);
        }
    }
}
