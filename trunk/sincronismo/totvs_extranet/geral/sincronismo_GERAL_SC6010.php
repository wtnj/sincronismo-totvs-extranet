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
			 
    $sqlTotvsSC6010 = ociparse($totvsConexao,"SELECT C6_FILIAL
											      , C6_ITEM
												  , C6_PRODUTO
												  , C6_QTDVEN
												  , C6_UM
												  , C6_PRCVEN
												  , C6_VALOR
												  , C6_NUM
												  , C6_TES 
												  , C6_CF
												  , C6_QTDLIB
												  , C6_MOTAT
												  , C6_PROORI
												  , C6_QTDENT
												  , C6_DESCONT
												  , C6_NOTA
												  , C6_SERIE
												  , C6_VALDESC
												  , C6_NUMORC
												  , C6_ENTREG
												  , C6_LOCAL
												  , C6_DATFAT
												  , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM SC6010
											  ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSC6010);
	
	while($rowTotvsSC6010 = oci_fetch_array($sqlTotvsSC6010)){
	
	    $sqlFatPedidoVendaItem = mysql_query("SELECT null FROM tb_fat_pedido_venda_item WHERE CO_RECNO = '".$rowTotvsSC6010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatPedidoVendaItem) == 0){
			
			if(trim($rowTotvsSC6010['D_E_L_E_T_']) == '*'){
				
				mysql_query("INSERT INTO tb_fat_pedido_venda_item (CO_FILIAL
							     , NU_PEDIDO_VENDA
								 , NU_ITEM
								 , CO_PRODUTO
								 , TP_UNIDADE
								 , QTD_PRODUTO
								 , QTD_LIBERADA
								 , QTD_ENTREGA
								 , VL_PRODUTO
								 , VL_DESCONTO
								 , PER_DESCONTO
								 , VL_TOTAL
								 , NU_TES
								 , NU_CFOP
								 , TP_MOTIVO_AT
								 , CO_PRODUTO_AT
								 , NU_NOTA_FISCAL
								 , NU_SERIE_NOTA_FISCAL
								 , NU_ORCAMENTO
								 , DT_ENTREGA
								 , NU_ARMAZEM
								 , DT_FATURAMENTO
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".$rowTotvsSC6010['C6_FILIAL']."' 
							     , '".$rowTotvsSC6010['C6_NUM']."'
								 , '".$rowTotvsSC6010['C6_ITEM']."'
								 , '".$rowTotvsSC6010['C6_PRODUTO']."'
								 , '".$rowTotvsSC6010['C6_UM']."'
								 , '".$rowTotvsSC6010['C6_QTDVEN']."'
								 , '".$rowTotvsSC6010['C6_QTDLIB']."'
								 , '".$rowTotvsSC6010['C6_QTDENT']."'
								 , '".$rowTotvsSC6010['C6_PRCVEN']."'
								 , '".$rowTotvsSC6010['C6_VALDESC']."'
								 , '".$rowTotvsSC6010['C6_DESCONT']."'
								 , '".$rowTotvsSC6010['C6_VALOR']."'
								 , '".$rowTotvsSC6010['C6_TES']."'
								 , '".$rowTotvsSC6010['C6_CF']."'
								 , '".$rowTotvsSC6010['C6_MOTAT']."'
								 , '".$rowTotvsSC6010['C6_PROORI']."'
								 , '".$rowTotvsSC6010['C6_NOTA']."'
								 , '".$rowTotvsSC6010['C6_SERIE']."'
								 , '".$rowTotvsSC6010['C6_NUMORC']."'
								 , '".$rowTotvsSC6010['C6_ENTREG']."'
								 , '".$rowTotvsSC6010['C6_LOCAL']."'
								 , '".$rowTotvsSC6010['C6_DATFAT']."'
								 , '".$rowTotvsSC6010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
							
			}else{
				
				mysql_query("INSERT INTO tb_fat_pedido_venda_item (CO_FILIAL
							     , NU_PEDIDO_VENDA
								 , NU_ITEM
								 , CO_PRODUTO
								 , TP_UNIDADE
								 , QTD_PRODUTO
								 , QTD_LIBERADA
								 , QTD_ENTREGA
								 , VL_PRODUTO
								 , VL_DESCONTO
								 , PER_DESCONTO
								 , VL_TOTAL
								 , NU_TES
								 , NU_CFOP
								 , TP_MOTIVO_AT
								 , CO_PRODUTO_AT
								 , NU_NOTA_FISCAL
								 , NU_SERIE_NOTA_FISCAL
								 , NU_ORCAMENTO
								 , DT_ENTREGA
								 , NU_ARMAZEM
								 , DT_FATURAMENTO
								 , CO_RECNO)
							 VALUES('".$rowTotvsSC6010['C6_FILIAL']."' 
							     , '".$rowTotvsSC6010['C6_NUM']."'
								 , '".$rowTotvsSC6010['C6_ITEM']."'
								 , '".$rowTotvsSC6010['C6_PRODUTO']."'
								 , '".$rowTotvsSC6010['C6_UM']."'
								 , '".$rowTotvsSC6010['C6_QTDVEN']."'
								 , '".$rowTotvsSC6010['C6_QTDLIB']."'
								 , '".$rowTotvsSC6010['C6_QTDENT']."'
								 , '".$rowTotvsSC6010['C6_PRCVEN']."'
								 , '".$rowTotvsSC6010['C6_VALDESC']."'
								 , '".$rowTotvsSC6010['C6_DESCONT']."'
								 , '".$rowTotvsSC6010['C6_VALOR']."'
								 , '".$rowTotvsSC6010['C6_TES']."'
								 , '".$rowTotvsSC6010['C6_CF']."'
								 , '".$rowTotvsSC6010['C6_MOTAT']."'
								 , '".$rowTotvsSC6010['C6_PROORI']."'
								 , '".$rowTotvsSC6010['C6_NOTA']."'
								 , '".$rowTotvsSC6010['C6_SERIE']."'
								 , '".$rowTotvsSC6010['C6_NUMORC']."'
								 , '".$rowTotvsSC6010['C6_ENTREG']."'
								 , '".$rowTotvsSC6010['C6_LOCAL']."'
								 , '".$rowTotvsSC6010['C6_DATFAT']."'
								 , '".$rowTotvsSC6010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
																 
			}
			
		}else{
			
			if(trim($rowTotvsSC6010['D_E_L_E_T_']) == '*'){
				
				mysql_query("UPDATE tb_fat_pedido_venda_item SET
					             CO_FILIAL              = '".$rowTotvsSC6010['C6_FILIAL']."' 
								 , NU_PEDIDO_VENDA      = '".$rowTotvsSC6010['C6_NUM']."'
								 , NU_ITEM              = '".$rowTotvsSC6010['C6_ITEM']."'
								 , CO_PRODUTO           = '".$rowTotvsSC6010['C6_PRODUTO']."'
								 , TP_UNIDADE           = '".$rowTotvsSC6010['C6_UM']."'
								 , QTD_PRODUTO          = '".$rowTotvsSC6010['C6_QTDVEN']."'
								 , QTD_LIBERADA         = '".$rowTotvsSC6010['C6_QTDLIB']."'
								 , QTD_ENTREGA          = '".$rowTotvsSC6010['C6_QTDENT']."'
								 , VL_PRODUTO           = '".$rowTotvsSC6010['C6_PRCVEN']."'
								 , VL_DESCONTO          = '".$rowTotvsSC6010['C6_VALDESC']."'
								 , PER_DESCONTO         = '".$rowTotvsSC6010['C6_DESCONT']."'
								 , VL_TOTAL             = '".$rowTotvsSC6010['C6_VALOR']."'
								 , NU_TES               = '".$rowTotvsSC6010['C6_TES']."'
								 , NU_CFOP              = '".$rowTotvsSC6010['C6_CF']."'
								 , TP_MOTIVO_AT         = '".$rowTotvsSC6010['C6_MOTAT']."'
								 , CO_PRODUTO_AT        = '".$rowTotvsSC6010['C6_PROORI']."'
								 , NU_NOTA_FISCAL       = '".$rowTotvsSC6010['C6_NOTA']."'
								 , NU_SERIE_NOTA_FISCAL = '".$rowTotvsSC6010['C6_SERIE']."'
								 , NU_ORCAMENTO         = '".$rowTotvsSC6010['C6_NUMORC']."'
								 , DT_ENTREGA           = '".$rowTotvsSC6010['C6_ENTREG']."'
								 , NU_ARMAZEM           = '".$rowTotvsSC6010['C6_LOCAL']."'
								 , DT_FATURAMENTO       = '".$rowTotvsSC6010['C6_DATFAT']."'
								 , FL_DELET   			= '*'
							 WHERE CO_RECNO = '".$rowTotvsSC6010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
											
			}else{
				
				mysql_query("UPDATE tb_fat_pedido_venda_item SET
					             CO_FILIAL              = '".$rowTotvsSC6010['C6_FILIAL']."' 
								 , NU_PEDIDO_VENDA      = '".$rowTotvsSC6010['C6_NUM']."'
								 , NU_ITEM              = '".$rowTotvsSC6010['C6_ITEM']."'
								 , CO_PRODUTO           = '".$rowTotvsSC6010['C6_PRODUTO']."'
								 , TP_UNIDADE           = '".$rowTotvsSC6010['C6_UM']."'
								 , QTD_PRODUTO          = '".$rowTotvsSC6010['C6_QTDVEN']."'
								 , QTD_LIBERADA         = '".$rowTotvsSC6010['C6_QTDLIB']."'
								 , QTD_ENTREGA          = '".$rowTotvsSC6010['C6_QTDENT']."'
								 , VL_PRODUTO           = '".$rowTotvsSC6010['C6_PRCVEN']."'
								 , VL_DESCONTO          = '".$rowTotvsSC6010['C6_VALDESC']."'
								 , PER_DESCONTO         = '".$rowTotvsSC6010['C6_DESCONT']."'
								 , VL_TOTAL             = '".$rowTotvsSC6010['C6_VALOR']."'
								 , NU_TES               = '".$rowTotvsSC6010['C6_TES']."'
								 , NU_CFOP              = '".$rowTotvsSC6010['C6_CF']."'
								 , TP_MOTIVO_AT         = '".$rowTotvsSC6010['C6_MOTAT']."'
								 , CO_PRODUTO_AT        = '".$rowTotvsSC6010['C6_PROORI']."'
								 , NU_NOTA_FISCAL       = '".$rowTotvsSC6010['C6_NOTA']."'
								 , NU_SERIE_NOTA_FISCAL = '".$rowTotvsSC6010['C6_SERIE']."'
								 , NU_ORCAMENTO         = '".$rowTotvsSC6010['C6_NUMORC']."'
								 , DT_ENTREGA           = '".$rowTotvsSC6010['C6_ENTREG']."'
								 , NU_ARMAZEM           = '".$rowTotvsSC6010['C6_LOCAL']."'
								 , DT_FATURAMENTO       = '".$rowTotvsSC6010['C6_DATFAT']."'
							 WHERE CO_RECNO = '".$rowTotvsSC6010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
						
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>