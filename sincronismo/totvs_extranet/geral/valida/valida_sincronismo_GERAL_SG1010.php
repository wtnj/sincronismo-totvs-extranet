<?php 

	$sqlTotvsSG1010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SG1010 FROM SG1010");
	ociexecute($sqlTotvsSG1010);
	$rowTotvsSG1010        = oci_fetch_array($sqlTotvsSG1010);
	$quantidadeTotvsSG1010 = $rowTotvsSG1010['QTD_SG1010'];
	
	$sqlMySQLPcpEstrutura        = mysql_query("SELECT COUNT(*) AS QTD_PCP_ESTRUTURA FROM tb_pcp_estrutura",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpEstrutura        = mysql_fetch_array($sqlMySQLPcpEstrutura);
	$quantidadeMySQLPcpEstrutura = $rowMySQLPcpEstrutura['QTD_PCP_ESTRUTURA'];
	
	if($quantidadeTotvsSG1010 != $quantidadeMySQLPcpEstrutura){
		$quantidadeDiferenca = $quantidadeTotvsSG1010 - $quantidadeMySQLPcpEstrutura;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpEstrutura", $quantidadeTotvsSG1010, $quantidadeMySQLPcpEstrutura, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Estrutura Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Estrutura Concluido sem Divergencia.<br>";
	}
			
?>