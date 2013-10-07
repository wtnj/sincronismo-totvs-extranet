<?php 

    ini_set("max_execution_time",3600);
	ini_set("memory_limit","50M");
    set_time_limit(0);

    require("setup_totvs.php");
	require("setup_extranet.php");
	
	date_default_timezone_set('America/Sao_Paulo');
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Totvs com Extranet Iniciado.";
	require("totvs_extranet\sincronismo_totvs_extranet.php");
	echo "<br>[ ".date("d/m/Y h:i:s")." ] Sincronismo Totvs com Extranet Finalizado.";
	
	echo "<br><br>[ ".date("d/m/Y h:i:s")." ] Sincronismo Extranet com Totvs Iniciado.";
	require("extranet_totvs\sincronismo_extranet_totvs.php");
	echo "<br>[ ".date("d/m/Y h:i:s")." ] Sincronismo Extranet com Totvs Finalizado.";
	
	oci_close($totvsConexao);
	
?>