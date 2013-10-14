<?php 

	$sqlTotvsSC6010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SC6010 FROM SC6010");
	ociexecute($sqlTotvsSC6010);
	$rowTotvsSC6010        = oci_fetch_array($sqlTotvsSC6010);
	$quantidadeTotvsSC6010 = $rowTotvsSC6010['QTD_SC6010'];
	
	$sqlMySQLFatPedidoVendaItens        = mysql_query("SELECT COUNT(*) AS QTD_FAT_PEDIDO_VENDA_ITENS FROM tb_fat_pedido_venda_item",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatPedidoVendaItens        = mysql_fetch_array($sqlMySQLFatPedidoVendaItens);
	$quantidadeMySQLFatPedidoVendaItens = $rowMySQLFatPedidoVendaItens['QTD_FAT_PEDIDO_VENDA_ITENS'];
	
	if($quantidadeTotvsSC6010 != $quantidadeMySQLFatPedidoVendaItens){
		$quantidadeDiferenca = $quantidadeTotvsSC6010 - $quantidadeMySQLFatPedidoVendaItens;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatPedidoVendaItens", $quantidadeTotvsSC6010, $quantidadeMySQLFatPedidoVendaItens, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Pedido Venda Itens Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Pedido Venda Itens Concluido sem Divergencia.<br>";
	}
			
?>