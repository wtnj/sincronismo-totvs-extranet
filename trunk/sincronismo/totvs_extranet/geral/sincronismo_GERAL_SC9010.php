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
	$sqlTotvsSC9010 = ociparse($totvsConexao,"SELECT 
												 C9_PEDIDO 
												, C9_ITEM  
												, C9_CLIENTE 
												, C9_PRODUTO 
												, C9_QTDLIB 
												, C9_NFISCAL	
												, C9_SERIENF	
												, C9_DATALIB
												, C9_SEQUEN
												, C9_LOCAL	
												, C9_CARGA	
												, C9_SEQCAR	
												, C9_SEQENT	
												, R_E_C_N_O_
												, D_E_L_E_T_
											   FROM SC9010
										  WHERE D_E_L_E_T_ <> '*'
										  ORDER BY  R_E_C_N_O_");
	ociexecute($sqlTotvsSC9010);
	$contador = 0;
	while($rowTotvsSC9010 = oci_fetch_array($sqlTotvsSC9010)){

			$sql = "INSERT INTO tb_fat_pedidos_liberados (
						 NU_PEDIDO_VENDA 	
						, CO_ITEM_PEDIDO_VENDA 
						, CO_CLIENTE 
						, CO_PRODUTO 
						, QTD_LIBERADA 
						, NU_NOTA 
						, NU_SERIE 
						, DT_LIBERACAO 
						, NU_SEQUENCIA 
						, CO_ARMAZEM 
						, CO_CARGA 
						, NU_SEQ_CARGA 
						, NU_SEQ_ENTREGA  
						, CO_RECNO)
					 	 VALUES('".$rowTotvsSC9010['C9_PEDIDO']."'  
							, '".$rowTotvsSC9010['C9_ITEM']."'  
							, '".$rowTotvsSC9010['C9_CLIENTE']."'  
							, '".$rowTotvsSC9010['C9_PRODUTO']."'   
							, '".$rowTotvsSC9010['C9_QTDLIB']."'   
							, '".$rowTotvsSC9010['C9_NFISCAL']."'  
							, '".$rowTotvsSC9010['C9_SERIENF']."'  
							, '".$rowTotvsSC9010['C9_DATALIB']."'  
							, '".$rowTotvsSC9010['C9_SEQUEN']."'  
							, '".$rowTotvsSC9010['C9_LOCAL']."'   
							, '".$rowTotvsSC9010['C9_CARGA']."'  
							, '".$rowTotvsSC9010['C9_SEQCAR']."'   
							, '".$rowTotvsSC9010['C9_SEQENT']."'  
							, '".$rowTotvsSC9010['R_E_C_N_O_']."')";

			mysql_query($sql,$conexaoExtranet);
			if($contador == 0){
			echo $sql;
			}
			$contador++;
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>