<?php 

	$sqlTotvsSA1010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SA1010 FROM SA1010");
	ociexecute($sqlTotvsSA1010);
	$rowTotvsSA1010        = oci_fetch_array($sqlTotvsSA1010);
	$quantidadeTotvsSA1010 = $rowTotvsSA1010['QTD_SA1010'];
	
	$sqlMySQLFatCliente        = mysql_query("SELECT COUNT(*) AS QTD_FAT_CLIENTE FROM tb_fat_cliente",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatCliente        = mysql_fetch_array($sqlMySQLFatCliente);
	$quantidadeMySQLFatCliente = $rowMySQLFatCliente['QTD_FAT_CLIENTE'];
	
	if($quantidadeTotvsSA1010 != $quantidadeMySQLFatCliente){
		$quantidadeDiferenca = $quantidadeTotvsSA1010 - $quantidadeMySQLFatCliente;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatCliente", $quantidadeTotvsSA1010, $quantidadeMySQLFatCliente, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Cliente Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Cliente Concluido sem Divergencia.<br>";
	}
			
?>