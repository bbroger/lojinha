<?php

class Produtos_model extends CI_Model
{
    public function tabela_produtos()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('produtos')->order_by('id_produto', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tabela_promocao()
    {
        $sql="SELECT promocao.*, produtos.nome AS nomeProduto, CONCAT('R$ ',promocao.valor) AS valor 
            FROM promocao INNER JOIN produtos ON promocao.id_produto = produtos.id_produto 
            ORDER BY promocao.id_promocao DESC";
        $query= $this->db->query($sql);
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
