<?php 

	$sqlTotvsSC2010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SC2010 FROM SC2010");
	ociexecute($sqlTotvsSC2010);
	$rowTotvsSC2010        = oci_fetch_array($sqlTotvsSC2010);
	$quantidadeTotvsSC2010 = $rowTotvsSC2010['QTD_SC2010'];
	
	$sqlMySQLPcpOrdemProducao        = mysql_query("SELECT COUNT(*) AS QTD_PCP_OP FROM tb_pcp_op",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpOrdemProducao        = mysql_fetch_array($sqlMySQLPcpOrdemProducao);
	$quantidadeMySQLPcpOrdemProducao = $rowMySQLPcpOrdemProducao['QTD_PCP_OP'];
	
	if($quantidadeTotvsSC2010 != $quantidadeMySQLPcpOrdemProducao){
		$quantidadeDiferenca = $quantidadeTotvsSC2010 - $quantidadeMySQLPcpOrdemProducao;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpOrdemProducao", $quantidadeTotvsSC2010, $quantidadeMySQLPcpOrdemProducao, $quantidadeDiferenca);
		echo "<br>Sincronismo Validação Tabela de Ordem de Producao Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "<br>Sincronismo Validação Tabela de Ordem de Producao Concluido sem Divergencia.<br>";
	}
			
?>