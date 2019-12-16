<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pedidos extends CI_Controller
{
    public $produtos;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pedidos_model');
    }

    public function index()
    {
        $this->load->view('pedidos', ["venda" => "varejo"]);
    }

    public function atacado()
    {
        $this->load->view('pedidos', ["venda" => "atacado"]);
    }

    public function busca_produto($venda, $id_produto)
    {
        $produtos = $this->Pedidos_model->busca_produto($venda, $id_produto);

        echo json_encode($produtos);
    }

    public function catalogo($venda)
    {
        $produtos = $this->Pedidos_model->catalogo($venda);

        if ($produtos) {
            foreach ($produtos as $key => $value) {
                foreach ($value as $chave => $valor) {
                    $data['data'][$key][$chave] = $valor;
                }
            }

            echo json_encode($data);
        } else {
            echo json_encode(["data" => false]);
        }
    }

    public function finalizar_transacao()
    {
        $this->form_validation->set_rules("nome", "Nome", "trim|required||min_length[3]|max_length[100]");
        $this->form_validation->set_rules("endereco", "Endereço", "trim|min_length[3]|max_length[100]");
        $this->form_validation->set_rules("entrega", "Entrega", "trim|required|min_length[3]|max_length[100]");
        $this->form_validation->set_rules("obs", "Observação", "trim|required|min_length[3]|max_length[100]");
        $this->form_validation->set_rules("tipo_transacao", "Transação", "trim|required|in_list[venda,pedido]");
        $this->form_validation->set_rules("valor_pago", "Valor pago", "trim|decimal|min_length[3]");
        $this->form_validation->set_rules("tipo_pag", "Forma pagamento", "trim|in_list[cartao,dinheiro]");
        $this->form_validation->set_rules("itens_produto", "Produtos", "callback_itens_produto_check");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors(" ", " ");
            $data['status'] = false;
            echo json_encode($data);

            return false;
        }

        $transacao['nome']= $this->input->post("nome");
        $transacao['endereco']= $this->input->post("endereco");
        $transacao['entrega']= $this->input->post("entrega");
        $transacao['obs']= $this->input->post("obs");
        $transacao['tipo_transacao']= $this->input->post("tipo_transacao");
        $transacao['valor_pago'] = $this->input->post("valor_pago");
        $transacao['tipo_pagamento'] = $this->input->post("tipo_pag");
        $itens = $this->input->post("itens_produto");

        $transacao['valor_total'] = 0;
        foreach ($itens as $key => $value) {
            $valor = ($value['valorPromo'] == 0) ? $value['valor'] : $value['valorPromo'];
            $transacao['valor_total'] += $value['quantidade'] * $valor;
        }

        $transacao['troco'] = ($transacao['valor_pago'] - $transacao['valor_total'] > 0) ? $transacao['valor_pago'] - $transacao['valor_total'] : 0;
        $transacao['desconto'] = ($transacao['valor_pago'] - $transacao['valor_total'] < 0) ? $transacao['valor_total'] - $transacao['valor_pago'] : 0;
        $transacao['venda'] = $this->input->post("venda");

        $id_transacao = $this->Pedidos_model->inserir_transacao($transacao);

        foreach ($itens as $key => $value) {
            $salvar_produtos[$key]['id_transacao'] = $id_transacao;
            $salvar_produtos[$key]['id_produto'] = $value['id_produto'];
            $valor = ($value['valorPromo'] == 0) ? $value['valor'] : $value['valorPromo'];
            $salvar_produtos[$key]['valor'] = $valor;
            $salvar_produtos[$key]['quantidade'] = $value['quantidade'];
        }

        $this->Pedidos_model->salvar_venda($salvar_produtos);

        $data['msg'] = "Venda finalizada com sucesso";
        $data['status'] = true;
        echo json_encode($data);

        return true;
    }

    public function itens_produto_check()
    {
        $itens = $this->input->post("itens_produto");
        $venda = $this->input->post("venda");

        if (!is_array($itens)) {
            $this->form_validation->set_message("itens_produto_check", "Produtos no formato inválido.");
            return false;
        }

        $produtos = $this->Pedidos_model->catalogo($venda);

        $coluna_id_produto = array_column($produtos, 'id_produto');
        foreach ($itens as $key => $value) {
            if (!in_array($value['id_produto'], $coluna_id_produto)) {
                $this->form_validation->set_message("itens_produto_check", "Uma ou mais Produtos não foram encontrados.");
                return false;
            }
        }

        return true;
    }

    public function ultimas_vendas($tipo)
    {
        $dados = $this->Pedidos_model->ultimas_vendas($tipo);

        foreach ($dados as $key => $value) {
            foreach ($value as $chave => $valor) {
                $arr[$value['id_transacao']][$value['id_produto']][$chave] = $valor;
            }
        }

        $tr = null;
        $count= 0;
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
            $count++;
            if($count == 3){
                break;
            }
        }

        $data['status'] = true;
        $data['table'] = $tr;

        echo json_encode($data);
    }
}
