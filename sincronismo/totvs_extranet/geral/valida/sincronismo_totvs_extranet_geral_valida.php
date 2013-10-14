<?php 
	
	ini_set("max_execution_time",3600);
	ini_set("memory_limit","50M");
    set_time_limit(0);
	
	date_default_timezone_set('America/Sao_Paulo');
	
	/* Convert EUC-JP to UTF-7 */
	$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
	
    $ora_user = "TOPORA"; 
	$ora_senha = "hp05br501ti504"; 

	$ora_bd = "(DESCRIPTION=
			  (ADDRESS_LIST=
				(ADDRESS=(PROTOCOL=TCP) 
				  (HOST=192.168.0.7)(PORT=1521)
				)
			  )
			  (CONNECT_DATA=(SERVICE_NAME=TOPORA))
     )"; 

    $totvsConexao = OCILogon($ora_user,$ora_senha,$ora_bd);
	
	$conexaoExtranet = mysql_connect("192.168.0.7","root","hp05br501ti504")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURA��O DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Valida��o Geral Iniciado...<br>";
	
	function enviaEmailNotificacao($dataHoraValidacao, $tabelaValidacao, $quantidadeOracle, $quantidadeMySQL, $quantidadeDiferenca){
	    
		$ch      = curl_init();
		$timeout = 5;
				
		curl_setopt($ch, CURLOPT_URL, "http://www.bravomoveis.com/extranet/schedule/email_sincronismo_totvs_extranet_geral_valida.php");
		$data = array('dataHoraValidacao' => $dataHoraValidacao,'tabelaValidacao' => $tabelaValidacao, 'quantidadeOracle' => $quantidadeOracle, 'quantidadeMySQL' => $quantidadeMySQL, 'quantidadeDiferenca' => $quantidadeDiferenca);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_exec($ch);
		curl_close($ch);
		
	}
	
	//Tabela de Ordem de Producao	
	require("valida_sincronismo_GERAL_SC2010.php");
	
	//Tabela de Operacao
	require("valida_sincronismo_GERAL_SG2010.php");
			
	//Tabela de Recurso
	require("valida_sincronismo_GERAL_SH1010.php");
	
	//Tabela de Produto
	require("valida_sincronismo_GERAL_SB1010.php");
			
	//Tabela de Produto Saldo
	require("valida_sincronismo_GERAL_SB2010.php");		
			
	//Tabela de Cor
	require("valida_sincronismo_GERAL_SX5010.php");
			
	//Tabela de Produto Estrutura
	require("valida_sincronismo_GERAL_SG1010.php");
			
	//Tabela de Opera��o Componente
	require("valida_sincronismo_GERAL_SGF010.php");
			
	//Tabela de Ajuste de Empenho
	require("valida_sincronismo_GERAL_SD4010.php");
			
	//Tabela de Cliente
	require("valida_sincronismo_GERAL_SA1010.php");
			
	//Tabela de Fornecedor
	require("valida_sincronismo_GERAL_SA2010.php");
			
	//Tabela de Vendedor
	require("valida_sincronismo_GERAL_SA3010.php");
			
	//Tabela de Carga
	require("valida_sincronismo_GERAL_DAK010.php");
	
	//Tabela de Carga Itens
	require("valida_sincronismo_GERAL_DAI010.php");
	
	//Tabela de Veiculo
	require("valida_sincronismo_GERAL_DA3010.php");
			
	//Tabela de Motorista
	require("valida_sincronismo_GERAL_DA4010.php");
			
	//Tabela de Pedido de Venda
	require("valida_sincronismo_GERAL_SC5010.php");
			
	//Tabela de Pedido de Venda Itens
	require("valida_sincronismo_GERAL_SC6010.php");		
			
	//Tabela de Pedido de Venda Liberado
	require("valida_sincronismo_GERAL_SC9010.php");
				
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Valida��o Geral Finalizado...";
	
	oci_close($totvsConexao);
	
?>