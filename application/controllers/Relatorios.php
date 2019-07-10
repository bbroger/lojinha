<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relatorios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->login) {
            redirect(base_url("Login"));
        }
        $this->load->model('Relatorios_model');
    }

    public function index()
    {
        $this->load->view('head');
        $this->load->view('relatorios');
    }

    public function vendas_mensal()
    {
        $dados = $this->Relatorios_model->vendas_mensal();
        
        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'mes' && $valor) {
                    if ($chave == 'valor_total') {
                        $arr[$value['mes']][$chave] = $valor;
                    } else {
                        $arr[$value['mes']][$chave] = $valor;
                    }
                } else if ($chave != 'mes' && !isset($arr[$value['mes']][$chave])) {
                    $arr[$value['mes']][$chave] = 0;
                }
            }
        }

        foreach ($arr as $key => $value) {
            $arr[$key]['valor_total'] = $value['valor_total'] + ($value['valor_inserido'] - $value['valor_retirado']);
        }

        $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $supp = [
            "label" => ["Total", "Atacado", "Varejo", "Retirado", "Inserido", "Desconto"],
            "cores" => ['rgba(0,0,255,0.4)', 'rgba(0,128,0,0.4)', 'rgba(0,0,255, 0.4)', 'rgba(255,165,0,0.4)', 'rgba(70,130,180,0.4)', 'rgba(255,0,0.0.4)']
        ];

        $count = 0;
        foreach ($arr as $key => $value) {
            foreach ($value as $chave => $valor) {
                $data[$chave][$count] = $valor;
            }
            $count++;
        }
        
        $label_meses= [];
        foreach ($arr as $key => $value) {
            $count = 0;
            array_push($label_meses, $meses[$key]);
            foreach ($value as $chave => $valor) {
                if ($count == 0) {
                    $vendas_mensal[$count]['type'] = 'line';
                    $vendas_mensal[$count]['borderColor'] = $supp['cores'][$count];
                    $vendas_mensal[$count]['fill'] = false;
                } else {
                    $vendas_mensal[$count]['type'] = 'bar';
                }
                $vendas_mensal[$count]['label'] = $supp['label'][$count];
                $vendas_mensal[$count]['backgroundColor'] = $supp['cores'][$count];
                $vendas_mensal[$count]['data'] = $data[$chave];

                $count++;
            }
        }
        
        return ["label_meses"=> $label_meses, "data"=>$vendas_mensal];
    }
}
