﻿<?php 

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
	
	$sqlTotvsDAI010 = ociparse($totvsConexao,"SELECT DAI_FILIAL
											      , DAI_COD
											      , DAI_SEQCAR
											      , DAI_PEDIDO
											      , DAI_NFISCA
											      , DAI_SERIE
											      , DAI_DATA
											      , DAI_HORA
											      , DAI_DTCHEG
											      , DAI_CHEGAD
											      , DAI_DTSAID
											      , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM DAI010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsDAI010);
	
	while($rowTotvsDAI010 = oci_fetch_array($sqlTotvsDAI010)){
	
	    $sqlFatCargaItem = mysql_query("SELECT null FROM tb_fat_carga_item WHERE CO_RECNO = '".$rowTotvsDAI010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatCargaItem) == 0){
			
			if(trim($rowTotvsDAI010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_fat_carga_item (CO_FILIAL
							     , NU_CARGA
								 , NU_SEQ_CARGA
								 , NU_PEDIDO_VENDA
								 , NU_NOTA_FISCAL
								 , NU_SERIE_NOTA_FISCAL
								 , DT_CARGA
								 , HR_CARGA
								 , DT_CHEGADA_CARGA
								 , HR_CHEGADA_CARGA
								 , DT_SAIDA_CARGA
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".trim($rowTotvsDAI010['DAI_FILIAL'])."' 
							     , '".trim($rowTotvsDAI010['DAI_COD'])."' 
								 , '".trim($rowTotvsDAI010['DAI_SEQCAR'])."'
								 , '".trim($rowTotvsDAI010['DAI_PEDIDO'])."' 
								 , '".trim($rowTotvsDAI010['DAI_NFISCA'])."' 
								 , '".trim($rowTotvsDAI010['DAI_SERIE'])."' 
								 , '".trim($rowTotvsDAI010['DAI_DATA'])."' 
								 , '".trim($rowTotvsDAI010['DAI_HORA'])."' 
								 , '".trim($rowTotvsDAI010['DAI_DTCHEG'])."' 
								 , '".trim($rowTotvsDAI010['DAI_CHEGAD'])."' 
								 , '".trim($rowTotvsDAI010['DAI_DTSAID'])."' 
								 , '".$rowTotvsDAI010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
					
			}else{
				
				mysql_query("INSERT INTO tb_fat_carga_item (CO_FILIAL
							     , NU_CARGA
								 , NU_SEQ_CARGA
								 , NU_PEDIDO_VENDA
								 , NU_NOTA_FISCAL
								 , NU_SERIE_NOTA_FISCAL
								 , DT_CARGA
								 , HR_CARGA
								 , DT_CHEGADA_CARGA
								 , HR_CHEGADA_CARGA
								 , DT_SAIDA_CARGA
								 , CO_RECNO)
							 VALUES('".trim($rowTotvsDAI010['DAI_FILIAL'])."' 
							     , '".trim($rowTotvsDAI010['DAI_COD'])."' 
								 , '".trim($rowTotvsDAI010['DAI_SEQCAR'])."'
								 , '".trim($rowTotvsDAI010['DAI_PEDIDO'])."' 
								 , '".trim($rowTotvsDAI010['DAI_NFISCA'])."' 
								 , '".trim($rowTotvsDAI010['DAI_SERIE'])."' 
								 , '".trim($rowTotvsDAI010['DAI_DATA'])."' 
								 , '".trim($rowTotvsDAI010['DAI_HORA'])."' 
								 , '".trim($rowTotvsDAI010['DAI_DTCHEG'])."' 
								 , '".trim($rowTotvsDAI010['DAI_CHEGAD'])."' 
								 , '".trim($rowTotvsDAI010['DAI_DTSAID'])."' 
								 , '".$rowTotvsDAI010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
												 
			}
			
		}else{
			
			if(trim($rowTotvsSB1010['D_E_L_E_T_']) == '*'){
				
				mysql_query("UPDATE tb_fat_carga_item SET
		                         CO_FILIAL              = '".trim($rowTotvsDAI010['DAI_FILIAL'])."' 
							     , NU_CARGA             = '".trim($rowTotvsDAI010['DAI_COD'])."' 
								 , NU_SEQ_CARGA         = '".trim($rowTotvsDAI010['DAI_SEQCAR'])."' 
								 , NU_PEDIDO_VENDA      = '".trim($rowTotvsDAI010['DAI_PEDIDO'])."' 
								 , NU_NOTA_FISCAL       = '".trim($rowTotvsDAI010['DAI_NFISCA'])."' 
								 , NU_SERIE_NOTA_FISCAL = '".trim($rowTotvsDAI010['DAI_SERIE'])."' 
								 , DT_CARGA             = '".trim($rowTotvsDAI010['DAI_DATA'])."'
								 , HR_CARGA             = '".trim($rowTotvsDAI010['DAI_HORA'])."' 
								 , DT_CHEGADA_CARGA     = '".trim($rowTotvsDAI010['DAI_DTCHEG'])."' 
								 , HR_CHEGADA_CARGA     = '".trim($rowTotvsDAI010['DAI_CHEGAD'])."' 
								 , DT_SAIDA_CARGA       = '".trim($rowTotvsDAI010['DAI_DTSAID'])."' 
								 , FL_DELET             = '*'
							 WHERE CO_RECNO = '".$rowTotvsDAI010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
								
			}else{
				
				mysql_query("UPDATE tb_fat_carga_item SET
		                         CO_FILIAL              = '".trim($rowTotvsDAI010['DAI_FILIAL'])."' 
							     , NU_CARGA             = '".trim($rowTotvsDAI010['DAI_COD'])."' 
								 , NU_SEQ_CARGA         = '".trim($rowTotvsDAI010['DAI_SEQCAR'])."' 
								 , NU_PEDIDO_VENDA      = '".trim($rowTotvsDAI010['DAI_PEDIDO'])."' 
								 , NU_NOTA_FISCAL       = '".trim($rowTotvsDAI010['DAI_NFISCA'])."' 
								 , NU_SERIE_NOTA_FISCAL = '".trim($rowTotvsDAI010['DAI_SERIE'])."' 
								 , DT_CARGA             = '".trim($rowTotvsDAI010['DAI_DATA'])."'
								 , HR_CARGA             = '".trim($rowTotvsDAI010['DAI_HORA'])."' 
								 , DT_CHEGADA_CARGA     = '".trim($rowTotvsDAI010['DAI_DTCHEG'])."' 
								 , HR_CHEGADA_CARGA     = '".trim($rowTotvsDAI010['DAI_CHEGAD'])."' 
								 , DT_SAIDA_CARGA       = '".trim($rowTotvsDAI010['DAI_DTSAID'])."'
							 WHERE CO_RECNO = '".$rowTotvsDAI010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>