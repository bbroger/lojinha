<?php

class Caixa_model extends CI_Model
{
    public function busca_produto($id_produto)
    {
        $sql = "SELECT produtos.*, produtos.valorVarejo AS valor, promocao.quantidade AS qtdPromo, promocao.valor AS valorPromo 
                FROM produtos LEFT JOIN promocao ON produtos.id_produto = promocao.id_produto 
                WHERE produtos.id_produto= $id_produto AND produtos.status = 'ativo' AND produtos.valorVarejo > 0 ORDER BY qtdPromo ASC";
        $query = $this->db->query($sql);

        return (count($query->result_array()) > 0) ? $query->result_array() : false;
    }

    public function catalogo()
    {
        $this->db->select('*, CONCAT("R$",valorVarejo) AS valor')->from('produtos')->where(['status'=> 'ativo', 'valorVarejo >'=>'0'])->order_by('id_produto', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
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

    public function ultimas_vendas()
    {
        $sql = "SELECT vendas.*, produtos.nome, vendas.quantidade * vendas.valor AS valor_total FROM vendas INNER JOIN produtos ON vendas.id_produto = produtos.id_produto 
            ORDER BY vendas.id_vendas DESC LIMIT 20";

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
