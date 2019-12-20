<?php

class Produtos_model extends CI_Model
{
    public function tabela_produtos()
    {
        $sql = "SELECT produtos.*, CONCAT('R$ ',produtos.valor) AS valor, 
            (produtos.quantidade - SUM(produtos_pedido.quantidade)) AS nova_quantidade 
            FROM produtos LEFT JOIN produtos_pedido ON produtos.id_produto = produtos_pedido.id_produto AND produtos_pedido.status= 'ativo' GROUP BY produtos.id_produto";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tabela_promocao()
    {
        $sql = "SELECT promocao.*, produtos.nome AS nomeProduto, CONCAT('R$ ',promocao.valor) AS valor 
            FROM promocao INNER JOIN produtos ON promocao.id_produto = produtos.id_produto 
            ORDER BY promocao.id_promocao DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function salvar_produto($data)
    {
        $this->db->insert('produtos', $data);
    }

    public function editar_produto($data, $id)
    {
        $this->db->where('id_produto', $id);
        $this->db->update('produtos', $data);
    }

    public function desativar_produto($data, $id)
    {
        $this->db->where('id_produto', $id);
        $this->db->update('produtos', $data);
    }

    public function ativar_produto($data, $id)
    {
        $this->db->where('id_produto', $id);
        $this->db->update('produtos', $data);
    }

    public function acao_estoque($data, $acao, $id)
    {
        if ($acao == 'add') {
            $this->db->set('quantidade', 'quantidade+' . $data['quantidade'], FALSE);
        } else {
            $this->db->set('quantidade', 'quantidade-' . $data['quantidade'], FALSE);
        }
        $this->db->where('id_produto', $id);
        $this->db->update('produtos');
    }

    public function save_acao_estoque($data)
    {
        $this->db->insert('acao_estoque', $data);
    }

    public function salvar_promocao($data)
    {
        $this->db->insert('promocao', $data);
    }

    public function editar_promocao($data, $id)
    {
        $this->db->where('id_promocao', $id);
        $this->db->update('promocao', $data);
    }

    public function desativar_promocao($data, $id)
    {
        $this->db->where('id_promocao', $id);
        $this->db->update('promocao', $data);
    }

    public function ativar_promocao($data, $id)
    {
        $this->db->where('id_promocao', $id);
        $this->db->update('promocao', $data);
    }
}
