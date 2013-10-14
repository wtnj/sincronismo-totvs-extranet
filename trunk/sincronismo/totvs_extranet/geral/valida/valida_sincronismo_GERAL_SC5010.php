<?php 

	$sqlTotvsSC5010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SC5010 FROM SC5010");
	ociexecute($sqlTotvsSC5010);
	$rowTotvsSC5010        = oci_fetch_array($sqlTotvsSC5010);
	$quantidadeTotvsSC5010 = $rowTotvsSC5010['QTD_SC5010'];
	
	$sqlMySQLFatPedidoVenda        = mysql_query("SELECT COUNT(*) AS QTD_FAT_PEDIDO_VENDA FROM tb_fat_pedido_venda",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatPedidoVenda        = mysql_fetch_array($sqlMySQLFatPedidoVenda);
	$quantidadeMySQLFatPedidoVenda = $rowMySQLFatPedidoVenda['QTD_FAT_PEDIDO_VENDA'];
	
	if($quantidadeTotvsSC5010 != $quantidadeMySQLFatPedidoVenda){
		$quantidadeDiferenca = $quantidadeTotvsSC5010 - $quantidadeMySQLFatPedidoVenda;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatPedidoVenda", $quantidadeTotvsSC5010, $quantidadeMySQLFatPedidoVenda, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Pedido Venda Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Pedido Venda Concluido sem Divergencia.<br>";
	}
			
?>