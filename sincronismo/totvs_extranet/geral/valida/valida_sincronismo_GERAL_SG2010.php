<?php 

	$sqlTotvsSG2010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SG2010 FROM SG2010");
	ociexecute($sqlTotvsSG2010);
	$rowTotvsSG2010        = oci_fetch_array($sqlTotvsSG2010);
	$quantidadeTotvsSG2010 = $rowTotvsSG2010['QTD_SG2010'];
	
	$sqlMySQLPcpOperacao        = mysql_query("SELECT COUNT(*) AS QTD_PCP_OPERACAO FROM tb_pcp_operacao",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpOperacao        = mysql_fetch_array($sqlMySQLPcpOperacao);
	$quantidadeMySQLPcpOperacao = $rowMySQLPcpOperacao['QTD_PCP_OPERACAO'];
	
	if($quantidadeTotvsSG2010 != $quantidadeMySQLPcpOperacao){
		$quantidadeDiferenca = $quantidadeTotvsSG2010 - $quantidadeMySQLPcpOperacao;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpOperacao", $quantidadeTotvsSG2010, $quantidadeMySQLPcpOperacao, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Operacao Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Operacao Concluido sem Divergencia.<br>";
	}
			
?>