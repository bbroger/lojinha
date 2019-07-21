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

    public function monta_relatorio($tipo = null)
    {
        $data['mensal'] = $this->vendas($tipo, '%c');
        $data['semanal'] = $this->vendas($tipo, '%V');
        $data['diario'] = $this->vendas($tipo, '%Y-%m-%d');
        $pega = $this->transacao($tipo);
        $data['transacao'] = $pega['transacao'];
        $data['circliful'] = $pega['circliful'];
        $data['total_produtos'] = $this->total_produtos($tipo);
        $tabela_semanal = $this->tabela_transacao_semanal($tipo);
        $tabela_diario = $this->tabela_transacao_diario($tipo);

        echo json_encode(["relatorios" => $data, "tabela_semanal" => $tabela_semanal, "tabela_diario" => $tabela_diario]);
    }

    public function consultar_transacao($id = null)
    {
        $dados = $this->Relatorios_model->consultar_transacao($id);

        echo json_encode($dados);
    }

    public function vendas($tipo, $cal)
    {
        $dados = $this->Relatorios_model->vendas($cal, $tipo);

        if (!$dados) {
            return $obj['data'] = false;
        }

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                if ($chave != 'chave' && $valor) {
                    if ($chave == 'valor_desconto_atacado' || $chave == 'valor_desconto_varejo' || $chave == 'valor_retirado') {
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
            $arr[$key]['valor_total'] = $value['valor_total'] + ($value['valor_inserido'] - abs($value['valor_retirado']));
            $arr[$key]['valor_vendas'] = $value['valor_atacado'] + $value['valor_varejo'] - abs($value['valor_desconto_atacado']) - abs($value['valor_desconto_varejo']);
        }

        if ($cal != '%c') {
            krsort($arr);

            $arr = array_slice($arr, 0, 7, true);

            ksort($arr);
        }

        if ($tipo != 'vendas') {
            foreach ($arr as $key => $value) {
                unset($arr[$key]['valor_total']);
                unset($arr[$key]['valor_retirado']);
                unset($arr[$key]['valor_inserido']);
            }

            $supp = [
                "label" => [4 => "Total das vendas", 0 => "Atacado", 1 => "Desconto atacado", 2 => "Varejo", 3 => "Desconto varejo"],
                "cores" => ['rgba(0,128,0,0.6)', 'rgba(0,128,0,0.6)', 'rgba(100,206,188,0.6)', 'rgba(100,206,188,0.6)', 'rgb(188,143,143)'],
                "borda" => ['rgb(0,128,0)', 'rgb(0,128,0)', 'rgb(100,206,188)', 'rgb(100,206,188)', 'rgb(188,143,143)']
            ];
        } else {
            $supp = [
                "label" => [0 => "Lucro", 7 => "Total das vendas", 1 => "Atacado", 2 => "Desconto atacado", 3 => "Varejo", 4 => "Desconto varejo", 5 => "Retirado", 6 => "Inserido"],
                "cores" => ['rgb(0,0,255)', 'rgba(0,128,0,0.6)', 'rgba(0,128,0,0.6)', 'rgba(100,206,188,0.6)', 'rgba(100,206,188,0.6)', 'rgba(255,165,0,0.6)', 'rgba(70,130,180,0.6)', 'rgb(188,143,143)'],
                "borda" => ['rgb(0,0,255)', 'rgb(0,128,0)', 'rgb(0,128,0)', 'rgb(100,206,188)', 'rgb(100,206,188)', 'rgb(255,165,0)', 'rgb(70,130,180)', 'rgb(188,143,143)']
            ];
        }

        $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $count = 0;
        foreach ($arr as $key => $value) {
            foreach ($value as $chave => $valor) {
                $data[$chave][$count] = $valor;
            }
            $count++;
        }

        $label = [];
        foreach ($arr as $key => $value) {
            $count = 0;
            if ($cal == '%c') {
                array_push($label, $meses[$key]);
            } else if ($cal == '%V') {
                array_push($label, "S" . $key);
            } else {
                array_push($label, DateTime::createFromFormat("Y-m-d", $key)->format("d/m"));
            }
            foreach ($value as $chave => $valor) {
                if (($tipo == 'vendas' && ($count == 0 || $count == 7)) || ($tipo != 'vendas' && $count == 4)) {
                    $vendas[$count]['type'] = 'line';
                    $vendas[$count]['borderDash'] = [5, 5];
                    $vendas[$count]['borderColor'] = $supp['cores'][$count];
                    $vendas[$count]['fill'] = false;
                } else {
                    $vendas[$count]['type'] = 'bar';
                }
                $vendas[$count]['label'] = $supp['label'][$count];
                $vendas[$count]['borderWidth'] = 2;
                $vendas[$count]['backgroundColor'] = $supp['cores'][$count];
                $vendas[$count]['borderColor'] = $supp['borda'][$count];
                $vendas[$count]['data'] = $data[$chave];

                $count++;
            }
        }

        $obj['data']['labels'] = $label;
        $obj['data']['datasets'] = $vendas;

        return $obj;
    }

    public function transacao($tipo = null)
    {
        $dados = $this->Relatorios_model->transacao($tipo);

        if (!$dados) {
            $obj['transacao']['data'] = false;
            $obj['circliful'] = $this->circli(false);
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

        $total_transacao['datasets'] = [['data' => array_column($arr, 'total_transacao'), 'backgroundColor' => $colors_meses]];
        $total_transacao['labels'] = $labels_meses;

        $circli = $this->circli($arr);

        $obj['transacao']['data'] = $total_transacao;
        $obj['circliful'] = $circli;

        return $obj;
    }

    public function circli($arr)
    {
        if (!$arr) {
            $circli['dinheiro']['porc'] = 0;
            $circli['cartao']['porc'] = 0;
            $circli['atacado']['porc'] = 0;
            $circli['varejo']['porc'] = 0;
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

    public function total_produtos($tipo = null)
    {
        $dados = $this->Relatorios_model->total_produtos($tipo);

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

        $total_produto['datasets'] = [['data' => array_column($arr, 'quantidade'), 'backgroundColor' => $colors_meses]];
        $total_produto['labels'] = $labels_meses;

        $obj['data'] = $total_produto;

        return $obj;
    }

    public function tabela_transacao_semanal($tipo = null)
    {
        $dados = $this->Relatorios_model->tabela_transacao_semanal($tipo);

        if (!$dados) {
            return ['data' => false];
        }

        return $dados;
    }

    public function tabela_transacao_diario($tipo = null)
    {
        $dados = $this->Relatorios_model->tabela_transacao_diario($tipo);

        if (!$dados) {
            return ['data' => false];
        }

        foreach ($dados as $key => $value) {
            $dados[$key]['ver'] = '<button type="button" style="margin: 0; padding: 0 3px;" class="btn btn-link ver_detalhes" id="' . $value['id_transacao'] . '">Ver</button>';
        }

        return $dados;
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
