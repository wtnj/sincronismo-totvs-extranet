<?php 

	$sqlTotvsDAK010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_DAK010 FROM DAK010");
	ociexecute($sqlTotvsDAK010);
	$rowTotvsDAK010        = oci_fetch_array($sqlTotvsDAK010);
	$quantidadeTotvsDAK010 = $rowTotvsDAK010['QTD_DAK010'];
	
	$sqlMySQLFatCarga        = mysql_query("SELECT COUNT(*) AS QTD_FAT_CARGA FROM tb_fat_carga",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatCarga        = mysql_fetch_array($sqlMySQLFatCarga);
	$quantidadeMySQLFatCarga = $rowMySQLFatCarga['QTD_FAT_CARGA'];
	
	if($quantidadeTotvsDAK010 != $quantidadeMySQLFatCarga){
		$quantidadeDiferenca = $quantidadeTotvsDAK010 - $quantidadeMySQLFatCarga;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatCarga", $quantidadeTotvsDAK010, $quantidadeMySQLFatCarga, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Carga Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Carga Concluido sem Divergencia.<br>";
	}
			
?>