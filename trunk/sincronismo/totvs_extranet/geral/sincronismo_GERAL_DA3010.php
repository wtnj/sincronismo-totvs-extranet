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
	
	$sqlTotvsDA3010 = ociparse($totvsConexao,"SELECT DA3_FILIAL
											      , DA3_COD
											      , DA3_DESC
											      , DA3_PLACA
											      , DA3_MUNPLA
											      , DA3_ESTPLA
											      , DA3_CAPACN
											      , DA3_CAPACM
											      , DA3_VOLMAX
											      , DA3_ATIVO
											      , DA3_TIPVEI
											      , DA3_CODFOR
											      , DA3_LOJFOR
											      , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM DA3010  
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsDA3010);
	
	while($rowTotvsDA3010 = oci_fetch_array($sqlTotvsDA3010)){
	
	    $sqlFatVeiculo = mysql_query("SELECT null FROM tb_fat_veiculo WHERE CO_RECNO = '".$rowTotvsDA3010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatVeiculo) == 0){
			
			if(trim($rowTotvsDA3010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_fat_veiculo (CO_FILIAL
							     , CO_VEICULO
								 , TP_VEICULO
								 , FL_ATIVO
								 , NO_MODELO
								 , NU_PLACA
								 , NO_MUNICIPIO_PLACA
								 , SG_UF_PLACA
								 , VL_CAPACIDADE_NOMINAL
								 , VL_CAPACIDADE_MAXIMA
								 , VL_VOLUME_MAXIMO
								 , CO_FORNECEDOR
								 , CO_LOJA_FORNECEDOR
								 , CO_RECNO 
								 , FL_DELET)
							 VALUES('".trim($rowTotvsDA3010['DA3_FILIAL'])."' 
								 , '".trim($rowTotvsDA3010['DA3_COD'])."' 
								 , '".trim($rowTotvsDA3010['DA3_TIPVEI'])."' 
								 , '".trim($rowTotvsDA3010['DA3_ATIVO'])."'
								 , '".trim(addslashes($rowTotvsDA3010['DA3_DESC']))."' 
								 , '".trim(addslashes($rowTotvsDA3010['DA3_PLACA']))."' 
								 , '".trim(addslashes($rowTotvsDA3010['DA3_MUNPLA']))."' 
								 , '".trim(addslashes($rowTotvsDA3010['DA3_ESTPLA']))."' 
								 , '".trim($rowTotvsDA3010['DA3_CAPACN'])."' 
								 , '".trim($rowTotvsDA3010['DA3_CAPACM'])."' 
								 , '".trim($rowTotvsDA3010['DA3_VOLMAX'])."' 
								 , '".trim($rowTotvsDA3010['DA3_CODFOR'])."' 
								 , '".trim($rowTotvsDA3010['DA3_LOJFOR'])."' 
								 , '".$rowTotvsDA3010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				mysql_query("INSERT INTO tb_fat_veiculo (CO_FILIAL
							     , CO_VEICULO
								 , TP_VEICULO
								 , FL_ATIVO
								 , NO_MODELO
								 , NU_PLACA
								 , NO_MUNICIPIO_PLACA
								 , SG_UF_PLACA
								 , VL_CAPACIDADE_NOMINAL
								 , VL_CAPACIDADE_MAXIMA
								 , VL_VOLUME_MAXIMO
								 , CO_FORNECEDOR
								 , CO_LOJA_FORNECEDOR
								 , CO_RECNO)
							 VALUES('".trim($rowTotvsDA3010['DA3_FILIAL'])."' 
								 , '".trim($rowTotvsDA3010['DA3_COD'])."' 
								 , '".trim($rowTotvsDA3010['DA3_TIPVEI'])."' 
								 , '".trim($rowTotvsDA3010['DA3_ATIVO'])."'
								 , '".trim(addslashes($rowTotvsDA3010['DA3_DESC']))."' 
								 , '".trim(addslashes($rowTotvsDA3010['DA3_PLACA']))."' 
								 , '".trim(addslashes($rowTotvsDA3010['DA3_MUNPLA']))."' 
								 , '".trim(addslashes($rowTotvsDA3010['DA3_ESTPLA']))."' 
								 , '".trim($rowTotvsDA3010['DA3_CAPACN'])."' 
								 , '".trim($rowTotvsDA3010['DA3_CAPACM'])."' 
								 , '".trim($rowTotvsDA3010['DA3_VOLMAX'])."' 
								 , '".trim($rowTotvsDA3010['DA3_CODFOR'])."' 
								 , '".trim($rowTotvsDA3010['DA3_LOJFOR'])."' 
								 , '".$rowTotvsDA3010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsDA3010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_fat_veiculo SET
		                         CO_FILIAL               = '".trim($rowTotvsDA3010['DA3_FILIAL'])."' 
								 , CO_VEICULO            = '".trim($rowTotvsDA3010['DA3_COD'])."' 
								 , TP_VEICULO            = '".trim($rowTotvsDA3010['DA3_TIPVEI'])."' 
								 , FL_ATIVO              = '".trim($rowTotvsDA3010['DA3_ATIVO'])."'
								 , NO_MODELO             = '".trim(addslashes($rowTotvsDA3010['DA3_DESC']))."' 
								 , NU_PLACA              = '".trim(addslashes($rowTotvsDA3010['DA3_PLACA']))."' 
								 , NO_MUNICIPIO_PLACA    = '".trim(addslashes($rowTotvsDA3010['DA3_MUNPLA']))."' 
								 , SG_UF_PLACA           = '".trim(addslashes($rowTotvsDA3010['DA3_ESTPLA']))."' 
								 , VL_CAPACIDADE_NOMINAL = '".trim($rowTotvsDA3010['DA3_CAPACN'])."' 
								 , VL_CAPACIDADE_MAXIMA  = '".trim($rowTotvsDA3010['DA3_CAPACM'])."' 
								 , VL_VOLUME_MAXIMO      = '".trim($rowTotvsDA3010['DA3_VOLMAX'])."'
								 , CO_FORNECEDOR         = '".trim($rowTotvsDA3010['DA3_CODFOR'])."' 
								 , CO_LOJA_FORNECEDOR    = '".trim($rowTotvsDA3010['DA3_LOJFOR'])."' 
								 , FL_DELET              = '*'
							 WHERE CO_RECNO = '".$rowTotvsDA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_fat_veiculo SET
							     CO_FILIAL               = '".trim($rowTotvsDA3010['DA3_FILIAL'])."' 
							     , CO_VEICULO            = '".trim($rowTotvsDA3010['DA3_COD'])."' 
								 , TP_VEICULO            = '".trim($rowTotvsDA3010['DA3_TIPVEI'])."' 
								 , FL_ATIVO              = '".trim($rowTotvsDA3010['DA3_ATIVO'])."'
								 , NO_MODELO             = '".trim(addslashes($rowTotvsDA3010['DA3_DESC']))."' 
								 , NU_PLACA              = '".trim(addslashes($rowTotvsDA3010['DA3_PLACA']))."' 
								 , NO_MUNICIPIO_PLACA    = '".trim(addslashes($rowTotvsDA3010['DA3_MUNPLA']))."' 
								 , SG_UF_PLACA           = '".trim(addslashes($rowTotvsDA3010['DA3_ESTPLA']))."' 
								 , VL_CAPACIDADE_NOMINAL = '".trim($rowTotvsDA3010['DA3_CAPACN'])."' 
								 , VL_CAPACIDADE_MAXIMA  = '".trim($rowTotvsDA3010['DA3_CAPACM'])."' 
								 , VL_VOLUME_MAXIMO      = '".trim($rowTotvsDA3010['DA3_VOLMAX'])."'
								 , CO_FORNECEDOR         = '".trim($rowTotvsDA3010['DA3_CODFOR'])."' 
								 , CO_LOJA_FORNECEDOR    = '".trim($rowTotvsDA3010['DA3_LOJFOR'])."'
							 WHERE CO_RECNO = '".$rowTotvsDA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>