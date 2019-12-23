<?php

class Pendencias_model extends CI_Model
{
    public function pendencias()
    {
        $sql= "SELECT nome, valor_total AS valor, entrega AS vencimento, 'pedido' AS tipo FROM pedidos WHERE status= 'ativo'";
        $transacao= $this->db->query($sql);
        $sql= "SELECT *, 'pendencia' AS tipo FROM pendencias WHERE status= 'ativo'";
        $pendencia= $this->db->query($sql);

        return array_merge($transacao->result_array(), $pendencia->result_array());
    }

    public function salvar_pendencia($data)
    {
        $this->db->insert('pendencias', $data);
    }
}
