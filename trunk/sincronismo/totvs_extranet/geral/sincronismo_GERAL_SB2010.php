<?php 
	
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
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSB2010);
	
	while($rowTotvsSB2010 = oci_fetch_array($sqlTotvsSB2010)){
		
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
			
	    $sqlPcpProdutoSaldo = mysql_query("SELECT null FROM tb_pcp_produto_saldo WHERE CO_RECNO = '".$rowTotvsSB2010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpProdutoSaldo) == 0){
			
			if(trim($rowTotvsSB2010['D_E_L_E_T_']) == '*'){
					
				mysql_query("INSERT INTO tb_pcp_produto_saldo (CO_PRODUTO
								 , QTD_ATUAL
								 , QTD_EMPENHO
								 , QTD_SALDO_MES
								 , QTD_RESERVADA
								 , QTD_PEDIDO_VENDA
								 , NU_ARMAZEM
								 , DT_ULTIMA_SAIDA
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".$rowTotvsSB2010['B2_COD']."' 
								 , '".$qtdAtual."'
								 , '".$qtdEmpenho."'
								 , '".$qtdMes."'
								 , '".$qtdReservada."'
								 , '".$qtdPedidoVenda."'
								 , '".$rowTotvsSB2010['B2_LOCAL']."'
								 , '".$rowTotvsSB2010['B2_USAI']."'
								 , '".$rowTotvsSB2010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
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
								 , '".$rowTotvsSB2010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSB2010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_produto_saldo SET
							     CO_PRODUTO         = '".$rowTotvsSB2010['B2_COD']."' 
								 , QTD_ATUAL        = '".$qtdAtual."'
								 , QTD_EMPENHO      = '".$qtdEmpenho."'
								 , QTD_SALDO_MES    = '".$qtdMes."'
								 , QTD_RESERVADA    = '".$qtdReservada."'
								 , QTD_PEDIDO_VENDA = '".$qtdPedidoVenda."'
								 , NU_ARMAZEM       = '".$rowTotvsSB2010['B2_LOCAL']."'
								 , DT_ULTIMA_SAIDA  = '".$rowTotvsSB2010['B2_USAI']."'
							     , FL_DELET         = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSB2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_produto_saldo SET
							     CO_PRODUTO         = '".$rowTotvsSB2010['B2_COD']."' 
								 , QTD_ATUAL        = '".$qtdAtual."'
								 , QTD_EMPENHO      = '".$qtdEmpenho."'
								 , QTD_SALDO_MES    = '".$qtdMes."'
								 , QTD_RESERVADA    = '".$qtdReservada."'
								 , QTD_PEDIDO_VENDA = '".$qtdPedidoVenda."'
								 , NU_ARMAZEM       = '".$rowTotvsSB2010['B2_LOCAL']."'
								 , DT_ULTIMA_SAIDA  = '".$rowTotvsSB2010['B2_USAI']."'
						 	 WHERE CO_RECNO = '".$rowTotvsSB2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
			
?>