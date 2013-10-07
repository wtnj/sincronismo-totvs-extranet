<?php
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
										  WHERE R_E_C_N_O_ = ".$rowTotvsLog["R_E_C_N_O_"]);
	ociexecute($sqlTotvsSC9010);
	$rowTotvsSC9010 = oci_fetch_array($sqlTotvsSC9010);
			
	if($rowTotvsLog["TP_LOG"] == "Insert"){
	
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
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
					
	    mysql_query("UPDATE tb_fat_pedidos_liberados SET
						   NU_PEDIDO_VENDA     = '".$rowTotvsSC9010['C9_PEDIDO']."'
						 , CO_ITEM_PEDIDO_VENDA= '".$rowTotvsSC9010['C9_ITEM']."'
						 , CO_CLIENTE          = '".$rowTotvsSC9010['C9_CLIENTE']."'
						 , CO_PRODUTO          = '".$rowTotvsSC9010['C9_PRODUTO']."'
						 , QTD_LIBERADA        = '".$rowTotvsSC9010['C9_QTDLIB']."'
						 , NU_NOTA             = '".$rowTotvsSC9010['C9_NFISCAL']."'
						 , NU_SERIE            = '".$rowTotvsSC9010['C9_SERIENF']."'
						 , DT_LIBERACAO        = '".$rowTotvsSC9010['C9_DATALIB ']."'
						 , NU_SEQUENCIA        = '".$rowTotvsSC9010['C9_SEQUEN']."'
						 , CO_ARMAZEM          = '".$rowTotvsSC9010['C9_LOCAL']."'
						 , CO_CARGA            = '".$rowTotvsSC9010['C9_CARGA']."'
						 , NU_SEQ_CARGA        = '".$rowTotvsSC9010['C9_SEQCAR']."'
						 , NU_SEQ_ENTREGA      = '".$rowTotvsSC9010['C9_SEQENT']."'
					 WHERE CO_RECNO 		   = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsSC9010['D_E_L_E_T_'])=='*'){
			
	    	mysql_query("UPDATE tb_fat_pedidos_liberados SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	    }else{
			
	    	mysql_query("UPDATE tb_fat_pedidos_liberados SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_fat_pedidos_liberados SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSC9010['R_E_C_N_O_']."'",$conexaoExtranet);
				
	}
			
?>