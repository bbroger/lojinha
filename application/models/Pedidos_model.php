<?php

class Pedidos_model extends CI_Model
{
    public function busca_produto($id_produto)
    {
        $sql = "SELECT produtos.*, promocao.quantidade AS qtdPromo, promocao.valor AS valorPromo 
                FROM produtos LEFT JOIN promocao ON produtos.id_produto = promocao.id_produto AND produtos.status = promocao.status 
                WHERE produtos.id_produto= $id_produto AND produtos.status = 'ativo' AND produtos.valor > 0 ORDER BY qtdPromo ASC";

        $query = $this->db->query($sql);

        return (count($query->result_array()) > 0) ? $query->result_array() : false;
    }

    public function catalogo()
    {
        $this->db->select("*, CONCAT('R$', valor) AS valor")->from('produtos')->where(['status' => 'ativo', "valor >" => '0'])->order_by('id_produto', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function inserir_transacao($data)
    {
        $this->db->insert('transacao', $data);

        return $this->db->insert_id();
    }

    public function salvar_venda($data)
    {
        $this->db->insert_batch('vendas', $data);
    }

    public function ultimas_vendas($tipo)
    {
        $sql = "SELECT vendas.*, vendas.quantidade AS quantidade_vendido, produtos.*, transacao.* FROM vendas 
            INNER JOIN transacao ON vendas.id_transacao = transacao.id_transacao 
            INNER JOIN produtos ON vendas.id_produto = produtos.id_produto 
            WHERE transacao.venda= '$tipo' ORDER BY transacao.id_transacao DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
