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
	
	$conexaoExtranet = mysql_connect("192.168.0.7","root","hp05br501ti504")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURAÇÃO DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Iniciado...<br>";

	/* Convert EUC-JP to UTF-7 */
	$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
	
	$sqlTotvsSC2010 = ociparse($totvsConexao,"SELECT C2_NUM
											      , C2_ITEM
											      , C2_SEQUEN
											      , C2_PRODUTO
											      , C2_QUANT
											      , C2_QUJE
											      , C2_EMISSAO
											      , C2_DATRF
											      , C2_LOTBRA
											      , R_E_C_N_O_
    											  , D_E_L_E_T_
											  FROM SC2010
											  WHERE C2_EMISSAO >= '20100101'");
	ociexecute($sqlTotvsSC2010);
	
	while($rowTotvsSC2010 = oci_fetch_array($sqlTotvsSC2010)){
	    
		$sqlPcpOrdemProducao = mysql_query("SELECT null FROM tb_pcp_op WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpOrdemProducao) == 0){
			
		    $qtdproduto = (string)($rowTotvsSC2010['C2_QUANT']);
			$qtdproduzida = (string)($rowTotvsSC2010['C2_QUJE']);
				
			if(substr($qtdproduto,0,1) == '.' || substr($qtdproduto,0,1) == ','){
				$qtdproduto = '0'.$qtdproduto;
			}
		
			if(substr($qtdproduzida,0,1) == '.' || substr($qtdproduzida,0,1) == ','){
				$qtdproduzida = '0'.$qtdproduzida;
			}	
			
			if(trim($rowTotvsSC2010['D_E_L_E_T_']) == '*'){
				
				 mysql_query("INSERT INTO tb_pcp_op (CO_NUM
								  , CO_ITEM
								  , CO_SEQUENCIA
								  , CO_PRODUTO
								  , QTD_PRODUTO
								  , QTD_PRODUZIDA
								  , DT_EMISSAO
								  , DT_FIM
								  , NU_LOTE
								  , CO_RECNO
								  , FL_DELET)
							  VALUES('".$rowTotvsSC2010['C2_NUM']."' 
								  , '".$rowTotvsSC2010['C2_ITEM']."'
								  , '".$rowTotvsSC2010['C2_SEQUEN']."'
								  , '".$rowTotvsSC2010['C2_PRODUTO']."'
								  , '".$qtdproduto."'  
								  , '".$qtdproduzida."'  
								  , '".$rowTotvsSC2010['C2_EMISSAO']."'  
								  , '".$rowTotvsSC2010['C2_DATRF']."'  
								  , '".$rowTotvsSC2010['C2_LOTBRA']."'  
								  , '".$rowTotvsSC2010['R_E_C_N_O_']."'
								  , '*')",$conexaoExtranet);
				
			}else{
				
				mysql_query("INSERT INTO tb_pcp_op (CO_NUM
								  , CO_ITEM
								  , CO_SEQUENCIA
								  , CO_PRODUTO
								  , QTD_PRODUTO
								  , QTD_PRODUZIDA
								  , DT_EMISSAO
								  , DT_FIM
								  , NU_LOTE
								  , CO_RECNO)
							  VALUES('".$rowTotvsSC2010['C2_NUM']."' 
								  , '".$rowTotvsSC2010['C2_ITEM']."'
								  , '".$rowTotvsSC2010['C2_SEQUEN']."'
								  , '".$rowTotvsSC2010['C2_PRODUTO']."'
								  , '".$qtdproduto."'  
								  , '".$qtdproduzida."'  
								  , '".$rowTotvsSC2010['C2_EMISSAO']."'  
								  , '".$rowTotvsSC2010['C2_DATRF']."'  
								  , '".$rowTotvsSC2010['C2_LOTBRA']."'  
								  , '".$rowTotvsSC2010['R_E_C_N_O_']."')",$conexaoExtranet);
				
			}
			
		}
				
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>