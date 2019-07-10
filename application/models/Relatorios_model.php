<?php

class Relatorios_model extends CI_Model
{
    public function vendas_mensal()
    {
        $sql = "SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            SUM(valor_total) - SUM(desconto) AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            SUM(valor_total) - SUM(desconto) AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'atacado' GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            SUM(valor_total) - SUM(desconto) AS valor_varejo,
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'varejo' GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            SUM(desconto) AS valor_desconto, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            SUM(valor) AS valor_retirado, 
            NULL AS valor_inserido 
            FROM movimentacao WHERE tipo= 'retirado' GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto, 
            NULL AS valor_retirado, 
            SUM(valor) AS valor_inserido 
            FROM movimentacao WHERE tipo= 'inserido' GROUP BY mes";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
