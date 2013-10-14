<?php 

	$sqlTotvsDA3010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_DA3010 FROM DA3010");
	ociexecute($sqlTotvsDA3010);
	$rowTotvsDA3010        = oci_fetch_array($sqlTotvsDA3010);
	$quantidadeTotvsDA3010 = $rowTotvsDA3010['QTD_DA3010'];
	
	$sqlMySQLFatVeiculo        = mysql_query("SELECT COUNT(*) AS QTD_FAT_VEICULO FROM tb_fat_veiculo",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatVeiculo        = mysql_fetch_array($sqlMySQLFatVeiculo);
	$quantidadeMySQLFatVeiculo = $rowMySQLFatVeiculo['QTD_FAT_VEICULO'];
	
	if($quantidadeTotvsDA3010 != $quantidadeMySQLFatVeiculo){
		$quantidadeDiferenca = $quantidadeTotvsDA3010 - $quantidadeMySQLFatVeiculo;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatVeiculo", $quantidadeTotvsDA3010, $quantidadeMySQLFatVeiculo, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Veiculo Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Veiculo Concluido sem Divergencia.<br>";
	}
			
?>