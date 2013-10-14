<?php 

	$sqlTotvsSA2010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_SA2010 FROM SA2010");
	ociexecute($sqlTotvsSA2010);
	$rowTotvsSA2010        = oci_fetch_array($sqlTotvsSA2010);
	$quantidadeTotvsSA2010 = $rowTotvsSA2010['QTD_SA2010'];
	
	$sqlMySQLFatFornecedor        = mysql_query("SELECT COUNT(*) AS QTD_FAT_FORNECEDOR FROM tb_fat_fornecedor",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatFornecedor        = mysql_fetch_array($sqlMySQLFatFornecedor);
	$quantidadeMySQLFatFornecedor = $rowMySQLFatFornecedor['QTD_FAT_FORNECEDOR'];
	
	if($quantidadeTotvsSA2010 != $quantidadeMySQLFatFornecedor){
		$quantidadeDiferenca = $quantidadeTotvsSA2010 - $quantidadeMySQLFatFornecedor;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatFornecedor", $quantidadeTotvsSA2010, $quantidadeMySQLFatFornecedor, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Fornecedor Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Fornecedor Concluido sem Divergencia.<br>";
	}
			
?>