<?php 

    ini_set("max_execution_time",3600);
	ini_set("memory_limit","50M");
    set_time_limit(0);

    require("setup_totvs.php");
	require("setup_extranet.php");
	
	date_default_timezone_set('America/Sao_Paulo');
	
	require("totvs_extranet\geral\\valida\sincronismo_totvs_extranet_geral_valida.php");
	
	require("totvs_extranet\geral\sincronismo_totvs_extranet_geral.php");
	
	oci_close($totvsConexao);
	
?>