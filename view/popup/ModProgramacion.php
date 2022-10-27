<?php 	
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);	

	$NROPROG = $_GET['NROPROG'];	
	$COST = $_GET['cost'];	
	$CARGO = $_GET['cargo'];	

	require '../../Funciones/funcionalidades.php';	
	$Func = new Funciones;	
	session_start();	
	$usu = $_SESSION['usuario'];	
	$ConsMod = $Func->ProgModifacion($NROPROG);	
	$count = 1;	
?>	
<!DOCTYPE html>	
<html lang="en">	
<head>	
    <meta charset="utf-8" />	
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />	
    <meta name="description" content="Plataforma de capacitaciones para Gestion Humana" />	
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 	
    <meta name="author" content="José Luis Casilimas Martinez" />	
    <title>Plataforma de Capacitaciones</title> 	
    <link rel="icon" type="image/x-icon" href="../assets/Icono.ico" /> 	
    <link href="../../css/styles.css" rel="stylesheet" />	

	<style>	

		.selectProg{	
			width:100%;	
			height:38px;	
			border: 1px solid #D5D5D5;	
			border-radius: 4px;	
		}	

		.formAsis{	
			margin:10px 30px;	
			color: #FFFFFF;	
			border: 1px solid #FFFFFF;	
			text-transform: capitalize;	
			font-size: 0.950rem;	
		}	

		.formAsis:disabled{	
			margin:10px 30px;	
			border: 1px solid #FFFFFF;	
			background-color: #198754;	
			color: #FFFFFF;	
			text-transform: capitalize;	
			font-size: 0.950rem;	
		}	
	</style>	

</head>	

<nav class="navbar navbar-expand-lg navbar-dark bg-success">	
	<div class="container">	
		<center><a class="navbar-brand">Modificación de la programación</a></center>	
	</div>	
</nav> 	

<form autocomplete="off" method="POST" class="form-register" action="../../Funciones/ModProgrCamb.php">	
	<div class="container">	
	    <div class="text-right mt-5">	
			<div class="row">	

				<div class="col-md-3">	
    				<div class="form-group">	
    					<label>Año</label>	

    				</div>						
				</div>	

				<div class="col-md-3">	
    				<div class="form-group">	
        				<input id="input1" name="Anio" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Anio') ?>" required>	
    				</div>						
				</div>	

				<div class="col-md-3">	
    				<div class="form-group">	
    					<label>Mes</label>	

    				</div>						
				</div>	

				<div class="col-md-3">	
    				<div class="form-group">	
        				<input id="input2" name="Mes" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Mes') ?>" required>	
    				</div>						
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-3">	
    				<div class="form-group">	
    					<label>Capacitacion</label>	

    				</div>						
				</div>	

				<div class="col-md-9">	
    				<div class="form-group">	
        				<input id="input3" name="Capacitacion" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'CAPACITACION') ?>" required>	
    				</div>						
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<label>Capacitador</label>	
    				</div>						
				</div>	

				<div class="col-md-3">	
    				<div class="form-group">	
        				<input id="input4" name="CAPACITADOR" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CAPACITADOR') ?>" required>	
    				</div>						
				</div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<label>Asistentes programados</label>	
					</div>						
				</div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<input id="cantidadAsis" name="CANTPROGRAMADOS" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CANTIDADPROG') ?>">	
					</div>						
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<label>Categoria</label>	
					</div>						
				</div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<select id="input5" class="nput-group-text selectProg saveInputs" name="categoriaCap" required>	
							<option value="<?php echo odbc_result($ConsMod, 'ID2') ?>"><?php echo utf8_encode(odbc_result($ConsMod, 'CATEGORIA')) ?></option>	
							<?php 	
							foreach ($Func->ListSelectProgra('1') as $a){	
                                echo '<option value="'.utf8_encode($a['ID']).'">'.utf8_encode($a['OPCION']).'</option>'; 	
	                        } ?>	
						</select>	
					</div>	
				</div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<label>Tipo</label>	
					</div>						
				</div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<select id="input6" class="nput-group-text selectProg saveInputs" name="temaCap" required>	
							<option value="<?php echo odbc_result($ConsMod, 'ID1') ?>"><?php echo utf8_encode(odbc_result($ConsMod, 'SUPTIPO')) ?></option>	
							<?php 	
							foreach ($Func->ListSelectProgra('2') as $a){	
                                echo '<option value="'.utf8_encode($a['ID']).'">'.utf8_encode($a['OPCION']).'</option>'; 	
	                        } ?>	
						</select>	
					</div>	
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-3">	
    				<div class="form-group">	
    					<label>Link Drive</label>	
    				</div>						
				</div>	

				<div class="col-md-9">	
    				<div class="form-group">	
        				<input id="input3" name="linkDrive" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Bitacora') ?>">	
    				</div>						
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-3">	
					<div class="form-group">	
						<label>Buscar por centro de costo y cargo</label>	
					</div>						
				</div>	

				<div class="col-md-4">	
					<select id="selectCosto" class="nput-group-text selectProg saveInputs saveInputs">	
						<option value="">Selecciona el costo mayor</option>	
						<?php 	
						foreach ($Func->ListCostosMayor() as $a){	
                             echo '<option value="'.$a['CentroMayor'].'">'.$a['NOMBRE'].'</option>'; 	
	                     } ?>	
					</select>				
				</div>	

				<div class="col-md-5">	
					<select id="selectCargo" class="nput-group-text selectProg saveInputs">	
						<option value="">Selecciona el cargo</option>	
						<?php 	
						foreach ($Func->ListCargo($COST) as $a){	
                             echo '<option value="'.$a['CODCARGO'].'">'.$a['CARGO'].'</option>'; 	
	                    } ?>	
					</select>	
				</div>	

				<div id="inputsAsis" class="container" style="padding:30px"><div>	

				<input type="hidden" name="USER" value="<?php echo $usu?>">	
				<input id="countChecks" type="hidden" name="CANTUSERSELECT">	
			</div>	
		</div>	
	</div>	

	<?php 	

		foreach($Func->ListEMPL($CARGO) as $em){	
			echo '<div class="row veriInputs">	
				<div class="form-check">	
					<input id="check'.$count.'" class="form-check-input check" type="checkbox" value="'.$em['CODIGO'].'" name="" style="position: relative; top: 42px">	
		  		</div>	
		  	
				<input class="col-2 form-control formAsis" type="text" placeholder="codigo" style="width: 10%" value="'.$em['CODIGO'].'" disabled>		
				<input class="col-2 form-control formAsis" type="text" style="width: 30%" value="'.utf8_encode($em['NOMBRE']).'" disabled>		
				<input class="col-2 form-control formAsis" type="text" style="width: 30%" value="'.utf8_encode($em['CARGOEMP']).'" disabled>		
				<select class="col-2 nput-group-text formAsis tipoAsist tipoInvitacion'.$count.'" name="tipoInvitacion'.$count.'" style= "width: 10%">	
					<option value="">Invitacion</option>	
					<option value="1">obligatorio</option>	
					<option value="2">no obligatorio</option>	
				</select>		
			</div>';	
		$count++;	
	}?>	

	<div class="col-md-12">	
		<input type="hidden" name="NROPROG" value="<?php echo $NROPROG ?>">	
		<center><input name="ModPramacion" style="width: 100%; margin:60px 0px" class="btn btn-success" type="submit" value="¡Modificar!"/></center>	
	</div>	
</form>	

<script>	
	let selectCosto = document.getElementById('selectCosto');	
	let selectCargo = document.getElementById('selectCargo');	
	let inputCantidad = document.getElementById('cantidadAsis');	
	let inputs = document.getElementById('inputsAsis');	
	let veriInputs = document.querySelectorAll('.veriInputs');	
	let saveInputs = document.querySelectorAll('.saveInputs');	
	let checks = document.querySelectorAll('.check');	
	let tipoAsist = document.querySelectorAll('.tipoAsist');	

	selectCosto.addEventListener("change" , function(e){	
		window.location.href = window.location.href + "&cost=" + e.target.value; 	
	})	

	selectCargo.addEventListener("change" , function(e){	
		window.location.href = window.location.href + "&cargo=" + e.target.value; 	
	})	

	window.addEventListener("load", function () {	
		let persona = JSON.parse(localStorage.getItem('dataInputs'));	

		persona.forEach((values) => {	
			document.getElementById("input1").value = values.guardarAño;	
			document.getElementById("input2").value = values.guardarMes;	
			document.getElementById("input3").value = values.guardarCapacitacion;	
			document.getElementById("input4").value = values.guardarCodCapacitador;	
			document.getElementById("input5").value = values.guardarCategoria;	
			document.getElementById("input6").value = values.guardarTema;	
			document.getElementById("cantidadAsis").value = values.guardarCantAsist;	
			document.getElementById("selectCosto").value = values.guardarCosto;	
			document.getElementById("selectCargo").value = values.guardarCargo;	
		})	
	})	

	saveInputs.forEach((input) => {	
		let id = input.id;	
		input.addEventListener("change" , function(e){	
			let año = document.getElementById("input1").value;	
			let mes = document.getElementById("input2").value;	
			let capacitacion = document.getElementById("input3").value;	
			let codCapacitador = document.getElementById("input4").value;	
			let categoria = document.getElementById("input5").value;	
			let tema = document.getElementById("input6").value;	
			let cantAsist = document.getElementById("cantidadAsis").value;	
			let costo = document.getElementById("selectCosto").value;	
			let cargo = document.getElementById("selectCargo").value;	

			let dataInputs = [{	
				guardarAño: año,	
				guardarMes: mes,	
				guardarCapacitacion: capacitacion,	
				guardarCodCapacitador: codCapacitador,	
				guardarCategoria: categoria,	
				guardarTema: tema,	
				guardarCantAsist: cantAsist,	
				guardarCosto: costo,	
				guardarCargo: cargo,	
			}];	

			localStorage.setItem('dataInputs', JSON.stringify(dataInputs));	
		})	
	})	

	let cont2 = 0; 	

	checks.forEach((inputCheck) => {	
		let id = inputCheck.id;	
		inputCheck.addEventListener("change", function(e){	

			if (inputCheck.checked) {	
				cont2 = cont2 + 1;	
			} else {	
				cont2 = cont2 - 1;	
			}	

			document.getElementById(`${id}`).name = `checks${cont2}`;	
			document.getElementById("countChecks").value = cont2;	
		});	
	})	

	tipoAsist.forEach((tipo) => {	
		let name = tipo.name;	
		document.querySelector(`.${name}`).style.background = "red";	

		tipo.addEventListener("change", function(e){	
			if ((e.target.value == '2') || (e.target.value == '1')) {	
				document.querySelector(`.${name}`).style.background = "#198754";	
			}	
		});	
	})	
</script>	 