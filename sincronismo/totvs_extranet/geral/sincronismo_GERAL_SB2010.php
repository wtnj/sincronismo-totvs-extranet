<?php 

    ini_set("max_execution_time",3600);
	ini_set("memory_limit","50M");
    set_time_limit(0);
	
	date_default_timezone_set('America/Sao_Paulo');

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
	
	$conexaoExtranet = mysql_connect("192.168.0.68","root","")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURAÇÃO DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Iniciado...<br>";

	/* Convert EUC-JP to UTF-7 */
	$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
	
	$sqlTotvsSB2010 = ociparse($totvsConexao,"SELECT B2_COD
	                                              , B2_QATU
												  , B2_QEMP
												  , B2_QFIM
												  , B2_RESERVA
												  , B2_QPEDVEN
												  , B2_LOCAL
												  , B2_USAI
												  , D_E_L_E_T_
												  , R_E_C_N_O_
										      FROM SB2010 
										      WHERE D_E_L_E_T_ <> '*' 
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSB2010);
	
	while($rowTotvsSB2010 = oci_fetch_array($sqlTotvsSB2010)){
		
	    $sqlPcpProdutoSaldo = mysql_query("SELECT null FROM tb_pcp_produto_saldo WHERE CO_RECNO = '".$rowTotvsSB2010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpProdutoSaldo) == 0){
		
			$qtdAtual = (string)($rowTotvsSB2010['B2_QATU']);
			if(substr($qtdAtual,0,1) == '.' || substr($qtdAtual,0,1) == ','){
				$qtdAtual = '0'.$qtdAtual;
			}
			
			$qtdEmpenho = (string)($rowTotvsSB2010['B2_QEMP']);
			if(substr($qtdEmpenho,0,1) == '.' || substr($qtdEmpenho,0,1) == ','){
				$qtdEmpenho = '0'.$qtdEmpenho;
			}
		
			$qtdMes = (string)($rowTotvsSB2010['B2_QFIM']);
			if(substr($qtdMes,0,1) == '.' || substr($qtdMes,0,1) == ','){
				$qtdMes = '0'.$qtdMes;
			}
			
			$qtdReservada = (string)($rowTotvsSB2010['B2_RESERVA']);
			if(substr($qtdReservada,0,1) == '.' || substr($qtdReservada,0,1) == ','){
				$qtdReservada = '0'.$qtdReservada;
			}
			
			$qtdPedidoVenda = (string)($rowTotvsSB2010['B2_QPEDVEN']);
			if(substr($qtdPedidoVenda,0,1) == '.' || substr($qtdPedidoVenda,0,1) == ','){
				$qtdPedidoVenda = '0'.$qtdPedidoVenda;
			}
					
			mysql_query("INSERT INTO tb_pcp_produto_saldo (CO_PRODUTO
						     , QTD_ATUAL
						     , QTD_EMPENHO
						     , QTD_SALDO_MES
						     , QTD_RESERVADA
						     , QTD_PEDIDO_VENDA
						     , NU_ARMAZEM
						     , DT_ULTIMA_SAIDA
						     , CO_RECNO)
					 	 VALUES('".$rowTotvsSB2010['B2_COD']."' 
					         , '".$qtdAtual."'
							 , '".$qtdEmpenho."'
							 , '".$qtdMes."'
							 , '".$qtdReservada."'
							 , '".$qtdPedidoVenda."'
							 , '".$rowTotvsSB2010['B2_LOCAL']."'
							 , '".$rowTotvsSB2010['B2_USAI']."'
							 , '".$rowTotvsSB2010['R_E_C_N_O_']."')",$conexaoExtranet);
			
		}
		
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>