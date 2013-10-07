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
			 
    $sqlTotvsSB1010 = ociparse($totvsConexao,"SELECT B1_COD
											      , B1_CODINT
											      , B1_COR
											      , B1_DESC
											      , B1_TIPO
											      , B1_UM
											      , B1_LINHA
											      , B1_X
											      , B1_Y
										          , B1_Z
											      , B1_PESO
												  , B1_QTDDIV
												  , B1_QTDJUN
												  , B1_GRUPO
												  , B1_MSBLQL
											      , R_E_C_N_O_
    											  , D_E_L_E_T_
											  FROM SB1010
											  ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSB1010);
	
	while($rowTotvsSB1010 = oci_fetch_array($sqlTotvsSB1010)){
		
		$nu_comprimento = (string)($rowTotvsSB1010['B1_X']);
		$nu_largura     = (string)($rowTotvsSB1010['B1_Y']);
		$nu_espessura   = (string)($rowTotvsSB1010['B1_Z']);
		$nu_peso        = (string)($rowTotvsSB1010['B1_PESO']);
	
		if(substr($nu_comprimento,0,1) == '.' || substr($nu_comprimento,0,1) == ','){
			$nu_comprimento = '0'.$nu_comprimento;
		}	
			
		if(substr($nu_largura,0,1) == '.' || substr($nu_largura,0,1) == ','){
			$nu_largura = '0'.$nu_largura;
		}	
			
		if(substr($nu_espessura,0,1) == '.' || substr($nu_espessura,0,1) == ','){
			$nu_espessura = '0'.$nu_espessura;
		}				
	
		if(substr($nu_peso,0,1) == '.' || substr($nu_peso,0,1) == ','){
			$nu_peso = '0'.$nu_peso;
		}
	
	    $sqlPcpProduto = mysql_query("SELECT null FROM tb_pcp_produto WHERE CO_RECNO = '".$rowTotvsSB1010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpProduto) == 0){
			
			if(trim($rowTotvsSB1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_pcp_produto (CO_PRODUTO
							     , CO_INT_PRODUTO
								 , CO_COR
								 , DS_PRODUTO
								 , TP_PRODUTO
								 , TP_UNIDADE
								 , CO_LINHA
								 , NU_COMPRIMENTO
								 , NU_LARGURA
								 , NU_ESPESSURA
								 , NU_PESO
								 , QTD_DIVISAO
								 , QTD_JUNCAO
								 , CO_GRUPO
								 , FL_BLOQUEIO
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".trim($rowTotvsSB1010['B1_COD'])."'
								 , '".trim($rowTotvsSB1010['B1_CODINT'])."'
								 , '".trim($rowTotvsSB1010['B1_COR'])."'
								 , '".trim(addslashes($rowTotvsSB1010['B1_DESC']))."'
								 , '".trim($rowTotvsSB1010['B1_TIPO'])."'
								 , '".trim($rowTotvsSB1010['B1_UM'])."'
								 , '".trim($rowTotvsSB1010['B1_LINHA'])."'
								 , '".$nu_comprimento."'
								 , '".$nu_largura."'
								 , '".$nu_espessura."'
								 , '".$nu_peso."'
								 , '".$rowTotvsSB1010['B1_QTDDIV']."'
								 , '".$rowTotvsSB1010['B1_QTDJUN']."'
								 , '".$rowTotvsSB1010['B1_GRUPO']."'
								 , '".$rowTotvsSB1010['B1_MSBLQL']."'
								 , '".$rowTotvsSB1010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				mysql_query("INSERT INTO tb_pcp_produto (CO_PRODUTO
							     , CO_INT_PRODUTO
								 , CO_COR
								 , DS_PRODUTO
								 , TP_PRODUTO
								 , TP_UNIDADE
								 , CO_LINHA
								 , NU_COMPRIMENTO
								 , NU_LARGURA
								 , NU_ESPESSURA
								 , NU_PESO
								 , QTD_DIVISAO
								 , QTD_JUNCAO
								 , CO_GRUPO
								 , FL_BLOQUEIO
								 , CO_RECNO)
							 VALUES('".trim($rowTotvsSB1010['B1_COD'])."'
								 , '".trim($rowTotvsSB1010['B1_CODINT'])."'
								 , '".trim($rowTotvsSB1010['B1_COR'])."'
								 , '".trim(addslashes($rowTotvsSB1010['B1_DESC']))."'
								 , '".trim($rowTotvsSB1010['B1_TIPO'])."'
								 , '".trim($rowTotvsSB1010['B1_UM'])."'
								 , '".trim($rowTotvsSB1010['B1_LINHA'])."'
								 , '".$nu_comprimento."'
								 , '".$nu_largura."'
								 , '".$nu_espessura."'
								 , '".$nu_peso."'
								 , '".$rowTotvsSB1010['B1_QTDDIV']."'
								 , '".$rowTotvsSB1010['B1_QTDJUN']."'
								 , '".$rowTotvsSB1010['B1_GRUPO']."'
								 , '".$rowTotvsSB1010['B1_MSBLQL']."'
								 , '".$rowTotvsSB1010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSB1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_produto SET
							     CO_PRODUTO       = '".trim($rowTotvsSB1010['B1_COD'])."'
							     , CO_INT_PRODUTO = '".trim($rowTotvsSB1010['B1_CODINT'])."'
								 , CO_COR         = '".trim($rowTotvsSB1010['B1_COR'])."'
								 , DS_PRODUTO     = '".trim(addslashes($rowTotvsSB1010['B1_DESC']))."'
								 , TP_PRODUTO     = '".trim($rowTotvsSB1010['B1_TIPO'])."'
								 , TP_UNIDADE     = '".trim($rowTotvsSB1010['B1_UM'])."'
								 , CO_LINHA       = '".trim($rowTotvsSB1010['B1_LINHA'])."'
								 , NU_COMPRIMENTO = '".$nu_comprimento."'
								 , NU_LARGURA     = '".$nu_largura."'
								 , NU_ESPESSURA   = '".$nu_espessura."'
								 , NU_PESO        = '".$nu_peso."'
								 , QTD_DIVISAO    = '".$rowTotvsSB1010['B1_QTDDIV']."'
								 , QTD_JUNCAO     = '".$rowTotvsSB1010['B1_QTDJUN']."'
								 , CO_GRUPO       = '".$rowTotvsSB1010['B1_GRUPO']."'
								 , FL_BLOQUEIO    = '".$rowTotvsSB1010['B1_MSBLQL']."'
							     , FL_DELET       = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSB1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_produto SET
							     CO_PRODUTO       = '".trim($rowTotvsSB1010['B1_COD'])."'
							     , CO_INT_PRODUTO = '".trim($rowTotvsSB1010['B1_CODINT'])."'
								 , CO_COR         = '".trim($rowTotvsSB1010['B1_COR'])."'
								 , DS_PRODUTO     = '".trim(addslashes($rowTotvsSB1010['B1_DESC']))."'
								 , TP_PRODUTO     = '".trim($rowTotvsSB1010['B1_TIPO'])."'
								 , TP_UNIDADE     = '".trim($rowTotvsSB1010['B1_UM'])."'
								 , CO_LINHA       = '".trim($rowTotvsSB1010['B1_LINHA'])."'
								 , NU_COMPRIMENTO = '".$nu_comprimento."'
								 , NU_LARGURA     = '".$nu_largura."'
								 , NU_ESPESSURA   = '".$nu_espessura."'
								 , NU_PESO        = '".$nu_peso."'
								 , QTD_DIVISAO    = '".$rowTotvsSB1010['B1_QTDDIV']."'
								 , QTD_JUNCAO     = '".$rowTotvsSB1010['B1_QTDJUN']."'
								 , CO_GRUPO       = '".$rowTotvsSB1010['B1_GRUPO']."'
								 , FL_BLOQUEIO    = '".$rowTotvsSB1010['B1_MSBLQL']."'
						 	 WHERE CO_RECNO = '".$rowTotvsSB1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>