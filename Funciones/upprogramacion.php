<?php	
session_start();	
if (isset($_SESSION['usuario'])) {	
	include("con_palmerdb.php");	
	if (isset($_POST['EnviarDocumento'])) {	
		$exito=0;	
		$usu = $_SESSION['usuario'];	
		$Comprobante = $_FILES['archivo'];	

		$Serial = "SELECT ISNULL(MAX(P.NROPROG), 0)+1 AS SERIAL FROM PLATCAPACITACIONES.dbo.Programacion P";	
		$reslt=odbc_exec($conexion, $Serial);	
		$Ser = odbc_result($reslt, 'SERIAL');	

		$NroProg = $Ser;	

		$Documento=$Comprobante['name'];	
	    $tmpimagen=$Comprobante['tmp_name'];	
	    $extimagen= pathinfo($Documento);	

	    if($Comprobante['error'] > 0){         	
	        $Estado = 0;  	
	    }else{ 	
		    $permitidos = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");	
		    $limite_kb = 5000;	

		        if (in_array($Comprobante['type'], $permitidos) && $Comprobante['size'] <= $limite_kb * 1024 ){	

		        $ruta_a = "../Documentos/Programacion/".$Ser."/"; 	
		        $ruta_dcto = $ruta_a.$Comprobante['name']; 	

		        if(!file_exists($ruta_a)){	
			        mkdir($ruta_a); 	
		        }	

		        if(!file_exists($ruta_dcto)){	
		        $resultado_a = @move_uploaded_file($Comprobante['tmp_name'], $ruta_dcto); 	

		            if($resultado_a){	
		            	require '../PHPExcel/Classes/PHPExcel/IOFactory.php';	
		                $nombreArchivo = $ruta_dcto;	
						$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);	
						$objPHPExcel->setActiveSheetIndex(0);	
						$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 	
						for($i = 3; $i <= $numRows; $i++){					

							$TFORM = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();	
							$CAPAC = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue(); 	
							$CADOR = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue(); 	
							$CANTPROG  = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 	
							$ANIO  = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue(); 	
							$MES   = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(); 	
							$LEGL  = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue(); 	

							if ($TFORM != NULL AND $CAPAC != NULL) {	
			                	$QryPrg="INSERT INTO PLATCAPACITACIONES.dbo.Programacion (ID, NROPROG, TFORM, CAPACITACION, CAPACITADOR, ANIO, MES, USUARIO, FECCARGA, ESTADO, PRECIO, CANTIDADASIS, CUMPLEGAL,CATEGORIA, SUBTIPO,CANTIDADPROG)
								VALUES ('$Ser', '$NroProg', '$TFORM', '$CAPAC', '$CADOR', '$ANIO', '$MES', '$usu', GETDATE(), 0, 0, 0, '$LEGL', null, null, $CANTPROG)
								UPDATE PLATCAPACITACIONES.dbo.Programacion SET FECHA = CONVERT(VARCHAR,CONCAT(ANIO,'-',MES,'-01'),23) WHERE NROPROG = '$NroProg'";	
			                	$Dato=odbc_exec($conexion, $QryPrg);	
								if ($Dato) {  	
			                	 	$NroProg++;	
				                }	
				                echo "<br>";	
							}	

			            }	
			        	?><script languaje="javascript">	
				            window.location="../view/upinformacion.php";	
				            alert("¡Se cargo con exito la programación!");	
				        </script><?php	
		            }else{	
		                ?><script languaje="javascript">	
				            window.location="../view/upinformacion.php";	
				            alert("¡Hubo un error!");	
				        </script><?php	
		            }	
		        }else{	
		            ?><script languaje="javascript">	
			            window.location="../view/upinformacion.php";	
			            alert("¡Hubo un error!");	
			        </script><?php	
		        } 	
		    }else{	
		    	?><script languaje="javascript">	
		            window.location="../view/upinformacion.php";	
		            alert("¡Por favor, suba un archivo valido (Excel)!");	
		        </script><?php	
		    }	
		} // Cierre de las validaciones 0	
	}	

}else{ 	
    ?><script languaje "JavaScript">	
        alert("Acceso Incorrecto");	
        window.location.href="../login.php"; 	
    </script><?php 	
} // Cierre de Validacion de Inicio de sesion	
