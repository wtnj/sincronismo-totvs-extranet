<?php 

	$sqlTotvsSA3010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SA3010 FROM SA3010");
	ociexecute($sqlTotvsSA3010);
	$rowTotvsSA3010        = oci_fetch_array($sqlTotvsSA3010);
	$quantidadeTotvsSA3010 = $rowTotvsSA3010['QTD_SA3010'];
	
	$sqlMySQLFatVendedor        = mysql_query("SELECT COUNT(*) AS QTD_FAT_VENDEDOR FROM tb_fat_Vendedor",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatVendedor        = mysql_fetch_array($sqlMySQLFatVendedor);
	$quantidadeMySQLFatVendedor = $rowMySQLFatVendedor['QTD_FAT_VENDEDOR'];
	
	if($quantidadeTotvsSA3010 != $quantidadeMySQLFatVendedor){
		$quantidadeDiferenca = $quantidadeTotvsSA3010 - $quantidadeMySQLFatVendedor;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatVendedor", $quantidadeTotvsSA3010, $quantidadeMySQLFatVendedor, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Vendedor Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Vendedor Concluido sem Divergencia.<br>";
	}
			
?>