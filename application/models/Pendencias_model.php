<?php

class Pendencias_model extends CI_Model
{
    public function pendencias()
    {
        $sql= "SELECT id_pedido AS id, nome, valor_total AS valor, entrega AS vencimento, 
            endereco AS ende, obs, 'pedido' AS tipo FROM pedidos WHERE status= 'ativo'";
        $transacao= $this->db->query($sql);
        $sql= "SELECT *, NULL AS ende, NULL AS obs, id_pendencia AS id, 'lembrete' AS tipo FROM pendencias WHERE status= 'ativo'";
        $pendencia= $this->db->query($sql);

        return array_merge($transacao->result_array(), $pendencia->result_array());
    }

    public function historico()
    {
        $sql= "SELECT id_pedido AS id, nome, valor_total AS valor, entrega AS vencimento, 
            endereco AS ende, obs, 'pedido' AS tipo FROM pedidos WHERE status= 'feito'";
        $transacao= $this->db->query($sql);
        $sql= "SELECT *, NULL AS ende, NULL AS obs, id_pendencia AS id, 'lembrete' AS tipo FROM pendencias WHERE status= 'feito'";
        $pendencia= $this->db->query($sql);

        return array_merge($transacao->result_array(), $pendencia->result_array());
    }

    public function salvar_pendencia($data)
    {
        $this->db->insert('pendencias', $data);
    }

    public function tirar_pendencia($id, $tabela, $id_tabela)
    {
        $sql= "UPDATE $tabela SET status= 'feito' WHERE $id_tabela= $id";
        $this->db->query($sql);
    }
}
