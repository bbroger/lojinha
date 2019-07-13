<?php

class Relatorios_model extends CI_Model
{
    public function vendas($var)
    {
        $ano = date('Y');
        $sql = "SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            SUM(valor_pago) AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
        SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            SUM(valor_total) AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'atacado' AND YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            SUM(valor_total) AS valor_varejo,
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'varejo' AND YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            SUM(desconto) AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            SUM(valor) AS valor_retirado, 
            NULL AS valor_inserido 
            FROM movimentacao WHERE tipo= 'retirado' AND YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            SUM(valor) AS valor_inserido 
            FROM movimentacao WHERE tipo= 'inserido' AND YEAR(timestamp) = $ano GROUP BY chave";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function transacao()
    {
        $ano = date('Y');
        $sql = "SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            COUNT(id_transacao) AS total_transacao, 
            NULL AS total_atacado, 
            NULL AS total_varejo, 
            NULL AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            COUNT(id_transacao) AS total_atacado, 
            NULL AS total_varejo, 
            NULL AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE venda= 'atacado' AND YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            NULL AS total_atacado, 
            COUNT(id_transacao) AS total_varejo, 
            NULL AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE venda= 'varejo' AND YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            NULL AS total_atacado, 
            NULL AS total_varejo, 
            COUNT(id_transacao) AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE tipo_pagamento= 'dinheiro' AND YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            NULL AS total_atacado, 
            NULL AS total_varejo, 
            NULL AS total_dinheiro, 
            COUNT(id_transacao) AS total_cartao 
            FROM transacao WHERE tipo_pagamento= 'cartao' AND YEAR(timestamp) = $ano GROUP BY mes";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function total_produtos()
    {
        $ano = date('Y');
        $sql = "SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            SUM(quantidade) AS quantidade 
            FROM vendas WHERE YEAR(timestamp)= $ano GROUP BY mes";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tabela_transacao()
    {
        $ano = date('Y');
        $sql = "SELECT transacao.*, CONCAT('R$ ',transacao.valor_total) AS valor_total, DATE_FORMAT(transacao.timestamp, 'S%V %d/%m %H:%i') AS data_venda, COUNT(vendas.id_vendas) AS itens FROM transacao 
        INNER JOIN vendas ON transacao.id_transacao = vendas.id_transacao 
        WHERE YEAR(transacao.timestamp)= $ano GROUP BY id_transacao ORDER BY id_transacao DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
