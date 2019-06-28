<?php

class Gerenciamento_model extends CI_Model
{
    public function tabela_retirados()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('movimentacao')->where('tipo', 'retirado')->order_by('id_movimentacao', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function salvar_valor_retirado($data)
    {
        $this->db->insert('movimentacao', $data);
    }

    public function editar_valor_retirado($data, $id)
    {
        $this->db->where('id_movimentacao', $id);
        $this->db->update('movimentacao', $data);
    }

    public function tabela_inseridos()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('movimentacao')->where('tipo', 'inserido')->order_by('id_movimentacao', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function salvar_valor_inserido($data)
    {
        $this->db->insert('movimentacao', $data);
    }

    public function editar_valor_inserido($data, $id)
    {
        $this->db->where('id_movimentacao', $id);
        $this->db->update('movimentacao', $data);
    }
}
