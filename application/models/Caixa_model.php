<?php

class Caixa_model extends CI_Model
{
    public function tabela_produtos($id_produto = null)
    {
        if ($id_produto) { 
            $this->db->select('*')->from('produtos')->where('id_produto', $id_produto)->order_by('id_produto', 'DESC');
        } else {
            $this->db->select('*')->from('produtos')->order_by('id_produto', 'DESC');
        }
        $query = $this->db->get();
        
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
