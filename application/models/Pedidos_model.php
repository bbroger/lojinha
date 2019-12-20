<?php

class Pedidos_model extends CI_Model
{
    public function busca_produto($id_produto)
    {
        $sql = "SELECT produtos.*, promocao.quantidade AS qtdPromo, promocao.valor AS valorPromo, 
                (produtos.quantidade - IF(SUM(produtos_pedido.quantidade) > 0, SUM(produtos_pedido.quantidade), 0)) AS nova_quantidade 
                FROM produtos LEFT JOIN promocao ON produtos.id_produto = promocao.id_produto AND produtos.status = promocao.status 
                LEFT JOIN produtos_pedido ON produtos.id_produto = produtos_pedido.id_produto AND produtos_pedido.status= 'ativo' 
                WHERE produtos.id_produto= $id_produto AND produtos.status = 'ativo' AND produtos.valor > 0 GROUP BY produtos.id_produto HAVING nova_quantidade > 0 ORDER BY qtdPromo ASC";

        $query = $this->db->query($sql);

        return (count($query->result_array()) > 0) ? $query->result_array() : false;
    }

    public function catalogo()
    {
        $sql = "SELECT produtos.*, CONCAT('R$ ',produtos.valor) AS valor, 
            (produtos.quantidade - IF(SUM(produtos_pedido.quantidade) > 0, SUM(produtos_pedido.quantidade), 0)) AS nova_quantidade 
            FROM produtos LEFT JOIN produtos_pedido ON produtos.id_produto = produtos_pedido.id_produto AND produtos_pedido.status= 'ativo' 
            WHERE produtos.status= 'ativo' GROUP BY produtos.id_produto HAVING nova_quantidade > 0 ORDER BY produtos.id_produto DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function salvar_pedido($data)
    {
        $this->db->insert('pedidos', $data);

        return $this->db->insert_id();
    }

    public function salvar_produtos_pedido($data)
    {
        $this->db->insert_batch('produtos_pedido', $data);
    }
}
