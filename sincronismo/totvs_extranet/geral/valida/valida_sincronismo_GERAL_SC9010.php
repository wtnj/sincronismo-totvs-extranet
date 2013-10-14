<?php 

	$sqlTotvsSC9010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SC9010 FROM SC9010");
	ociexecute($sqlTotvsSC9010);
	$rowTotvsSC9010        = oci_fetch_array($sqlTotvsSC9010);
	$quantidadeTotvsSC9010 = $rowTotvsSC9010['QTD_SC9010'];
	
	$sqlMySQLFatPedidoVendaLiberado        = mysql_query("SELECT COUNT(*) AS QTD_FAT_PEDIDO_VENDA_LIBERADO FROM tb_fat_pedido_venda_liberado",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatPedidoVendaLiberado        = mysql_fetch_array($sqlMySQLFatPedidoVendaLiberado);
	$quantidadeMySQLFatPedidoVendaLiberado = $rowMySQLFatPedidoVendaLiberado['QTD_FAT_PEDIDO_VENDA_LIBERADO'];
	
	if($quantidadeTotvsSC9010 != $quantidadeMySQLFatPedidoVendaLiberado){
		$quantidadeDiferenca = $quantidadeTotvsSC9010 - $quantidadeMySQLFatPedidoVendaLiberado;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatPedidoVendaLiberado", $quantidadeTotvsSC9010, $quantidadeMySQLFatPedidoVendaLiberado, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Pedido Venda Liberado Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Pedido Venda Liberado Concluido sem Divergencia.<br>";
	}
			
?>