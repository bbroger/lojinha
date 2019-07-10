<?php

class Relatorios_model extends CI_Model
{
    public function vendas_mensal()
    {
        $ano= date('Y');
        $sql = "SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            SUM(valor_total) - SUM(desconto) AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            SUM(valor_total) - SUM(desconto) AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'atacado' AND YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            SUM(valor_total) - SUM(desconto) AS valor_varejo,
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'varejo' AND YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            SUM(desconto) AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            SUM(valor) AS valor_retirado, 
            NULL AS valor_inserido 
            FROM movimentacao WHERE tipo= 'retirado' AND YEAR(timestamp) = $ano GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            SUM(valor) AS valor_inserido 
            FROM movimentacao WHERE tipo= 'inserido' AND YEAR(timestamp) = $ano GROUP BY mes";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function transacao()
    {
        $ano= date('Y');
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
}
