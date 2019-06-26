<?php

class Gerenciamento_model extends CI_Model
{
    public function tabela_retirados()
    {
        $this->db->select('*, CONCAT("R$ ",valor) AS valor')->from('movimentacao')->where('tipo', 'retirado')->order_by('id_movimentacao', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

}
