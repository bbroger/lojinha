<?php

class Relatorios_model extends CI_Model
{
    public function vendas($var, $tipo)
    {
        $where = "";
        if ($tipo == 'dinheiro') {
            $where = " AND tipo_pagamento='dinheiro'";
        } else if ($tipo == 'cartao') {
            $where = " AND tipo_pagamento='cartao'";
        }

        $ano = date('Y');
        $sql = "SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            SUM(valor_total) - SUM(desconto) AS valor_total, 
            NULL AS valor_atacado, 
            NULL AS valor_desconto_atacado,
            NULL AS valor_varejo, 
            NULL AS valor_desconto_varejo, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE YEAR(timestamp) = $ano $where GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            SUM(valor_total) AS valor_atacado, 
            NULL AS valor_desconto_atacado,
            NULL AS valor_varejo, 
            NULL AS valor_desconto_varejo, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'atacado' AND YEAR(timestamp) = $ano $where GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            SUM(desconto) AS valor_desconto_atacado, 
            NULL AS valor_varejo, 
            NULL AS valor_desconto_varejo, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'atacado' AND YEAR(timestamp) = $ano $where GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_desconto_atacado, 
            SUM(valor_total) AS valor_varejo,
            NULL AS valor_desconto_varejo, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'varejo' AND YEAR(timestamp) = $ano $where GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_desconto_atacado, 
            NULL AS valor_varejo, 
            SUM(desconto) AS valor_desconto_varejo, 
            NULL AS valor_retirado, 
            NULL AS valor_inserido 
            FROM transacao WHERE venda= 'varejo' AND YEAR(timestamp) = $ano $where GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_desconto_atacado,
            NULL AS valor_varejo, 
            NULL AS valor_desconto_varejo, 
            SUM(valor) AS valor_retirado, 
            NULL AS valor_inserido 
            FROM movimentacao WHERE tipo= 'retirado' AND YEAR(timestamp) = $ano GROUP BY chave 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '$var') AS chave, 
            NULL AS valor_pago, 
            NULL AS valor_atacado, 
            NULL AS valor_desconto_atacado,
            NULL AS valor_varejo, 
            NULL AS valor_desconto_varejo, 
            NULL AS valor_retirado, 
            SUM(valor) AS valor_inserido 
            FROM movimentacao WHERE tipo= 'inserido' AND YEAR(timestamp) = $ano GROUP BY chave";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function transacao($tipo)
    {
        $where = "";
        if ($tipo == 'dinheiro') {
            $where = " AND tipo_pagamento='dinheiro'";
        } else if ($tipo == 'cartao') {
            $where = " AND tipo_pagamento='cartao'";
        }

        $ano = date('Y');
        $sql = "SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            COUNT(id_transacao) AS total_transacao, 
            NULL AS total_atacado, 
            NULL AS total_varejo, 
            NULL AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE YEAR(timestamp) = $ano $where GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            COUNT(id_transacao) AS total_atacado, 
            NULL AS total_varejo, 
            NULL AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE venda= 'atacado' AND YEAR(timestamp) = $ano $where GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            NULL AS total_atacado, 
            COUNT(id_transacao) AS total_varejo, 
            NULL AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE venda= 'varejo' AND YEAR(timestamp) = $ano $where GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            NULL AS total_atacado, 
            NULL AS total_varejo, 
            COUNT(id_transacao) AS total_dinheiro, 
            NULL AS total_cartao 
            FROM transacao WHERE tipo_pagamento= 'dinheiro' AND YEAR(timestamp) = $ano $where GROUP BY mes 
            UNION ALL 
            SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            NULL AS total_transacao, 
            NULL AS total_atacado, 
            NULL AS total_varejo, 
            NULL AS total_dinheiro, 
            COUNT(id_transacao) AS total_cartao 
            FROM transacao WHERE tipo_pagamento= 'cartao' AND YEAR(timestamp) = $ano $where GROUP BY mes";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function total_produtos($tipo)
    {
        $ano = date('Y');
        if ($tipo == 'dinheiro') {
            $sql = "SELECT DATE_FORMAT(vendas.timestamp, '%c') AS mes, 
                SUM(vendas.quantidade) AS quantidade 
                FROM vendas 
                INNER JOIN transacao ON vendas.id_transacao = transacao.id_transacao 
                WHERE YEAR(vendas.timestamp)= $ano AND transacao.tipo_pagamento='dinheiro' GROUP BY mes";
        } else if ($tipo == 'cartao') {
            $sql = "SELECT DATE_FORMAT(vendas.timestamp, '%c') AS mes, 
                SUM(vendas.quantidade) AS quantidade 
                FROM vendas 
                INNER JOIN transacao ON vendas.id_transacao = transacao.id_transacao 
                WHERE YEAR(vendas.timestamp)= $ano AND transacao.tipo_pagamento='cartao' GROUP BY mes";
        } else {
            $sql = "SELECT DATE_FORMAT(timestamp, '%c') AS mes, 
            SUM(quantidade) AS quantidade 
            FROM vendas WHERE YEAR(timestamp)= $ano GROUP BY mes";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tabela_transacao_semanal($tipo)
    {
        $where = "";
        if ($tipo == 'dinheiro') {
            $where = " AND transacao.tipo_pagamento='dinheiro'";
        } else if ($tipo == 'cartao') {
            $where = " AND transacao.tipo_pagamento='cartao'";
        }

        $ano = date('Y');
        $sql = "SELECT DATE_FORMAT(transacao.timestamp, '%V') AS semana_venda, 
            CONCAT(DATE_FORMAT(transacao.timestamp, 'S%V - '),DATE_FORMAT(MIN(transacao.timestamp),'%d/%m até '),DATE_FORMAT(MAX(transacao.timestamp),'%d/%m')) AS string, 
            CONCAT('R$ ',SUM(transacao.valor_pago)) AS valor_pago, 
            CONCAT('R$ ',SUM(transacao.desconto)) AS desconto, 
            COUNT(transacao.id_transacao) AS vendas 
            FROM transacao 
            WHERE YEAR(transacao.timestamp)= $ano $where GROUP BY semana_venda ORDER BY semana_venda DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tabela_transacao_diario($tipo)
    {
        $where = "";
        if ($tipo == 'dinheiro') {
            $where = " AND transacao.tipo_pagamento='dinheiro'";
        } else if ($tipo == 'cartao') {
            $where = " AND transacao.tipo_pagamento='cartao'";
        }
        $ano = date('Y');

        $sql = "SELECT transacao.id_transacao, DATE_FORMAT(transacao.timestamp, '%d/%m') AS dia_venda, 
            CONCAT('R$ ',transacao.valor_pago) AS valor_pago, CONCAT('R$ ',transacao.desconto) AS desconto, COUNT(vendas.id_vendas) AS itens 
            FROM transacao 
            INNER JOIN vendas ON transacao.id_transacao = vendas.id_transacao 
            WHERE YEAR(transacao.timestamp)= $ano $where GROUP BY id_transacao ORDER BY id_transacao DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function consultar_transacao($id)
    {
        $sql = "SELECT transacao.*, transacao.timestamp AS data_venda, vendas.*, vendas.quantidade AS qtd_vendido, produtos.* FROM vendas 
            INNER JOIN transacao ON vendas.id_transacao = transacao.id_transacao 
            INNER JOIN produtos ON vendas.id_produto = produtos.id_produto 
            WHERE vendas.id_transacao= $id";

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
