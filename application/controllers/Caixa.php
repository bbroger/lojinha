<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caixa extends CI_Controller
{
    public $produtos;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Caixa_model');

        $this->produtos= $this->Caixa_model->tabela_produtos();
    }

    public function index()
    {
        $produtos = $this->Caixa_model->tabela_produtos();
        $this->load->view('caixa', ['produtos' => $produtos]);
    }

    public function tabela_produtos($id_produto = null)
    {
        $produtos = $this->Caixa_model->tabela_produtos($id_produto);

        echo json_encode($produtos);
    }

    public function finalizar_venda()
    {
        $this->form_validation->set_rules("valor_pago", "<b>Valor pago</b>", "trim|required|decimal|max_length[6]");
        $this->form_validation->set_rules("itens_produto", "<b>Produtos</b>", "callback_itens_produto_check");

        if (!$this->form_validation->run()) {
            $data['msg'] = validation_errors();
            $data['status'] = false;
            echo json_encode($data);

            return false;
        }

        $transacao['valor_pago'] = $this->input->post("valor_pago");
        $itens = $this->input->post("itens_produto");

        $transacao['valor_total']= 0;
        foreach ($itens as $key => $value) {
            $transacao['valor_total']+= $value['quantidade'] * $value['valor'];
        }

        $transacao['troco']= ($transacao['valor_pago'] - $transacao['valor_total'] > 0)? $transacao['valor_pago'] - $transacao['valor_total']:0 ;
        $transacao['desconto']= ($transacao['valor_pago'] - $transacao['valor_total'] < 0)? $transacao['valor_total'] - $transacao['valor_pago']:0 ;

        $id_transacao= $this->Caixa_model->inserir_transacao($transacao);

        foreach ($itens as $key => $value) {
            $salvar_produtos[$key]['id_transacao']= $id_transacao;
            $salvar_produtos[$key]['id_produto']= $value['id_produto'];
            $salvar_produtos[$key]['valor']= $value['valor'];
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

        $coluna_id_produto = array_column($this->produtos, 'id_produto');
        foreach ($itens as $key => $value) {
            if (!in_array($value['id_produto'], $coluna_id_produto)) {
                $this->form_validation->set_message("itens_produto_check", "Uma ou mais <b>Produtos</b> não foram encontrados.");
                return false;
            }
        }

        return true;
    }
}
