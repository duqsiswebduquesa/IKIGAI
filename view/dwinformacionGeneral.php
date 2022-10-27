<?php	
header('Content-Type: text/html; charset=UTF-8');
session_start();	
 error_reporting(0);	
if (isset($_SESSION['usuario'])) {	
    require 'header.php'; 	
    require 'footer.php';	
    require '../Funciones/funcionalidades.php';	
    $Func = new Funciones;	
	$Cuerpo = "";	
	$est = 0 ;  	

    if (isset($_GET['Verprog'])) {	
		$est ++ ;  	
		$Anio = $_GET['Anio'];	

		$Trimestre = $_GET['Trimestre'];	
		$ValTris = ($Trimestre == 13) ? 'No elige': $Trimestre;	

		$COSTOCC = $_GET['Costo'];	
		$ValCODCC =  ($COSTOCC == NULL) ? 'No elige': $COSTOCC;	

		$Sexo = $_GET['Sexo'];	
		$ValSex = ($Sexo == null) ? 'No elige': $Sexo;	

		$CODIGO = $_GET['Cargo'];	
		$ValCarg = ($CODIGO == null) ? 'No elige' : $CODIGO ;	

		$Categoria = $_GET['Cap'];	
		$ValCat = ($Categoria == null) ? 'No elige' : $Categoria ;	

		$Subtipo = $_GET['Tema'];	
		$ValTipo = ($Subtipo == null) ? 'No elige' : $Subtipo;

		$Cuerpo = '<li class="list-group-item list-group-item"><strong>Consulta año:</strong> '.$Anio.'</li>';  	
		$Vertris = '<li class="list-group-item list-group-item"><strong>Trimestre:</strong> '.$ValTris.'</li>';  	
		$VerCodcc = '<li class="list-group-item list-group-item"><strong>CC Mayor:</strong> '.$ValCODCC.'</li>';   	
		$VerSex = '<li class="list-group-item list-group-item"><strong>Sexo:</strong> '.$ValSex.'</li>';   	
		$VerCarg = '<li class="list-group-item list-group-item"><strong>Cargo:</strong> '.$ValCarg.'</li>';   	
		$VerCat = '<li class="list-group-item list-group-item"><strong>Tipo:</strong> '.$ValCat.'</li>';   	
		$VerTipo ='<li class="list-group-item list-group-item"><strong>Tema:</strong> '.$ValTipo.'</li>';   			
	} 	

?>	

<div class="container">	
    <div class="text-right mt-3">	
		<div class="row">	
		    <div class="col-md-12">	
		    	<ul class="list-group list-group-horizontal">	
					<a style="text-decoration:none" href="index.php"><li class="list-group-item list-group-item-success">Menú principal</li></a>	
					<a style="text-decoration:none" href="dwprogramacion.php"><li class="list-group-item list-group-item-success">Seleccione la programación</li></a>	
				</ul>	
			</div> 	
		</div>	
	</div>	
</div>	

<div class="container">	
    <div class="text-right mt-3">	
		<div class="row">	
		    <div class="col-md-12">	
		    	<ul class="list-group list-group-horizontal">	
				<?php echo $Cuerpo ?> 				  	
					<?php echo $Vertris ?> 				  	
					<?php echo $VerCodcc ?>  			  	
					<?php echo $VerSex ?>	
					<?php echo $VerCarg ?>	
					<?php echo $VerCat ?> 	
					<?php echo $VerTipo ?> 	
				</ul>	
			</div> 	
		</div>	
	</div>	
</div>	



<form method="GET">	
    <div class="container">	
        <div class="text-right mt-3">	
            <div class="row">  	

                <div class="col-md-3">	
					<label>Año</label>	
                    <div class="form-group">               	
						<select list="Anio" class="form-control" type="text" name="Anio" required>	
							<?php for ($i=2022; $i <= Date("Y"); $i++) { 	
								echo '<option value="'.$i.'">'.$i.'</option>'; 	
							} ?>	
						</select>	
                    </div> 	
                </div>	

                <div class="col-md-3">	
					<label>Trimestre</label>	
                    <div class="form-group">	
                       <select list="Trimestre" class="form-control" type="text" name="Trimestre" placeholder="Seleccione el trimestre"  required>	
                            <option value="13">Seleccione el trimestre</option>	
							<option value="1">Trimestre 1</option> 	
							<option value="2">Trimestre 2</option> 	
							<option value="3">Trimestre 3</option>   	
							<option value="4">Trimestre 4</option>  	
                        </select>	
                    </div> 	
                </div>	

				<div class="col-md-3">	
					<label>Centro de Costo</label>	
                    <div class="form-group">	
                       <select list="Mes" class="form-control" type="text" name="Costo" placeholder="Seleccione el Centro de Costo">	
					   <option value="">Selecciona el Centro de Costo</option>	
								<?php foreach ($Func->ListCostosMayor() as $a){	
                             		echo '<option value="'.$a['CentroMayor'].'">'.$a['NOMBRE'].'</option>'; 	
	                   			} ?>	
                        </select>	
                    </div> 	
                </div>	

				<div class="col-md-3">	
					<label>Sexo</label>	
                    <div class="form-group">	
                       <select list="Sexo" class="form-control" type="text" name="Sexo">	
							<option value="">Selecciona el genero</option> 	
							<option value="F">Mujer</option> 	
							<option value="M">Hombre</option>								
							<option value="O">Otro</option>  	
                        </select>	
                    </div> 	
                </div>	

				<div class="col-md-12"><br></div>	

				<div class="col-md-4">	
					<label>Cargo</label>	
                    <div class="form-group">	
                       <select list="Mes" class="form-control" type="text" name="Cargo" placeholder="Seleccione el Cargo">	
                            <option value="">Seleccione el Cargo</option>  	
							<?php 	
						foreach ($Func->ListCargo($COSTOCC) as $a){	
							echo '<option value="'.$a['CODCARGO'].'">'.$a['CARGO'].'</option>'; 	
	                    } ?>	
                        </select>	
                    </div> 	
                </div>	

				<div class="col-md-4">	
					<label>Tipo</label>	
                    <div class="form-group">	
                       <select list="Mes" class="form-control" type="text" name="Cap" placeholder="Seleccione el Tipo">	
                            <option value="">Seleccione el Tipo de Capacitacion</option>  	
							<?php 	
						foreach ($Func->ListSelectProgra('1') as $a){	
							echo '<option value="'.utf8_encode($a['ID']).'">'.utf8_encode($a['OPCION']).'</option>'; 	
						} ?>	
                        </select>	
                    </div> 	
                </div>	

				<div class="col-md-4">	
					<label>Tema</label>	
                    <div class="form-group">	
                       <select list="Tema" class="form-control" type="text" name="Tema" placeholder="Seleccione el Tema">	
                            <option value="">Seleccione el Tema</option>  	
							<?php 	
						foreach ($Func->ListSelectProgra('2') as $a){	
							echo '<option value="'.utf8_encode($a['ID']).'">'.utf8_encode($a['OPCION']).'</option>'; 	
						} ?>	
                        </select>	
                    </div> 	
                </div>	

				<div class="col-md-12"><br></div>	

                <div class="col-md-12">	
                    <center><input name="Verprog" style="width: 100%" class="btn btn-success" type="submit" value="¡Cargar Información!"/></center>	
                </div> 	
    	 	</div>	
    	 </div>	
    </div>	
</form>	

<?php if ($est == 1): ?> 	
<div class="container">	
	<div class="text-right mt-4">	
	<div class="row">	
	<div class="col-md-12">	
	<table class="table table-bordered" cellspacing="0">  	
					<thead>	
						<tr align="center" bgcolor="#198754">	
							<td><strong><font color="white">ID</strong></font></td> 	
							<td><strong><font color="white">Año</strong></font></td> 	
							<td><strong><font color="white">Mes</strong></font></td> 	
							<td><strong><font color="white">Tipo formacion</strong></font></td>  	
							<td><strong><font color="white">Cumpl. Legal</strong></font></td> 	
							<td><strong><font color="white">Capacitación</strong></font></td>  	
							<td><strong><font color="white">Categoria</strong></font></td>  	
							<td><strong><font color="white">Subtipo</strong></font></td>  	
							<td><strong><font color="white">N Personas</strong></font></td>  	
							<td><strong><font color="white">Costo Total</strong></font></td> 	
							<td><strong><font color="white">VER</strong></font></td> 	
						</tr>	
					</thead> 	
					<tbody>	
						<?php 	
						 foreach ($Func->ListCapCompletasTrim($Anio, $Trimestre, $CODIGO, $Categoria, $Subtipo, $Sexo, $COSTOCC) as $a) {	
							
							echo "<tr>	
								<td align='center'>".$a['NROPROG']."</td>	
								<td align='center'>".$a['ANIO']."</td>	
								<td align='center'>".$Func->ListMeses(2, $a['MES'])."</td>	
								<td align='center'>".$a['TFORM']."</td> 	
								<td align='center'>".$a['Cumpleg']."</td>	
								<td align='center'>".utf8_encode($a['CAPACITACION'])."</td> 	
								<td align='center'>".utf8_encode($a['NCategoria'])."</td> 	
								<td align='center'>".utf8_encode($a['NSubtipo'])."</td> 	
								<td align='right'>".number_format($a['CANTIDADASIS'], 0)."</td>	
								<td align='right'>$".number_format($a['PRECIO'], 0, ',', '.')."</td>	
								<td align='right'>	
									<form action='popup/VerInfoEmpleadoCapGeneral.php' target='_blank' onsubmit='window.open('popup/VerInfoEmpleadoCapGeneral.php', 'popup','width=1600,height=1600,scrollbars=no,resizable=no')' method='POST'>	
										<input type='hidden' name='NROPROG' value='".$a['NROPROG']."'>	
										<input name='Download' style='width: 100%'' class='btn btn-success' type='submit' value='VER'/></center>	
									</form>	
								</td>	
							</tr>";	
						}  ?>	
					</tbody>	
				</table>                                                               	
			    </div>	
			</div>	
		</div>	
	</div>	
		</div>	
	</div>	
	</div>	
	</div>	

<?php endif ?>	

<?php }else{ 	
?><script languaje "JavaScript">	
    alert("Acceso Incorrecto");	
    window.location.href="../login.php"; 	
</script><?php 	
}	 