<?php

class Caixa_model extends CI_Model
{
    public function tabela_produtos($id_produto = null)
    {
        if ($id_produto) { 
            $sql= "SELECT produtos.*, promocao.quantidade AS qtdPromo, promocao.valor AS valorPromo 
                FROM produtos LEFT JOIN promocao ON produtos.id_produto = promocao.id_produto WHERE produtos.id_produto= $id_produto ORDER BY qtdPromo ASC";
            $query= $this->db->query($sql);
        } else {
            $this->db->select('*')->from('produtos')->order_by('id_produto', 'DESC');
            $query = $this->db->get();
        }
        
        return (count($query->result_array()) > 0) ? $query->result_array() : false;
    }

    public function inserir_transacao($data)
    {
        $this->db->insert('transacao', $data);

        return  $this->db->insert_id();
    }

    public function salvar_venda($data)
    {
        $this->db->insert_batch('vendas', $data);
    }
}
