<?php 

	$sqlTotvsDAI010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_DAI010 FROM DAI010");
	ociexecute($sqlTotvsDAI010);
	$rowTotvsDAI010        = oci_fetch_array($sqlTotvsDAI010);
	$quantidadeTotvsDAI010 = $rowTotvsDAI010['QTD_DAI010'];
	
	$sqlMySQLFatCargaItens        = mysql_query("SELECT COUNT(*) AS QTD_FAT_CARGA_ITENS FROM tb_fat_carga_item",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatCargaItens        = mysql_fetch_array($sqlMySQLFatCargaItens);
	$quantidadeMySQLFatCargaItens = $rowMySQLFatCargaItens['QTD_FAT_CARGA_ITENS'];
	
	if($quantidadeTotvsDAI010 != $quantidadeMySQLFatCargaItens){
		$quantidadeDiferenca = $quantidadeTotvsDAI010 - $quantidadeMySQLFatCargaItens;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatCargaItens", $quantidadeTotvsDAI010, $quantidadeMySQLFatCargaItens, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Carga Itens Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Carga Itens Concluido sem Divergencia.<br>";
	}
			
?>