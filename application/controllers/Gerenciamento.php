<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerenciamento extends CI_Controller
{
    public $produtos;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gerenciamento_model');
    }

    public function index()
    {
        $this->load->view('gerenciamento');
    }

    public function tabela_retirados()
    {
        $retirados = $this->Gerenciamento_model->tabela_retirados();
        if ($retirados) {
            foreach ($retirados as $key => $value) {
                foreach ($value as $chave => $valor) {
                    if ($chave == 'timestamp') {
                        $data['data'][$key][$chave] = DateTime::createFromFormat('Y-m-d H:i:s', $valor)->format('d/m H:i');
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
}
