<?php 

	$sqlTotvsSH1010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SH1010 FROM SH1010");
	ociexecute($sqlTotvsSH1010);
	$rowTotvsSH1010        = oci_fetch_array($sqlTotvsSH1010);
	$quantidadeTotvsSH1010 = $rowTotvsSH1010['QTD_SH1010'];
	
	$sqlMySQLPcpRecurso        = mysql_query("SELECT COUNT(*) AS QTD_PCP_RECURSO FROM tb_pcp_recurso",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpRecurso        = mysql_fetch_array($sqlMySQLPcpRecurso);
	$quantidadeMySQLPcpRecurso = $rowMySQLPcpRecurso['QTD_PCP_RECURSO'];
	
	if($quantidadeTotvsSH1010 != $quantidadeMySQLPcpRecurso){
		$quantidadeDiferenca = $quantidadeTotvsSH1010 - $quantidadeMySQLPcpRecurso;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpRecurso", $quantidadeTotvsSH1010, $quantidadeMySQLPcpRecurso, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Recurso Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Recurso Concluido sem Divergencia.<br>";
	}
			
?>