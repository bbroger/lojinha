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
        $sql = "SELECT produtos.*, CONCAT('R$ ',produtos.valor) AS valor, 
            (produtos.quantidade - SUM(transacao.quantidade)) AS nova_quantidade 
            FROM produtos LEFT JOIN transacao ON produtos.id_produto = transacao.id_produto AND transacao.status= 'ativo' 
            WHERE produtos.status= 'ativo' 
            GROUP BY produtos.id_produto HAVING nova_quantidade > 0";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function inserir_transacao($data)
    {
        $this->db->insert('transacao', $data);

        return $this->db->insert_id();
    }

    public function salvar_transacao($data)
    {
        $this->db->insert_batch('transacao', $data);
    }
}
