<?php 

	$sqlTotvsDA4010        = ociparse($totvsConexao,"SELECT COUNT(*) AS QTD_DA4010 FROM DA4010");
	ociexecute($sqlTotvsDA4010);
	$rowTotvsDA4010        = oci_fetch_array($sqlTotvsDA4010);
	$quantidadeTotvsDA4010 = $rowTotvsDA4010['QTD_DA4010'];
	
	$sqlMySQLFatMotorista        = mysql_query("SELECT COUNT(*) AS QTD_FAT_MOTORISTA FROM tb_fat_motorista",$conexaoExtranet)or die(mysql_error());
	$rowMySQLFatMotorista        = mysql_fetch_array($sqlMySQLFatMotorista);
	$quantidadeMySQLFatMotorista = $rowMySQLFatMotorista['QTD_FAT_MOTORISTA'];
	
	if($quantidadeTotvsDA4010 != $quantidadeMySQLFatMotorista){
		$quantidadeDiferenca = $quantidadeTotvsDA4010 - $quantidadeMySQLFatMotorista;
	    enviaEmailNotificacao(date("d/m/Y h:i:s"), "FatMotorista", $quantidadeTotvsDA4010, $quantidadeMySQLFatMotorista, $quantidadeDiferenca);
		echo "Sincronismo Validação Tabela de Motorista Concluido e e-mail de Notificacao Enviado.<br>";
	}else{
	    echo "Sincronismo Validação Tabela de Motorista Concluido sem Divergencia.<br>";
	}
			
?>