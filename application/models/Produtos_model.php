<?php

class Produtos_model extends CI_Model
{
    public function tabela_produtos()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('produtos')->where('status', 'ativo')->order_by('id_produto', 'DESC');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function tabela_promocao()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('promocao')->where('status', 'ativo')->order_by('id_promocao', 'DESC');

        $query = $this->db->get();

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

    public function salvar_promocao($data)
    {
        $this->db->insert('promocao', $data);
    }

    public function editar_promocao($data, $id)
    {
        $this->db->where('id_promocao', $id);
        $this->db->update('promocao', $data);
    }
}
