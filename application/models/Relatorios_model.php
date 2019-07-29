<?php

class Relatorios_model extends CI_Model
{
    public function consulta_diario($tipo, $forma){
        $ano= date('Y');
        $sql = "SELECT transacao.id_transacao, DATE_FORMAT(transacao.timestamp, '%d/%m') AS dia, 
            CONCAT('R$ ',SUM(transacao.valor_total)) AS valor_total, CONCAT('R$ ',SUM(transacao.desconto)) AS desconto, COUNT(vendas.id_vendas) AS itens 
            FROM transacao 
            INNER JOIN vendas ON transacao.id_transacao = vendas.id_transacao 
            WHERE YEAR(transacao.timestamp)= $ano AND transacao.tipo_pagamento= '$forma' AND transacao.venda= '$tipo' GROUP BY dia ORDER BY id_transacao DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function consulta_venda_diario($id_transacao)
    {
        $sql = "SELECT vendas.*, vendas.quantidade AS quantidade_vendido, produtos.*, transacao.* FROM vendas 
            INNER JOIN transacao ON vendas.id_transacao = transacao.id_transacao 
            INNER JOIN produtos ON vendas.id_produto = produtos.id_produto 
            WHERE transacao.id_transacao= $id_transacao";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
