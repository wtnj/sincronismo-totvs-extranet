<?php 

	$sqlTotvsSD4010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SD4010 FROM SD4010");
	ociexecute($sqlTotvsSD4010);
	$rowTotvsSD4010        = oci_fetch_array($sqlTotvsSD4010);
	$quantidadeTotvsSD4010 = $rowTotvsSD4010['QTD_SD4010'];
	
	$sqlMySQLPcpAjusteEmpenho        = mysql_query("SELECT COUNT(*) AS QTD_PCP_AJUSTE_EMPENHO FROM tb_pcp_ajuste_empenho",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpAjusteEmpenho        = mysql_fetch_array($sqlMySQLPcpAjusteEmpenho);
	$quantidadeMySQLPcpAjusteEmpenho = $rowMySQLPcpAjusteEmpenho['QTD_PCP_AJUSTE_EMPENHO'];
	
	if($quantidadeTotvsSD4010 != $quantidadeMySQLPcpAjusteEmpenho){
		$quantidadeDiferenca = $quantidadeTotvsSD4010 - $quantidadeMySQLPcpAjusteEmpenho;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpAjusteEmpenho", $quantidadeTotvsSD4010, $quantidadeMySQLPcpAjusteEmpenho, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Ajuste de Empenho Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Ajuste de Empenho Concluido sem Divergencia.<br>";
	}
			
?>