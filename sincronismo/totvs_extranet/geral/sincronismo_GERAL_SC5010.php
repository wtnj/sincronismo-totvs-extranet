<?php 

	$sqlTotvsSC5010 = ociparse($totvsConexao,"SELECT C5_FILIAL
											      , C5_NUM
											      , C5_PEDCLI
											      , C5_TIPO
											      , C5_CLAPED
											      , C5_CLIENTE
											      , C5_LOJACLI
											      , C5_CONDPAG
											      , C5_TIPOCLI
											      , C5_VEND1
												  , C5_VEND2
												  , C5_TPFRETE
												  , C5_EMISSAO
												  , C5_LIBEROK
												  , C5_NOTA
												  , C5_SERIE
												  , C5_TIPLIB
												  , C5_TPCARGA
												  , R_E_C_N_O_
												  , D_E_L_E_T_
											  FROM SC5010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSC5010);
	
	while($rowTotvsSC5010 = oci_fetch_array($sqlTotvsSC5010)){
	
	    $sqlFatPedidoVenda = mysql_query("SELECT null FROM tb_fat_pedido_venda WHERE CO_RECNO = '".$rowTotvsSC5010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatPedidoVenda) == 0){
			
			if(trim($rowTotvsSC5010['D_E_L_E_T_']) == '*'){
				
				mysql_query("INSERT INTO tb_fat_pedido_venda (CO_FILIAL
					             , DT_EMISSAO
								 , NU_PEDIDO_VENDA
								 , NU_PEDIDO_CLIENTE
								 , TP_PEDIDO_VENDA
								 , CO_CATEGORIA
								 , TP_CLIENTE
								 , CO_CLIENTE
								 , CO_LOJA_CLIENTE
								 , CO_PAGAMENTO
								 , CO_VENDEDOR1
								 , CO_VENDEDOR2
								 , TP_FRETE
								 , FL_PEDIDO_LIBERADO_TOTAL
								 , NU_NOTA_FISCAL
								 , NU_SERIE_NOTA_FISCAL
								 , TP_LIBERACAO
								 , FL_CARGA
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".trim($rowTotvsSC5010['C5_FILIAL'])."' 
							     , '".trim($rowTotvsSC5010['C5_EMISSAO'])."'	
								 , '".trim($rowTotvsSC5010['C5_NUM'])."'	
								 , '".trim($rowTotvsSC5010['C5_PEDCLI'])."'	
								 , '".trim($rowTotvsSC5010['C5_TIPO'])."'	
								 , '".trim($rowTotvsSC5010['C5_CLAPED'])."'	
								 , '".trim($rowTotvsSC5010['C5_TIPOCLI'])."'	
								 , '".trim($rowTotvsSC5010['C5_CLIENTE'])."'	
								 , '".trim($rowTotvsSC5010['C5_LOJACLI'])."'	
								 , '".trim($rowTotvsSC5010['C5_CONDPAG'])."'	
								 , '".trim($rowTotvsSC5010['C5_VEND1'])."'	
								 , '".trim($rowTotvsSC5010['C5_VEND2'])."'	
								 , '".trim($rowTotvsSC5010['C5_TPFRETE'])."'	
								 , '".trim($rowTotvsSC5010['C5_LIBEROK'])."'	
								 , '".trim($rowTotvsSC5010['C5_NOTA'])."'	
								 , '".trim($rowTotvsSC5010['C5_SERIE'])."'	
								 , '".trim($rowTotvsSC5010['C5_TIPLIB'])."'	
								 , '".trim($rowTotvsSC5010['C5_TPCARGA'])."'							
								 , '".$rowTotvsSC5010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
							
			}else{
				
				mysql_query("INSERT INTO tb_fat_pedido_venda (CO_FILIAL
					             , DT_EMISSAO
								 , NU_PEDIDO_VENDA
								 , NU_PEDIDO_CLIENTE
								 , TP_PEDIDO_VENDA
								 , CO_CATEGORIA
								 , TP_CLIENTE
								 , CO_CLIENTE
								 , CO_LOJA_CLIENTE
								 , CO_PAGAMENTO
								 , CO_VENDEDOR1
								 , CO_VENDEDOR2
								 , TP_FRETE
								 , FL_PEDIDO_LIBERADO_TOTAL
								 , NU_NOTA_FISCAL
								 , NU_SERIE_NOTA_FISCAL
								 , TP_LIBERACAO
								 , FL_CARGA
								 , CO_RECNO)
						     VALUES('".trim($rowTotvsSC5010['C5_FILIAL'])."' 
					             , '".trim($rowTotvsSC5010['C5_EMISSAO'])."'	
								 , '".trim($rowTotvsSC5010['C5_NUM'])."'	
								 , '".trim($rowTotvsSC5010['C5_PEDCLI'])."'	
								 , '".trim($rowTotvsSC5010['C5_TIPO'])."'	
								 , '".trim($rowTotvsSC5010['C5_CLAPED'])."'	
								 , '".trim($rowTotvsSC5010['C5_TIPOCLI'])."'	
								 , '".trim($rowTotvsSC5010['C5_CLIENTE'])."'	
								 , '".trim($rowTotvsSC5010['C5_LOJACLI'])."'	
								 , '".trim($rowTotvsSC5010['C5_CONDPAG'])."'	
								 , '".trim($rowTotvsSC5010['C5_VEND1'])."'	
								 , '".trim($rowTotvsSC5010['C5_VEND2'])."'	
								 , '".trim($rowTotvsSC5010['C5_TPFRETE'])."'	
								 , '".trim($rowTotvsSC5010['C5_LIBEROK'])."'	
								 , '".trim($rowTotvsSC5010['C5_NOTA'])."'	
								 , '".trim($rowTotvsSC5010['C5_SERIE'])."'	
								 , '".trim($rowTotvsSC5010['C5_TIPLIB'])."'	
								 , '".trim($rowTotvsSC5010['C5_TPCARGA'])."'							
								 , '".$rowTotvsSC5010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSC5010['D_E_L_E_T_']) == '*'){
				
				mysql_query("UPDATE tb_fat_pedido_venda SET
					             CO_FILIAL                  = '".trim($rowTotvsSC5010['C5_FILIAL'])."' 
								 , DT_EMISSAO               = '".trim($rowTotvsSC5010['C5_EMISSAO'])."'	
								 , NU_PEDIDO_VENDA          = '".trim($rowTotvsSC5010['C5_NUM'])."'	
								 , NU_PEDIDO_CLIENTE        = '".trim($rowTotvsSC5010['C5_PEDCLI'])."'	
								 , TP_PEDIDO_VENDA          = '".trim($rowTotvsSC5010['C5_TIPO'])."'	
								 , CO_CATEGORIA             = '".trim($rowTotvsSC5010['C5_CLAPED'])."'	
								 , TP_CLIENTE               = '".trim($rowTotvsSC5010['C5_TIPOCLI'])."'
								 , CO_CLIENTE               = '".trim($rowTotvsSC5010['C5_CLIENTE'])."'	
								 , CO_LOJA_CLIENTE          = '".trim($rowTotvsSC5010['C5_LOJACLI'])."'	
								 , CO_PAGAMENTO             = '".trim($rowTotvsSC5010['C5_CONDPAG'])."'
								 , CO_VENDEDOR1             = '".trim($rowTotvsSC5010['C5_VEND1'])."'	
								 , CO_VENDEDOR2             = '".trim($rowTotvsSC5010['C5_VEND2'])."'	
								 , TP_FRETE                 = '".trim($rowTotvsSC5010['C5_TPFRETE'])."'	
								 , FL_PEDIDO_LIBERADO_TOTAL = '".trim($rowTotvsSC5010['C5_LIBEROK'])."'	
								 , NU_NOTA_FISCAL           = '".trim($rowTotvsSC5010['C5_NOTA'])."'
								 , NU_SERIE_NOTA_FISCAL     = '".trim($rowTotvsSC5010['C5_SERIE'])."'	
								 , TP_LIBERACAO             = '".trim($rowTotvsSC5010['C5_TIPLIB'])."'	
								 , FL_CARGA                 = '".trim($rowTotvsSC5010['C5_TPCARGA'])."'	
								 , FL_DELET                 = '*'
					 		WHERE CO_RECNO = '".$rowTotvsSC5010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
						
			}else{
				
			    mysql_query("UPDATE tb_fat_pedido_venda SET
					             CO_FILIAL                  = '".trim($rowTotvsSC5010['C5_FILIAL'])."' 
								 , DT_EMISSAO               = '".trim($rowTotvsSC5010['C5_EMISSAO'])."'	
								 , NU_PEDIDO_VENDA          = '".trim($rowTotvsSC5010['C5_NUM'])."'	
								 , NU_PEDIDO_CLIENTE        = '".trim($rowTotvsSC5010['C5_PEDCLI'])."'	
								 , TP_PEDIDO_VENDA          = '".trim($rowTotvsSC5010['C5_TIPO'])."'	
								 , CO_CATEGORIA             = '".trim($rowTotvsSC5010['C5_CLAPED'])."'	
								 , TP_CLIENTE               = '".trim($rowTotvsSC5010['C5_TIPOCLI'])."'
								 , CO_CLIENTE               = '".trim($rowTotvsSC5010['C5_CLIENTE'])."'	
								 , CO_LOJA_CLIENTE          = '".trim($rowTotvsSC5010['C5_LOJACLI'])."'	
								 , CO_PAGAMENTO             = '".trim($rowTotvsSC5010['C5_CONDPAG'])."'
								 , CO_VENDEDOR1             = '".trim($rowTotvsSC5010['C5_VEND1'])."'	
								 , CO_VENDEDOR2             = '".trim($rowTotvsSC5010['C5_VEND2'])."'	
								 , TP_FRETE                 = '".trim($rowTotvsSC5010['C5_TPFRETE'])."'	
								 , FL_PEDIDO_LIBERADO_TOTAL = '".trim($rowTotvsSC5010['C5_LIBEROK'])."'	
								 , NU_NOTA_FISCAL           = '".trim($rowTotvsSC5010['C5_NOTA'])."'
								 , NU_SERIE_NOTA_FISCAL     = '".trim($rowTotvsSC5010['C5_SERIE'])."'	
								 , TP_LIBERACAO             = '".trim($rowTotvsSC5010['C5_TIPLIB'])."'	
								 , FL_CARGA                 = '".trim($rowTotvsSC5010['C5_TPCARGA'])."'	
							 WHERE CO_RECNO = '".$rowTotvsSC5010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
							
			}
			
		}
	
	}
			
?>