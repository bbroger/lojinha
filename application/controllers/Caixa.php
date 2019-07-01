<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caixa extends CI_Controller
{
    public $produtos;

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->login){
            redirect(base_url("Login"));
        }
        $this->load->model('Caixa_model');
    }

    public function index()
    {
        $this->load->view('caixa');
    }

    public function tabela_produtos($id_produto)
    {
        $produtos = $this->Caixa_model->tabela_produtos($id_produto);
        
        echo json_encode($produtos);
    }

    public function catalogo()
    {
        $produtos = $this->Caixa_model->catalogo();

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

    public function finalizar_venda()
    {
        $this->form_validation->set_rules("valor_pago", "<b>Valor pago</b>", "trim|required|decimal|max_length[6]");
        $this->form_validation->set_rules("tipo_pag", "<b>Valor pago</b>", "trim|in_list[cartao,dinheiro]");
        $this->form_validation->set_rules("itens_produto", "<b>Produtos</b>", "callback_itens_produto_check");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        }

        $transacao['valor_pago'] = $this->input->post("valor_pago");
        $transacao['tipo_pagamento'] = $this->input->post("tipo_pag");
        $itens = $this->input->post("itens_produto");

        $transacao['valor_total']= 0;
        foreach ($itens as $key => $value) {
            $valor= ($value['valorPromo'] == 0) ? $value['valor'] : $value['valorPromo'];
            $transacao['valor_total']+= $value['quantidade'] * $valor;
        }

        $transacao['troco']= ($transacao['valor_pago'] - $transacao['valor_total'] > 0)? $transacao['valor_pago'] - $transacao['valor_total']:0 ;
        $transacao['desconto']= ($transacao['valor_pago'] - $transacao['valor_total'] < 0)? $transacao['valor_total'] - $transacao['valor_pago']:0 ;

        $id_transacao= $this->Caixa_model->inserir_transacao($transacao);

        foreach ($itens as $key => $value) {
            $salvar_produtos[$key]['id_transacao']= $id_transacao;
            $salvar_produtos[$key]['id_produto']= $value['id_produto'];
            $valor= ($value['valorPromo'] == 0) ? $value['valor'] : $value['valorPromo'];
            $salvar_produtos[$key]['valor']= $valor;
            $salvar_produtos[$key]['quantidade']= $value['quantidade'];
        }

        $this->Caixa_model->salvar_venda($salvar_produtos);

        $data['msg'] = "Venda finalizada com sucesso";
        $data['status'] = true;
        echo json_encode($data);

        return true;
    }

    public function itens_produto_check()
    {
        $itens = $this->input->post("itens_produto");

        if (!is_array($itens)) {
            $this->form_validation->set_message("itens_produto_check", "Produtos no formato inválido.");
            return false;
        }

        $produtos = $this->Caixa_model->catalogo();

        $coluna_id_produto = array_column($produtos, 'id_produto');
        foreach ($itens as $key => $value) {
            if (!in_array($value['id_produto'], $coluna_id_produto)) {
                $this->form_validation->set_message("itens_produto_check", "Uma ou mais <b>Produtos</b> não foram encontrados.");
                return false;
            }
        }

        return true;
    }

    public function ultimas_vendas()
    {
        $vendas= $this->Caixa_model->ultimas_vendas();

        $arr= [];
        foreach($vendas as $key=>$value){
            array_push($arr, $value['id_transacao']);
            if(count(array_unique($arr)) == 4){
                break;
            }
            foreach ($value as $chave => $valor) {
                $ultimas[$key][$chave]= $valor;
            }

        }

        echo json_encode($ultimas);
    }
}
