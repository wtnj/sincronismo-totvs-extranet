<?php 

	$sqlTotvsSB2010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SB2010 FROM SB2010");
	ociexecute($sqlTotvsSB2010);
	$rowTotvsSB2010        = oci_fetch_array($sqlTotvsSB2010);
	$quantidadeTotvsSB2010 = $rowTotvsSB2010['QTD_SB2010'];
	
	$sqlMySQLPcpProdutoSaldo        = mysql_query("SELECT COUNT(*) AS QTD_PCP_PRODUTO_SALDO FROM tb_pcp_produto_saldo",$conexaoExtranet)or die(mysql_error());
	$rowMySQLPcpProdutoSaldo        = mysql_fetch_array($sqlMySQLPcpProdutoSaldo);
	$quantidadeMySQLPcpProdutoSaldo = $rowMySQLPcpProdutoSaldo['QTD_PCP_PRODUTO_SALDO'];
	
	if($quantidadeTotvsSB2010 != $quantidadeMySQLPcpProdutoSaldo){
		$quantidadeDiferenca = $quantidadeTotvsSB2010 - $quantidadeMySQLPcpProdutoSaldo;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "PcpProdutoSaldo", $quantidadeTotvsSB2010, $quantidadeMySQLPcpProdutoSaldo, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Produto Saldo Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Produto Saldo Concluido sem Divergencia.<br>";
	}
			
?>