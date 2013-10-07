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
	
	$sqlTotvsSD4010 = ociparse($totvsConexao,"SELECT D4_COD
	                                              , D4_LOCAL
												  , D4_OP
												  , D4_OPORIG
												  , D4_QUANT
												  , D4_QTDEORI
												  , D4_QTSEGUM
												  , D4_DATA
												  , R_E_C_N_O_
										      FROM SD4010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSD4010);
	
	while($rowTotvsSD4010 = oci_fetch_array($sqlTotvsSD4010)){
		
		$qtdAjusteEmpenho = (string)($rowTotvsSD4010['D4_QUANT']);
		$qtdOrigem        = (string)($rowTotvsSD4010['D4_QTDEORI']);
		$qtdSegUM         = (string)($rowTotvsSD4010['D4_QTSEGUM']);
			
		if(substr($qtdAjusteEmpenho,0,1) == '.' || substr($qtdAjusteEmpenho,0,1) == ','){
			$qtdAjusteEmpenho = '0'.$qtdAjusteEmpenho;
		}
						
		if(substr($qtdOrigem,0,1) == '.' || substr($qtdOrigem,0,1) == ','){
			$qtdOrigem = '0'.$qtdOrigem;
		}
					
		if(substr($qtdSegUM,0,1) == '.' || substr($qtdSegUM,0,1) == ','){
			$qtdSegUM = '0'.$qtdSegUM;
		}
			
	    $sqlPcpAjusteEmpenho = mysql_query("SELECT null FROM tb_pcp_ajuste_empenho WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpAjusteEmpenho) == 0){
			
			if(trim($rowTotvsSD4010['D_E_L_E_T_']) == '*'){
				
				mysql_query("INSERT INTO tb_pcp_ajuste_empenho (CO_PRODUTO
						         , NU_ARMAZEM
						         , NU_OP
						         , NU_OP_ORIGEM
						         , SALDO_EMPENHO
						         , QTD_ORIGEM
						         , QTD_SEG_UM
						         , DT_CADASTRO
						         , CO_RECNO
							     , FL_DELET)
					 	 	 VALUES('".trim($rowTotvsSD4010['D4_COD'])."' 
					             , '".trim($rowTotvsSD4010['D4_LOCAL'])."'
							     , '".trim($rowTotvsSD4010['D4_OP'])."'
							     , '".trim($rowTotvsSD4010['D4_OPORIG'])."'
							     , '".$qtdAjusteEmpenho."'
							     , '".$qtdOrigem."'
							     , '".$qtdSegUM."'
							     , '".trim($rowTotvsSD4010['D4_DATA'])."'
							     , '".$rowTotvsSD4010['R_E_C_N_O_']."'
							     , '*')",$conexaoExtranet)or die(mysql_error());
							
			}else{
				
				mysql_query("INSERT INTO tb_pcp_ajuste_empenho (CO_PRODUTO
						         , NU_ARMAZEM
						         , NU_OP
						         , NU_OP_ORIGEM
						         , SALDO_EMPENHO
						         , QTD_ORIGEM
						         , QTD_SEG_UM
						         , DT_CADASTRO
						         , CO_RECNO)
					 	 	 VALUES('".trim($rowTotvsSD4010['D4_COD'])."' 
					             , '".trim($rowTotvsSD4010['D4_LOCAL'])."'
							     , '".trim($rowTotvsSD4010['D4_OP'])."'
							     , '".trim($rowTotvsSD4010['D4_OPORIG'])."'
							     , '".$qtdAjusteEmpenho."'
							     , '".$qtdOrigem."'
							     , '".$qtdSegUM."'
							     , '".trim($rowTotvsSD4010['D4_DATA'])."'
							     , '".$rowTotvsSD4010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
												 
			}
			
		}else{
			
			if(trim($rowTotvsSD4010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_ajuste_empenho SET
				                 CO_PRODUTO      = '".trim($rowTotvsSD4010['D4_COD'])."' 
						         , NU_ARMAZEM    = '".trim($rowTotvsSD4010['D4_LOCAL'])."'
						         , NU_OP         = '".trim($rowTotvsSD4010['D4_OP'])."'
						         , NU_OP_ORIGEM  = '".trim($rowTotvsSD4010['D4_OPORIG'])."'
						         , SALDO_EMPENHO = '".$qtdAjusteEmpenho."'
						         , QTD_ORIGEM    = '".$qtdOrigem."'
						         , QTD_SEG_UM    = '".$qtdSegUM."'
						         , DT_CADASTRO   = '".trim($rowTotvsSD4010['D4_DATA'])."'							 
							     , FL_DELET      = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				 mysql_query("UPDATE tb_pcp_ajuste_empenho SET
				                 CO_PRODUTO      = '".trim($rowTotvsSD4010['D4_COD'])."' 
						         , NU_ARMAZEM    = '".trim($rowTotvsSD4010['D4_LOCAL'])."'
						         , NU_OP         = '".trim($rowTotvsSD4010['D4_OP'])."'
						         , NU_OP_ORIGEM  = '".trim($rowTotvsSD4010['D4_OPORIG'])."'
						         , SALDO_EMPENHO = '".$qtdAjusteEmpenho."'
						         , QTD_ORIGEM    = '".$qtdOrigem."'
						         , QTD_SEG_UM    = '".$qtdSegUM."'
						         , DT_CADASTRO   = '".trim($rowTotvsSD4010['D4_DATA'])."'
						 	 WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
							
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>