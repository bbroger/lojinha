<?php

class Pendencias_model extends CI_Model
{
    public function pendencias()
    {
        $sql= "SELECT nome, valor, entrega, status, tipo_transacao AS tipo FROM transacao WHERE tipo_transacao= 'pedido' AND status= 'ativo'";
        $transacao= $this->db->query($sql);
        $sql= "SELECT nome, valor, vencimento, status, NULL AS pendencia FROM pendencia WHERE status= 'ativo'";
        $pendencia= $this->db->query($sql);

        return array_merge($transacao->result_array(), $pendencia->result_array());
    }
}
