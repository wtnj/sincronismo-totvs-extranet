<?php 

	$sqlTotvsSB1010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SB1010 FROM SB1010");
	ociexecute($sqlTotvsSB1010);
	$rowTotvsSB1010        = oci_fetch_array($sqlTotvsSB1010);
	$quantidadeTotvsSB1010 = $rowTotvsSB1010['QTD_SB1010'];
	
	$sqlMySQLPcpProduto        = mysql_query("SELECT COUNT(*) AS QTD_PCP_PRODUTO FROM tb_pcp_produto",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpProduto        = mysql_fetch_array($sqlMySQLPcpProduto);
	$quantidadeMySQLPcpProduto = $rowMySQLPcpProduto['QTD_PCP_PRODUTO'];
	
	if($quantidadeTotvsSB1010 != $quantidadeMySQLPcpProduto){
		$quantidadeDiferenca = $quantidadeTotvsSB1010 - $quantidadeMySQLPcpProduto;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpProduto", $quantidadeTotvsSB1010, $quantidadeMySQLPcpProduto, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Produto Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Produto Concluido sem Divergencia.<br>";
	}
			
?>