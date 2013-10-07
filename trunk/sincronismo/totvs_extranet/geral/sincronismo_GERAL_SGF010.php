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
			 
    $sqlTotvsSGF010 = ociparse($totvsConexao,"SELECT GF_PRODUTO
											      , GF_ROTEIRO
											      , GF_OPERAC
											      , GF_COMP
											      , GF_TRT
											      , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM SGF010
											  ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSGF010);
	
	while($rowTotvsSGF010 = oci_fetch_array($sqlTotvsSGF010)){
	
	    $sqlPcpProduto = mysql_query("SELECT null FROM tb_pcp_operacao_componente WHERE CO_RECNO = '".$rowTotvsSGF010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpProduto) == 0){
			
			if(trim($rowTotvsSGF010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_pcp_operacao_componente (CO_PRODUTO
					             , NU_ROTEIRO
					             , NU_OPERACAO
					             , CO_COMPONENTE
					             , NU_SEQUENCIA
					             , CO_RECNO
							     , FL_DELET)
							 VALUES('".trim($rowTotvsSGF010['GF_PRODUTO'])."'
					             , '".trim($rowTotvsSGF010['GF_ROTEIRO'])."'
								 , '".trim($rowTotvsSGF010['GF_OPERAC'])."'
								 , '".trim($rowTotvsSGF010['GF_COMP'])."'
								 , '".trim($rowTotvsSGF010['GF_TRT'])."'
								 , '".$rowTotvsSGF010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				mysql_query("INSERT INTO tb_pcp_operacao_componente (CO_PRODUTO
					             , NU_ROTEIRO
					             , NU_OPERACAO
					             , CO_COMPONENTE
					             , NU_SEQUENCIA
					             , CO_RECNO)
							 VALUES('".trim($rowTotvsSGF010['GF_PRODUTO'])."'
					             , '".trim($rowTotvsSGF010['GF_ROTEIRO'])."'
								 , '".trim($rowTotvsSGF010['GF_OPERAC'])."'
								 , '".trim($rowTotvsSGF010['GF_COMP'])."'
								 , '".trim($rowTotvsSGF010['GF_TRT'])."'
								 , '".$rowTotvsSGF010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSGF010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_operacao_componente SET
				                 CO_PRODUTO      = '".trim($rowTotvsSGF010['GF_PRODUTO'])."'
					             , NU_ROTEIRO    = '".trim($rowTotvsSGF010['GF_ROTEIRO'])."'
								 , NU_OPERACAO   = '".trim($rowTotvsSGF010['GF_OPERAC'])."'
								 , CO_COMPONENTE = '".trim($rowTotvsSGF010['GF_COMP'])."'
								 , NU_SEQUENCIA  = '".trim($rowTotvsSGF010['GF_TRT'])."'
								 , FL_DELET       = '*'							     
						 	 WHERE CO_RECNO = '".$rowTotvsSGF010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_operacao_componente SET
							     CO_PRODUTO      = '".trim($rowTotvsSGF010['GF_PRODUTO'])."'
					             , NU_ROTEIRO    = '".trim($rowTotvsSGF010['GF_ROTEIRO'])."'
								 , NU_OPERACAO   = '".trim($rowTotvsSGF010['GF_OPERAC'])."'
								 , CO_COMPONENTE = '".trim($rowTotvsSGF010['GF_COMP'])."'
								 , NU_SEQUENCIA  = '".trim($rowTotvsSGF010['GF_TRT'])."'
						 	 WHERE CO_RECNO = '".$rowTotvsSGF010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>