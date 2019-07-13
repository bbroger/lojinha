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
        $data['mensal'] = $this->vendas_mensal();
        $data['semanal'] = $this->vendas_semanal();
        $data['diario'] = $this->vendas_diario();
        $pega= $this->transacao();
        $data['transacao'] = $pega['transacao'];
        $data['circliful'] = $pega['circliful'];
        $data['total_produtos'] = $this->total_produtos();
        $tabela= $this->tabela_transacao();

        $this->load->view('head');
        $this->load->view('relatorios', ["relatorios"=> json_encode($data), "table"=> json_encode($tabela)]);
    }

    public function monta_relatorio()
    {
        $data['mensal'] = $this->vendas_mensal();
        $data['semanal'] = $this->vendas_semanal();
        $data['diario'] = $this->vendas_diario();
        $pega= $this->transacao();
        $data['transacao'] = $pega['transacao'];
        $data['circliful'] = $pega['circliful'];
        $data['total_produtos'] = $this->total_produtos();

        echo json_encode($data);
    }

    public function vendas_mensal()
    {
        $dados = $this->Relatorios_model->vendas('%c');

        if(!$dados){
            return $obj['data']= false;
        }

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'chave' && $valor) {
                    if ($chave == 'valor_desconto' || $chave == 'valor_retirado') {
                        $arr[$value['chave']][$chave] = ($valor > 0) ? -$valor : 0;
                    } else {
                        $arr[$value['chave']][$chave] = $valor;
                    }
                } else if ($chave != 'chave' && !isset($arr[$value['chave']][$chave])) {
                    $arr[$value['chave']][$chave] = 0;
                }
            }
        }

        foreach ($arr as $key => $value) {
            $arr[$key]['valor_pago'] = $value['valor_pago'] + ($value['valor_inserido'] - abs($value['valor_retirado']));
        }

        $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $supp = [
            "label" => ["Total pago", "Atacado", "Varejo", "Retirado", "Inserido", "Desconto"],
            "cores" => ['rgb(0,0,255)', 'rgba(0,128,0,0.6)', 'rgba(0,0,255,0.6)', 'rgba(255,165,0,0.6)', 'rgba(70,130,180,0.6)', 'rgba(255,0,0,0.6)'],
            "borda" => ['rgb(0,0,255)', 'rgb(0,128,0)', 'rgb(0,0,255)', 'rgb(255,165,0)', 'rgb(70,130,180)', 'rgb(255,0,0)']
        ];

        $count = 0;
        foreach ($arr as $key => $value) {
            foreach ($value as $chave => $valor) {
                $data[$chave][$count] = $valor;
            }
            $count++;
        }

        $label_meses = [];
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
                $vendas_mensal[$count]['borderWidth'] = 2;
                $vendas_mensal[$count]['backgroundColor'] = $supp['cores'][$count];
                $vendas_mensal[$count]['borderColor'] = $supp['borda'][$count];
                $vendas_mensal[$count]['data'] = $data[$chave];

                $count++;
            }
        }

        $obj['data']['labels'] = $label_meses;
        $obj['data']['datasets'] = $vendas_mensal;

        return $obj;
    }

    public function vendas_semanal()
    {
        $dados = $this->Relatorios_model->vendas('%V');
        
        if(!$dados){
            return $obj['data']= false;
        }

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'chave' && $valor) {
                    if ($chave == 'valor_desconto' || $chave == 'valor_retirado') {
                        $arr[$value['chave']][$chave] = ($valor > 0) ? -$valor : 0;
                    } else {
                        $arr[$value['chave']][$chave] = $valor;
                    }
                } else if ($chave != 'chave' && !isset($arr[$value['chave']][$chave])) {
                    $arr[$value['chave']][$chave] = 0;
                }
            }
        }

        foreach ($arr as $key => $value) {
            $arr[$key]['valor_pago'] = $value['valor_pago'] + ($value['valor_inserido'] - $value['valor_retirado']);
        }

        krsort($arr);

        $semana = array_slice($arr, 0, 7, true);

        ksort($semana);

        $supp = [
            "label" => ["Total pago", "Atacado", "Varejo", "Retirado", "Inserido", "Desconto"],
            "cores" => ['rgb(0,0,255)', 'rgba(0,128,0,0.6)', 'rgba(0,0,255, 0.6)', 'rgba(255,165,0,0.6)', 'rgba(70,130,180,0.6)', 'rgba(255,0,0,0.6)'],
            "borda" => ['rgb(0,0,255)', 'rgb(0,128,0)', 'rgb(0,0,255)', 'rgb(255,165,0)', 'rgb(70,130,180)', 'rgb(255,0,0)']
        ];

        $count = 0;
        foreach ($semana as $key => $value) {
            foreach ($value as $chave => $valor) {
                $data[$chave][$count] = $valor;
            }
            $count++;
        }

        $label_semana = [];
        foreach ($semana as $key => $value) {
            $count = 0;
            array_push($label_semana, "S" . $key);
            foreach ($value as $chave => $valor) {
                if ($count == 0) {
                    $vendas_semanal[$count]['type'] = 'line';
                    $vendas_semanal[$count]['borderColor'] = $supp['cores'][$count];
                    $vendas_semanal[$count]['fill'] = false;
                } else {
                    $vendas_semanal[$count]['type'] = 'bar';
                }
                $vendas_semanal[$count]['label'] = $supp['label'][$count];
                $vendas_semanal[$count]['borderWidth'] = 2;
                $vendas_semanal[$count]['backgroundColor'] = $supp['cores'][$count];
                $vendas_semanal[$count]['borderColor'] = $supp['borda'][$count];
                $vendas_semanal[$count]['data'] = $data[$chave];

                $count++;
            }
        }

        $obj['data']['labels'] = $label_semana;
        $obj['data']['datasets'] = $vendas_semanal;

        return $obj;
    }

    public function vendas_diario()
    {
        $dados = $this->Relatorios_model->vendas('%Y-%m-%d');
        
        if(!$dados){
            return $obj['data']= false;
        }

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'chave' && $valor) {
                    if ($chave == 'valor_desconto' || $chave == 'valor_retirado') {
                        $arr[$value['chave']][$chave] = ($valor > 0) ? -$valor : 0;
                    } else {
                        $arr[$value['chave']][$chave] = $valor;
                    }
                } else if ($chave != 'chave' && !isset($arr[$value['chave']][$chave])) {
                    $arr[$value['chave']][$chave] = 0;
                }
            }
        }

        foreach ($arr as $key => $value) {
            $arr[$key]['valor_pago'] = $value['valor_pago'] + ($value['valor_inserido'] - $value['valor_retirado']);
        }

        krsort($arr);

        $dia = array_slice($arr, 0, 7, true);

        ksort($dia);

        $supp = [
            "label" => ["Total pago", "Atacado", "Varejo", "Retirado", "Inserido", "Desconto"],
            "cores" => ['rgb(0,0,255)', 'rgba(0,128,0,0.6)', 'rgba(0,0,255, 0.6)', 'rgba(255,165,0,0.6)', 'rgba(70,130,180,0.6)', 'rgba(255,0,0,0.6)'],
            "borda" => ['rgb(0,0,255)', 'rgb(0,128,0)', 'rgb(0,0,255)', 'rgb(255,165,0)', 'rgb(70,130,180)', 'rgb(255,0,0)']
        ];

        $count = 0;
        foreach ($dia as $key => $value) {
            foreach ($value as $chave => $valor) {
                $data[$chave][$count] = $valor;
            }
            $count++;
        }

        $label_dia = [];
        foreach ($dia as $key => $value) {
            $count = 0;
            array_push($label_dia, DateTime::createFromFormat("Y-m-d", $key)->format("d/m"));
            foreach ($value as $chave => $valor) {
                if ($count == 0) {
                    $vendas_diario[$count]['type'] = 'line';
                    $vendas_diario[$count]['borderColor'] = $supp['cores'][$count];
                    $vendas_diario[$count]['fill'] = false;
                } else {
                    $vendas_diario[$count]['type'] = 'bar';
                }
                $vendas_diario[$count]['label'] = $supp['label'][$count];
                $vendas_diario[$count]['borderWidth'] = 2;
                $vendas_diario[$count]['backgroundColor'] = $supp['cores'][$count];
                $vendas_diario[$count]['borderColor'] = $supp['borda'][$count];
                $vendas_diario[$count]['data'] = $data[$chave];

                $count++;
            }
        }

        $obj['data']['labels'] = $label_dia;
        $obj['data']['datasets'] = $vendas_diario;

        return $obj;
    }

    public function transacao()
    {
        $dados = $this->Relatorios_model->transacao();

        if(!$dados){
            $obj['transacao']['data']= false;
            $obj['circliful']= $this->circli(false);
        }

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'mes' && $valor) {
                    $arr[$value['mes']][$chave] = ($valor) ? $valor : 0;
                } else if ($chave != 'mes' && !isset($arr[$value['mes']][$chave])) {
                    $arr[$value['mes']][$chave] = 0;
                }
            }
        }

        $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        $cores = [
            1 => 'rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(153, 102, 255)',
            'rgb(201, 203, 207)', 'rgb(176,196,222)', 'rgb(220,20,60)', 'rgb(255,20,147)', 'rgb(255,140,0)', 'rgb(210,105,30)'
        ];

        $labels_meses = [];
        $colors_meses = [];
        foreach ($arr as $key => $value) {
            array_push($labels_meses, $meses[$key]);
            array_push($colors_meses, $cores[$key]);
        }

        $total_transacao['datasets']= [['data' => array_column($arr, 'total_transacao'), 'backgroundColor' => $colors_meses]];
        $total_transacao['labels'] = $labels_meses;

        $circli = $this->circli($arr);

        $obj['transacao']['data']= $total_transacao;
        $obj['circliful']= $circli;

        return $obj;
    }

    public function circli($arr)
    {
        if(!$arr){
            $circli['dinheiro']['porc']= 0;
            $circli['cartao']['porc']= 0;
            $circli['atacado']['porc']= 0;
            $circli['varejo']['porc']= 0;
        }

        $soma_total_transacao = array_sum(array_column($arr, 'total_transacao'));
        $soma_dinheiro = array_sum(array_column($arr, 'total_dinheiro'));
        $soma_cartao = array_sum(array_column($arr, 'total_cartao'));
        $soma_atacado = array_sum(array_column($arr, 'total_atacado'));
        $soma_varejo = array_sum(array_column($arr, 'total_varejo'));

        $porc_dinheiro = $soma_dinheiro / $soma_total_transacao * 100;
        $porc_cartao = $soma_cartao / $soma_total_transacao * 100;
        $porc_atacado = $soma_atacado / $soma_total_transacao * 100;
        $porc_varejo = $soma_varejo / $soma_total_transacao * 100;

        $circli['dinheiro']['porc'] = (strpos($porc_dinheiro, '.') === false) ? (int) $porc_dinheiro : (float) number_format($porc_dinheiro, 1, '.', '');
        $circli['dinheiro']['decimal'] = (is_int($circli['dinheiro']['porc'])) ? 0 : 1;
        $circli['cartao']['porc'] = (strpos($porc_cartao, '.') === false) ? (int) $porc_cartao : (float) number_format($porc_cartao, 1, '.', '');
        $circli['cartao']['decimal'] = (is_int($circli['cartao']['porc'])) ? 0 : 1;
        $circli['atacado']['porc'] = (strpos($porc_atacado, '.') === false) ? (int) $porc_atacado : (float) number_format($porc_atacado, 1, '.', '');
        $circli['atacado']['decimal'] = (is_int($circli['atacado']['porc'])) ? 0 : 1;
        $circli['varejo']['porc'] = (strpos($porc_varejo, '.') === false) ? (int) $porc_varejo : (float) number_format($porc_varejo, 1, '.', '');
        $circli['varejo']['decimal'] = (is_int($circli['varejo']['porc'])) ? 0 : 1;

        return $circli;
    }

    public function total_produtos()
    {
        $dados = $this->Relatorios_model->total_produtos();

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'mes' && $valor) {
                    $arr[$value['mes']][$chave] = ($valor) ? $valor : 0;
                } else if ($chave != 'mes' && !isset($arr[$value['mes']][$chave])) {
                    $arr[$value['mes']][$chave] = 0;
                }
            }
        }

        $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        $cores = [
            1 => 'rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(153, 102, 255)',
            'rgb(201, 203, 207)', 'rgb(176,196,222)', 'rgb(220,20,60)', 'rgb(255,20,147)', 'rgb(255,140,0)', 'rgb(210,105,30)'
        ];

        $labels_meses = [];
        $colors_meses = [];
        foreach ($arr as $key => $value) {
            array_push($labels_meses, $meses[$key]);
            array_push($colors_meses, $cores[$key]);
        }

        $total_produto['datasets']= [['data' => array_column($arr, 'quantidade'), 'backgroundColor' => $colors_meses]];
        $total_produto['labels'] = $labels_meses;

        $obj['data']= $total_produto;

        return $obj;
    }

    public function tabela_transacao()
    {
        $dados = $this->Relatorios_model->tabela_transacao();

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                $data[$key][$chave] = $valor;
            }
            $data[$key]['ver']= 'Ver';
        }

        return $data;
    }
}
