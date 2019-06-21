<?php

class Produtos_model extends CI_Model
{
    /*
    $query = $this->db->get_where('audio', ['id_company' => $id_company, 'status' => 'active']);

        return $query->result_array();

    $this->db->select('list.*, campaing.name AS cname')
            ->from('list')
            ->join('campaing', 'campaing.id_list LIKE concat("%",list.id_list,"%")', 'left')
            ->order_by('list.id_list', 'ASC');
        $query = $this->db->get();

        return $query->result_array();

    $data = ['id_company' => $id_company, 'name' => $name];

        $this->db->insert('list', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    
    $data[coluna do banco]= valor;
        $this->db->insert_batch('list_value', $data);
    */

    public function tabela_produtos()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('produtos')->order_by('id_produto', 'DESC');

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

        if($this->db->affected_rows() > 0)
        {
            return true;
        } else
        {
            return false;
        }
    }
}