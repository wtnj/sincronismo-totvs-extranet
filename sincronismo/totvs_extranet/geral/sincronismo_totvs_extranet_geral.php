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
				  (HOST=192.168.0.8)(PORT=1521)
				)
			  )
			  (CONNECT_DATA=(SERVICE_NAME=TOPORA))
     )"; 

    $totvsConexao = OCILogon($ora_user,$ora_senha,$ora_bd);
	
	$conexaoExtranet = mysql_connect("192.168.0.7","root","hp05br501ti504")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURAÇÃO DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Geral Iniciado...<br>";
	
	//Tabela de Ordem de Producao
	echo "Sincronismo Tabela de Ordem de Producao Concluido.<br>";
	require("sincronismo_GERAL_SC2010.php");
			
	//Tabela de Operacao
	echo "Sincronismo Tabela de Operacao Concluido.<br>";
	require("sincronismo_GERAL_SG2010.php");
			
	//Tabela de Recurso
	echo "Sincronismo Tabela de Recurso Concluido.<br>";
	require("sincronismo_GERAL_SH1010.php");
	
	//Tabela de Produto
	echo "Sincronismo Tabela de Produto Concluido.<br>";
	require("sincronismo_GERAL_SB1010.php");
			
	//Tabela de Produto Saldo
	echo "Sincronismo Tabela de Produto Saldo Concluido.<br>";
	require("sincronismo_GERAL_SB2010.php");		
			
	//Tabela de Cor
	echo "Sincronismo Tabela de Cor Concluido.<br>";
	require("sincronismo_GERAL_SX5010.php");
			
	//Tabela de Produto Estrutura
	echo "Sincronismo Tabela de Produto Estrutura Concluido.<br>";
	require("sincronismo_GERAL_SG1010.php");
			
	//Tabela de Operação Componente
	echo "Sincronismo Tabela de Operação Componente Concluido.<br>";
	require("sincronismo_GERAL_SGF010.php");
			
	//Tabela de Ajuste de Empenho
	echo "Sincronismo Tabela de Ajuste de Empenho Concluido.<br>";
	require("sincronismo_GERAL_SD4010.php");
			
	//Tabela de Cliente
	echo "Sincronismo Tabela de Cliente Concluido.<br>";
	require("sincronismo_GERAL_SA1010.php");
			
	//Tabela de Fornecedor
	echo "Sincronismo Tabela de Fornecedor Concluido.<br>";
	require("sincronismo_GERAL_SA2010.php");
			
	//Tabela de Vendedor
	echo "Sincronismo Tabela de Vendedor Concluido.<br>";
	require("sincronismo_GERAL_SA3010.php");
			
	//Tabela de Carga
	echo "Sincronismo Tabela de Carga Concluido.<br>";
	require("sincronismo_GERAL_DAK010.php");
	
	//Tabela de Carga Itens
	echo "Sincronismo Tabela de Carga Itens Concluido.<br>";
	require("sincronismo_GERAL_DAI010.php");
	
	//Tabela de Veiculo
	echo "Sincronismo Tabela de Veiculo Concluido.<br>";
	require("sincronismo_GERAL_DA3010.php");
			
	//Tabela de Motorista
	echo "Sincronismo Tabela de Motorista Concluido.<br>";
	require("sincronismo_GERAL_DA4010.php");
			
	//Tabela de Pedido de Venda
	echo "Sincronismo Tabela de Pedido de Venda Concluido.<br>";
	require("sincronismo_GERAL_SC5010.php");
			
	//Tabela de Pedido de Venda Itens
	echo "Sincronismo Tabela de Pedido de Venda Itens Concluido.<br>";
	require("sincronismo_GERAL_SC6010.php");		
			
	//Tabela de Pedido de Venda Liberado
	echo "Sincronismo Tabela de Pedido de Venda Liberado Concluido.<br>";
	require("sincronismo_GERAL_SC9010.php");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Geral Finalizado...";
	
	oci_close($totvsConexao);
	
?>