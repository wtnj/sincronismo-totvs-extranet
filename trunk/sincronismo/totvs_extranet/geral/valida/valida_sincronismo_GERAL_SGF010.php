<?php 

	$sqlTotvsSGF010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SGF010 FROM SGF010");
	ociexecute($sqlTotvsSGF010);
	$rowTotvsSGF010        = oci_fetch_array($sqlTotvsSGF010);
	$quantidadeTotvsSGF010 = $rowTotvsSGF010['QTD_SGF010'];
	
	$sqlMySQLPcpOperacaoComponente        = mysql_query("SELECT COUNT(*) AS QTD_PCP_OPERACAO_COMPONENTE FROM tb_pcp_operacao_componente",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpOperacaoComponente        = mysql_fetch_array($sqlMySQLPcpOperacaoComponente);
	$quantidadeMySQLPcpOperacaoComponente = $rowMySQLPcpOperacaoComponente['QTD_PCP_OPERACAO_COMPONENTE'];
	
	if($quantidadeTotvsSGF010 != $quantidadeMySQLPcpOperacaoComponente){
		$quantidadeDiferenca = $quantidadeTotvsSGF010 - $quantidadeMySQLPcpOperacaoComponente;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpOperacaoComponente", $quantidadeTotvsSGF010, $quantidadeMySQLPcpOperacaoComponente, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Operacao Componente Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Operacao Componente Concluido sem Divergencia.<br>";
	}
			
?>