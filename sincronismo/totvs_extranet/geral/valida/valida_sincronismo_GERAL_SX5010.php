<?php 

	$sqlTotvsSX5010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SX5010 FROM SX5010 WHERE X5_TABELA = 'CR'");
	ociexecute($sqlTotvsSX5010);
	$rowTotvsSX5010        = oci_fetch_array($sqlTotvsSX5010);
	$quantidadeTotvsSX5010 = $rowTotvsSX5010['QTD_SX5010'];
	
	$sqlMySQLPcpCor        = mysql_query("SELECT COUNT(*) AS QTD_PCP_COR FROM tb_pcp_cor",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpCor        = mysql_fetch_array($sqlMySQLPcpCor);
	$quantidadeMySQLPcpCor = $rowMySQLPcpCor['QTD_PCP_COR'];
	
	if($quantidadeTotvsSX5010 != $quantidadeMySQLPcpCor){
		$quantidadeDiferenca = $quantidadeTotvsSX5010 - $quantidadeMySQLPcpCor;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpCor", $quantidadeTotvsSX5010, $quantidadeMySQLPcpCor, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Cor Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Cor Concluido sem Divergencia.<br>";
	}
			
?>