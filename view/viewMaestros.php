<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if (isset($_SESSION['usuario'])) {

    require 'header.php'; 
    require 'footer.php';
    require '../Funciones/funcionalidades.php';
    $Func = new Funciones;

	$mesmaximo = date('Y-m');

	// filtro trimestre

	if (isset($_POST['Filtro'])) {
		$Anio = $_POST['Anio'];
		$TriActual = $_POST['Trimestre'];
	}else{
		$Anio = Date("Y");
		$MesActual = Date("m");
			if ($MesActual >= 1 AND $MesActual <= 3) {
				$TriActual = 1;
			}elseif($MesActual >= 4 AND $MesActual <= 6){
				$TriActual = 2;
			}elseif($MesActual >= 7 AND $MesActual <= 9){
				$TriActual = 3;
			}elseif ($MesActual >= 10 AND $MesActual <= 12) {
				$TriActual = 4;
			}	
	}

	if ($TriActual == 1) {
		$Mensaje = "Primer trimestre.";
	}elseif ($TriActual == 2) {
		$Mensaje = "Segundo trimestre.";
	}elseif ($TriActual == 3) {
		$Mensaje = "Tercer trimestre.";
	}elseif ($TriActual == 4) {
		$Mensaje = "Cuarto trimestre.";
	}

	$Ejec = $Func->NumCapact(1, $TriActual, $Anio);
	$Prog = $Func->NumCapact(0, $TriActual, $Anio);
	$Total = $Ejec + $Prog;
	$Val = ($Total == 0 OR $Ejec == 0) ? $Cump = 0 : $Cump = ($Ejec/$Total)*100 ; 

	$Barras = $Func->DetalleCentroMayor($Anio, $TriActual);  

	//filtro por rango 

	$estilo = 'none';
	$estilo2 = 'none';

	if (isset($_POST['FiltroRangoMes'])) {
		$fecha1 = $_POST['fecha1'];
		$fecha2 = $_POST['fecha2'];

		if($fecha1 > $fecha2) {
			$FechaAlterna = $fecha1;
			$fecha1 = $fecha2;
			$fecha2 = $FechaAlterna;
		}

		if (count($Func->generarExcelProgramaciones($fecha1,$fecha2)) !== 0) {
			$Mensaje = "Se encontraron resultados, puede generar el excel";
			$estilo = 'block';
			$estilo2 = 'block';
		} else {
			$estilo2 = 'block';
			$Mensaje = "Sin resultados";
		}
	}
?>

<style>
	.table-containter{ max-width: 100%; max-height: 400px; overflow-x: scroll; }  
</style>

<div class="container">
    <div class="text-right mt-3">
		<div class="row">
		    <div class="col-md-12">
		    	<ul class="list-group list-group-horizontal">
				  <a style="text-decoration:none" href="index.php"><li class="list-group-item list-group-item-success">Menú principal</li></a>
				  <a style="text-decoration:none" href="maestros.php"><li class="list-group-item list-group-item-success">Maestros</li></a>
				  <li class="list-group-item list-group-item-success">Ver áreas</li>
				  <li class="list-group-item list-group-item"><strong><?php echo $Mensaje; ?></strong></li>
				</ul>
			</div> 
		</div>
	</div>
</div> 

<form method="POST">
	<div class="container">
	    <div class="text-right mt-3">
	    	<div class="row">
	    		<div class="col-md-3" align="center">Seleccione el trimestre</div>

	    		<div class="col-md-3">
	    			<div class="form-group">
	            		<select list="Anio" class="form-control" type="text" name="Anio" required>
	                    <?php for ($i=2022; $i <= Date("Y"); $i++) { 
	                        echo '<option value="'.$i.'">'.$i.'</option>'; 
	                    } ?>
	                	</select>
	                </div> 
	    		</div>

	    		<div class="col-md-4">
	    			<select list="Trimestre" class="form-control" name="Trimestre" required>
	                 	<option></option> 
	                 	<option value="1">Primer trimestre</option> 
	                 	<option value="2">Segundo trimestre</option> 
	                 	<option value="3">Tercer trimestre</option> 
	                 	<option value="4">Cuarto trimestre</option> 
	            	</select>
	    		</div>

	    		<div class="col-md-2">
                	<center><input name="Filtro" style="width: 100%" class="btn btn-success" type="submit" value="Filtrar"/></center>
	    		</div>
	    	</div>
		</div>
	</div>
</form>
<div class="container">
    <div class="text-right mt-3">
			<table class="table table-bordered" cellspacing="0">  
				<thead>
					<tr align="center" bgcolor="#198754"> 
						<td style='width: 25%'><strong><font color="white">Progamadas</strong></font></td>
						<td style='width: 25%'><strong><font color="white">Ejecutadas</strong></font></td>
						<td style='width: 25%'><strong><font color="white">Restantes</strong></font></td>
						<td style='width: 25%'><strong><font color="white">Cumplimiento</strong></font></td>
					</tr>
				</thead>
				<tbody>
		            <tr>
						<td style='width: 25%' align='right'><?php echo number_format($Total, 0) ?></td>
						<td style='width: 25%' align='right'><?php echo number_format($Ejec, 0) ?></td>
						<td style='width: 25%' align='right'><?php echo number_format($Prog, 0) ?></td>
						<td style='width: 25%' align='right'><?php echo number_format(round($Cump, 2), 2) ?>%</td>
					</tr>
		        </tbody>
			</table>
		</div>
	</div>
</div>

<form method="POST">
<div class="container">
    <div class="text-right mt-3">
    	<div class="row">
    		<div class="col-md-6">
				<div align="center" id="piechart" style="width: 100%; height: 400px;"></div> 
    		</div>

    		<script>
    			var DatoJST=<?php echo json_encode($Barras); ?> 

				google.charts.load('current', {'packages':['bar']});
			  	google.charts.setOnLoadCallback(drawChart);

			  	function drawChart() {
			    	var data = google.visualization.arrayToDataTable(DatoJST); 
			    	var options = {
						colors: ['#198754'],
						chart: {
							title: 'Detalle de resultados de personal, por centros de costos mayor, en el <?php echo $Mensaje ?>',
							subtitle: 'Reporte generado a las <?php echo DATE("Y-m-d H:i:s") ?>',
							}
						};
				    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
				    chart.draw(data, google.charts.Bar.convertOptions(options));
			  	}
    		</script>

    		<div class="col-md-6">
				<div align="center" id="columnchart_material" style="width: 100%; height: 400px;"></div>
			</div>
    	</div>
    </div>
</div>	

<div class="text-right mt-5"></div>
<!-- Tabla de exportacion excel -->
<form method="POST">
<div class="container">
	<div class="mt-3">
	    <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<input id="fecha1" type="date" name="fecha1" class="form-control" value="<?php echo $fecha1?>"  min='2022-01-01' max='$mesmaximo' required>
				</div>		
			</div> 
			<div class="col-md-4">
				<div class="form-group">
					<input id="fecha2" type="date" name="fecha2" class="form-control" value="<?php echo $fecha2?>" min='2022-01-01' max='$mesmaximo' required>
				</div>		
			</div> 	
			<div class="col">
                <center><input name="FiltroRangoMes" style="width: 100%" class="btn btn-success" type="submit" value="BUSCAR" onclick="showBtnExcel()"/></center>
	    	</div>
		</div>		
	</div> 
</div>
</form>

<div class="text-right mt-5"></div>

<div class="container" style="display:<?php echo $estilo2?>">
    <div class="text-right mt-3">
		<div class="row">
		    <div class="col-md-12">
		    	<ul class="list-group list-group-horizontal">
				  	<li class="list-group-item list-group-item-success"><?php echo $fecha1; ?>-01</li>
				  	<li class="list-group-item list-group-item-success"><?php echo $fecha2; ?>-01</li>
				  	<li class="list-group-item list-group-item-success"><strong><?php echo $Mensaje; ?></strong></li>
				</ul>
			</div> 
		</div>
	</div>
</div>

<div class="text-right mt-5"></div>

<div class="container" style="display:<?php echo $estilo?>">
	<div class=" mt-3">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input id="nombreArchivo" type="text" class="form-control" placeholder="Nombrar archivo">
				</div>		
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<buttom id="btnExportar" style="width: 100%" class="btn btn-success">Exportar Excel</buttom>
				</div>		
			</div> 
		</div> 
	</div>		
</div> 

<div class="text-right mt-5"></div>

<div class="container" style="display:none">
	<div class="col-md-12 mt-5">
		<table id="tabla" align="center" style="width: 100%">
			<tr>
				<td bgcolor="#198754" align='center'><font color="white"><strong>N° PROGRAMACION</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>FECHA FILTRO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CAPACITACION</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CAPACITADOR</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>DESCRIPCION</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>TIPO DE FORMACION</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CUMPLIMIENTO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CATEGORIA</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>SUBTIPO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>LUGAR</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>Hora Inicio</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>Hora Final</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>Duracion</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>AÑO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>MES</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>FECHA APLICACION</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CANTIDAD PROGRAMADOS</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CANTIDAD ASISTENTES</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>GENERO FEMENINO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>GENERO MASCULINO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>BINARIO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>GENERO</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>CEDULA</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>NOTA</strong></font></td>
				<td bgcolor="#198754" align='center'><font color="white"><strong>NOMBRE COMPLETO</strong></font></td>
			</tr>
						
			<?php foreach ($Func->generarExcelProgramaciones($fecha1,$fecha2) as $a){
				echo "<tr align='center'>
					<td>".utf8_decode($a['NROPROG'])."</td>
					<td>".utf8_decode($a['FECHA'])."</td>
					<td>".utf8_decode($a['CAPACITACION'])."</td>
					<td>".utf8_decode($a['CAPACITADORNOM'])."</td>
					<td>".utf8_decode($a['DESCRIPCION'])."</td>
					<td>".utf8_decode($a['TFORM'])."</td>
					<td>".$a['Cumpleg']."</td>
					<td>".utf8_encode($a['CATEGORIA'])."</td>
					<td>".utf8_encode($a['SUBTIPO'])."</td>
					<td>".utf8_decode($a['LUGAR'])."</td>
					<td>".utf8_decode($a['HINICIO'])."</td>
					<td>".utf8_decode($a['HFINAL'])."</td>
					<td>".utf8_decode($a['DURACION'])."</td>
					<td>".utf8_decode($a['ANIO'])."</td>
					<td>".utf8_decode($a['MES'])."</td>
					<td>".utf8_decode($a['FECHAEVENT'])."</td>
					<td>".utf8_decode($a['CANTIDADPROG'])."</td>
					<td>".utf8_decode($a['CANTIDADASIS'])."</td>
					<td>".utf8_decode($a['FEMENINO'])."</td>
					<td>".utf8_decode($a['MASCULINO'])."</td>
					<td>0</td>
					<td>".utf8_decode($a['SEXO'])."</td>
					<td>".utf8_decode($a['CEDULA'])."</td>
					<td>".utf8_decode($a['APRUEBA'])."</td>
					<td>".utf8_decode($a['NOMBRE_COMPLETO'])."</td>
				</tr>";	
			} ?> 
		</table>            
	</div>
</div>

<script>
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
	   var data = google.visualization.arrayToDataTable([
          ['Tipo', 'Personas'],
          ['Ejecutadas', <?php echo $Ejec ?>],
          ['Programadas', <?php echo $Prog ?>] 
        ]);

	    var options = {
	    	title: 'Porcentaje de capacitaciones Programadas y Ejecutadas en el <?php echo $Mensaje ?>',
	    	is3D: true,

	    	colors: ['#198754', '#8DD3B2']
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		chart.draw(data, options);
	} 

	// exportar a excel
	
	const btnExportar = document.querySelector("#btnExportar");
    tabla = document.querySelector("#tabla");

    btnExportar.addEventListener("click", function() {
		let tituloArchivo = document.querySelector("#nombreArchivo").value;
        let tableExport = new TableExport(tabla, {
			exportButtons: false, // No queremos botones
            filename: tituloArchivo, //Nombre del archivo de Excel
            sheetname: "Programaciones", //Título de la hoja
        });
        let datos = tableExport.getExportData();
        let preferenciasDocumento = datos.tabla.xlsx;
        tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
	});
</script>

<!-- links para exportar a excel -->
<script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>

<?php }else{ ?>
	<script>
	    alert("Acceso Incorrecto");
	    window.location.href="../login.php"; 
	</script>
<?php }