<?php 

    ini_set("max_execution_time",3600);
	ini_set("memory_limit","50M");
    set_time_limit(0);
	
	date_default_timezone_set('America/Sao_Paulo');

    $ora_user = "TOPTES03"; 
	$ora_senha = "TOPTES03"; 

	$ora_bd = "(DESCRIPTION=
			  (ADDRESS_LIST=
				(ADDRESS=(PROTOCOL=TCP) 
				  (HOST=192.168.0.8)(PORT=1521)
				)
			  )
			  (CONNECT_DATA=(SERVICE_NAME=TOPORA))
     )"; 

    $totvsConexao = OCILogon($ora_user,$ora_senha,$ora_bd);
	
	$conexaoExtranet = mysql_connect("192.168.0.15","root","")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURAÇÃO DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Iniciado...<br>";

	/* Convert EUC-JP to UTF-7 */
	$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
	
	$sqlPcpUltimoApontamento = mysql_query("SELECT CO_PCP_APONTAMENTO
    										    , CO_PCP_OP
												, NU_OP
												, DT_INICIO_APONTAMENTO
												, DT_FINAL_APONTAMENTO
												, HR_INICIO
												, HR_FIM
												, CO_PRODUTO
												, CO_INT_PRODUTO
												, CO_COR
												, QTD_PRODUTO
												, CO_PCP_OPERACAO
												, CO_OPERACAO 
												, CO_PCP_RECURSO
												, CO_RECURSO
												, LG_USUARIO 
											FROM vw_pcp_produto_pi_ultimo_apontamento",$conexaoExtranet)
	or die(mysql_error());
		
	if(mysql_num_rows($sqlPcpUltimoApontamento) > 0){
	    
		while($rowPcpUltimoApontamento=mysql_fetch_array($sqlPcpUltimoApontamento)){ 
			
			//INICIO CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
			$sqlIntegraçãoTotvsRecno = ociparse($totvsConexao,"SELECT MAX(R_E_C_N_O_) AS R_E_C_N_O FROM ZP0010");
	    	ociexecute($sqlIntegraçãoTotvsRecno);	
			
			$rowIntegraçãoTotvsRecno = oci_fetch_array($sqlIntegraçãoTotvsRecno);
			
			if($rowIntegraçãoTotvsRecno['R_E_C_N_O'] > 0){
			    $recnoIntegracaoApontamento = $rowIntegraçãoTotvsRecno['R_E_C_N_O']+1;
			}else{
				$recnoIntegracaoApontamento = 1;
			}
			//FIM CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
			
			//INICIO CAPTURA O CODIGO Da ULTIMA INTEGRACAO DA TABELA
			$sqlIntegraçãoTotvsCodigoIntegracao = ociparse($totvsConexao,"SELECT MAX(ZP0_XCOINT) AS ZP0_XCOINT FROM ZP0010");
	    	ociexecute($sqlIntegraçãoTotvsCodigoIntegracao);	
			
			$rowIntegraçãoTotvsCodigoIntegracao = oci_fetch_array($sqlIntegraçãoTotvsCodigoIntegracao);
			
			if($rowIntegraçãoTotvsCodigoIntegracao['ZP0_XCOINT'] > 0){
			    $codigoIntegracaoApontamento = $rowIntegraçãoTotvsCodigoIntegracao['ZP0_XCOINT']+1;
			}else{
				$codigoIntegracaoApontamento = 1;
			}
			//FIM CAPTURA O CODIGO DA ULTIMA INTEGRACAO DA TABELA
			
			$dataHoraCadastro   = date("Y-m-d h:i:s");
			$tipoApontamento    = '1';
			$statusApontamento  = '3';
			$filialApontamento  = '01';
			//$dataApontamento    = $rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO'];
			$dataApontamento    = date("Y-m-d");
			//$dataProducao       = $rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO'];
			$dataProducao       = date("Y-m-d");
			$armazemApontamento = '87';
			
		    $sqlIntegracaoTotvsApontamento = ociparse($totvsConexao,"INSERT INTO ZP0010 (ZP0_XCOINT
																		 , ZP0_XDCAIN 
												 						 , ZP0_XCODEX
																		 , ZP0_XTPINT 
																		 , ZP0_XSTINT 
																		 , ZP0_FILIAL
																		 , ZP0_DTAPON
																		 , ZP0_DTPROD
																		 , ZP0_DATAIN
																		 , ZP0_DATAFI
																		 , ZP0_HORAFI 
																		 , ZP0_HORAIN
																		 , ZP0_OP
																		 , ZP0_PRODUT
																		 , ZP0_CODINT
																		 , ZP0_COR
																		 , ZP0_QTDPRO
																		 , ZP0_LOCAL 
																		 , ZP0_OPERAC
																		 , ZP0_RECURS
																		 , ZP0_OPERAD
																		 , R_E_C_N_O_)
																	 VALUES('".$codigoIntegracaoApontamento."'
																	     , '".$dataHoraCadastro."'
																		 , '".$rowPcpUltimoApontamento['CO_PCP_APONTAMENTO']."'
																		 , '".$tipoApontamento."'
																		 , '".$statusApontamento."'
																		 , '".$filialApontamento."'
																		 , '".$dataApontamento."'
																		 , '".$dataProducao."'
																		 , '".$rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO']."'
																		 , '".$rowPcpUltimoApontamento['DT_FINAL_APONTAMENTO']."'
																		 , '".$rowPcpUltimoApontamento['HR_INICIO']."'
																	     , '".$rowPcpUltimoApontamento['HR_FIM']."'
																		 , '".$rowPcpUltimoApontamento['NU_OP']."'
																		 , '".$rowPcpUltimoApontamento['CO_PRODUTO']."'
																		 , '".$rowPcpUltimoApontamento['CO_INT_PRODUTO']."'
																		 , '".$rowPcpUltimoApontamento['CO_COR']."'
																		 , '".$rowPcpUltimoApontamento['QTD_PRODUTO']."'
																		 , '".$armazemApontamento."'
																		 , '".$rowPcpUltimoApontamento['CO_OPERACAO']."'
																		 , '".$rowPcpUltimoApontamento['CO_RECURSO']."'
																		 , '".$rowPcpUltimoApontamento['LG_USUARIO']."'
																		 , '".$recnoIntegracaoApontamento."')");
	    	ociexecute($sqlIntegracaoTotvsApontamento);	
			
			if($sqlIntegracaoTotvsApontamento){
			    
				mysql_query("UPDATE tb_pcp_apontamento SET
							     FL_SINCRONISMO       = '*'
						 	 WHERE CO_RECNO = '".$rowPcpUltimoApontamento['CO_PCP_APONTAMENTO']."'",$conexaoExtranet)or die(mysql_error());
				
			}
				
		}
		
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>