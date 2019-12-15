<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relatorios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Relatorios_model');
    }

    public function index()
    {
        $this->load->view('head');
        $this->load->view('relatorios');
    }

    public function gera_tabelas($tipo, $forma){
        $data= $this->Relatorios_model->consulta_diario($tipo, $forma);

        if(!$data){
            echo json_encode(['data'=>false]);
        } else{
            echo json_encode(['data'=>$data]);
        }
    }

    public function consulta_venda_diario($id_transacao)
    {
        $dados = $this->Relatorios_model->consulta_venda_diario($id_transacao);

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                $arr[$value['id_transacao']][$value['id_produto']][$chave] = $valor;
            }
        }

        $tr = null;
        foreach ($arr as $key => $value) {
            foreach ($value as $chave => $valor) {
                $tr .= "<tr><td>" . $valor['nome'] . "</td>";
                $tr .= "<td>R$ " . $valor['valor'] . "</td>";
                $tr .= "<td>" . $valor['quantidade_vendido'] . "</td>";
                $tr .= "<td>R$ " . number_format($valor['valor'] * $valor['quantidade_vendido'], 2, '.', '') . "</td></tr>";
            }
            $tr .= "<tr><td></td><td>Pago: R$ " . $valor['valor_pago'] . "</td><td>Total: R$ " . $valor['valor_total'] . "</td></td><td>Desconto: R$ " . $valor['desconto'] . "</td></tr>";
            $tr .= "<tr><td></td><td>" . DateTime::createFromFormat('Y-m-d H:i:s', $valor['timestamp'])->format("d/m H:i");
            $tr .= "</td><td>" . ucfirst($valor['tipo_pagamento']) . "</td><td>" . ucfirst($valor['venda']) . "</td></tr>";
            $tr .= "<tr style='background: #A4A4A4'><td colspan='4'>&nbsp;</td></tr>";
        }

        $data['status'] = true;
        $data['table'] = $tr;

        echo json_encode($data);
    }
}
