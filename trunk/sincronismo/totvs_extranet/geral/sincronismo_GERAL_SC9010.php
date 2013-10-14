<?php 
			 
    $sqlTotvsSC9010 = ociparse($totvsConexao,"SELECT C9_PEDIDO 
											      , C9_ITEM  
												  , C9_CLIENTE 
												  , C9_LOJA
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
											  ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSC9010);
	
	while($rowTotvsSC9010 = oci_fetch_array($sqlTotvsSC9010)){
		
	    $sqlFatPedidoVendaLiberado = mysql_query("SELECT null FROM tb_fat_pedido_venda_liberado WHERE CO_RECNO = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatPedidoVendaLiberado) == 0){
			
			if(trim($rowTotvsSC9010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_fat_pedido_venda_liberado (NU_PEDIDO_VENDA 	
							     , NU_ITEM 
								 , CO_CLIENTE 
								 , CO_LOJA_CLIENTE
								 , CO_PRODUTO 
								 , QTD_LIBERADA 
								 , NU_NOTA_FISCAL 
								 , NU_SERIE_NOTA_FISCAL 
								 , DT_LIBERACAO 
								 , NU_SEQUENCIA 
								 , NU_ARMAZEM 
								 , NU_CARGA 
								 , NU_SEQ_CARGA 
								 , NU_SEQ_ENTREGA  
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".$rowTotvsSC9010['C9_PEDIDO']."'  
								 , '".$rowTotvsSC9010['C9_ITEM']."'  
								 , '".$rowTotvsSC9010['C9_CLIENTE']."'  
								 , '".$rowTotvsSC9010['C9_LOJA']."'
								 , '".trim($rowTotvsSC9010['C9_PRODUTO'])."'   
								 , '".$rowTotvsSC9010['C9_QTDLIB']."'   
								 , '".$rowTotvsSC9010['C9_NFISCAL']."'  
								 , '".$rowTotvsSC9010['C9_SERIENF']."'  
								 , '".$rowTotvsSC9010['C9_DATALIB']."'  
								 , '".$rowTotvsSC9010['C9_SEQUEN']."'  
								 , '".$rowTotvsSC9010['C9_LOCAL']."'   
								 , '".$rowTotvsSC9010['C9_CARGA']."'  
								 , '".$rowTotvsSC9010['C9_SEQCAR']."'   
								 , '".$rowTotvsSC9010['C9_SEQENT']."'  
								 , '".$rowTotvsSC9010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("INSERT INTO tb_fat_pedido_venda_liberado (NU_PEDIDO_VENDA 	
							     , NU_ITEM 
								 , CO_CLIENTE 
								 , CO_LOJA_CLIENTE
								 , CO_PRODUTO 
								 , QTD_LIBERADA 
								 , NU_NOTA_FISCAL 
								 , NU_SERIE_NOTA_FISCAL 
								 , DT_LIBERACAO 
								 , NU_SEQUENCIA 
								 , NU_ARMAZEM 
								 , NU_CARGA 
								 , NU_SEQ_CARGA 
								 , NU_SEQ_ENTREGA  
								 , CO_RECNO)
							 VALUES('".$rowTotvsSC9010['C9_PEDIDO']."'  
								 , '".$rowTotvsSC9010['C9_ITEM']."'  
								 , '".$rowTotvsSC9010['C9_CLIENTE']."'  
								 , '".$rowTotvsSC9010['C9_LOJA']."'
								 , '".trim($rowTotvsSC9010['C9_PRODUTO'])."'   
								 , '".$rowTotvsSC9010['C9_QTDLIB']."'   
								 , '".$rowTotvsSC9010['C9_NFISCAL']."'  
								 , '".$rowTotvsSC9010['C9_SERIENF']."'  
								 , '".$rowTotvsSC9010['C9_DATALIB']."'  
								 , '".$rowTotvsSC9010['C9_SEQUEN']."'  
								 , '".$rowTotvsSC9010['C9_LOCAL']."'   
								 , '".$rowTotvsSC9010['C9_CARGA']."'  
								 , '".$rowTotvsSC9010['C9_SEQCAR']."'   
								 , '".$rowTotvsSC9010['C9_SEQENT']."'  
								 , '".$rowTotvsSC9010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSC9010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_fat_pedido_venda_liberado SET
							     NU_PEDIDO_VENDA 	    = '".$rowTotvsSC9010['C9_PEDIDO']."'  
							     , NU_ITEM              = '".$rowTotvsSC9010['C9_ITEM']."'  
								 , CO_CLIENTE           = '".$rowTotvsSC9010['C9_CLIENTE']."'  
								 , CO_LOJA_CLIENTE      = '".$rowTotvsSC9010['C9_LOJA']."'
								 , CO_PRODUTO           = '".trim($rowTotvsSC9010['C9_PRODUTO'])."'  
								 , QTD_LIBERADA         = '".$rowTotvsSC9010['C9_QTDLIB']."'   
								 , NU_NOTA_FISCAL       = '".$rowTotvsSC9010['C9_NFISCAL']."'  
								 , NU_SERIE_NOTA_FISCAL = '".$rowTotvsSC9010['C9_SERIENF']."'  
								 , DT_LIBERACAO         = '".$rowTotvsSC9010['C9_DATALIB']."'  
								 , NU_SEQUENCIA         = '".$rowTotvsSC9010['C9_SEQUEN']."'
								 , NU_ARMAZEM           = '".$rowTotvsSC9010['C9_LOCAL']."'   
								 , NU_CARGA             = '".$rowTotvsSC9010['C9_CARGA']."' 
								 , NU_SEQ_CARGA         = '".$rowTotvsSC9010['C9_SEQCAR']."'
								 , NU_SEQ_ENTREGA       = '".$rowTotvsSC9010['C9_SEQENT']."'
							     , FL_DELET             = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_fat_pedido_venda_liberado SET
							     NU_PEDIDO_VENDA 	    = '".$rowTotvsSC9010['C9_PEDIDO']."'  
							     , NU_ITEM              = '".$rowTotvsSC9010['C9_ITEM']."'  
								 , CO_CLIENTE           = '".$rowTotvsSC9010['C9_CLIENTE']."'  
								 , CO_LOJA_CLIENTE      = '".$rowTotvsSC9010['C9_LOJA']."'
								 , CO_PRODUTO           = '".trim($rowTotvsSC9010['C9_PRODUTO'])."'  
								 , QTD_LIBERADA         = '".$rowTotvsSC9010['C9_QTDLIB']."'   
								 , NU_NOTA_FISCAL       = '".$rowTotvsSC9010['C9_NFISCAL']."'  
								 , NU_SERIE_NOTA_FISCAL = '".$rowTotvsSC9010['C9_SERIENF']."'  
								 , DT_LIBERACAO         = '".$rowTotvsSC9010['C9_DATALIB']."'  
								 , NU_SEQUENCIA         = '".$rowTotvsSC9010['C9_SEQUEN']."'
								 , NU_ARMAZEM           = '".$rowTotvsSC9010['C9_LOCAL']."'   
								 , NU_CARGA             = '".$rowTotvsSC9010['C9_CARGA']."' 
								 , NU_SEQ_CARGA         = '".$rowTotvsSC9010['C9_SEQCAR']."'
								 , NU_SEQ_ENTREGA       = '".$rowTotvsSC9010['C9_SEQENT']."'
						 	 WHERE CO_RECNO = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
			
?>