<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);
if (isset($_SESSION['usuario'])) {
    require 'header.php'; 
    require 'footer.php';
    require '../Funciones/funcionalidades.php';
    $Func = new Funciones;

    $Anio = $_POST['Anio'];
	$Mes = $_POST['Mes'];
	// $area = $_POST['area'];
    
?>

<div class="container">
    <div class="text-right mt-4">
		<div class="row">
		    <div class="col-md-12">
		    	<ul class="list-group list-group-horizontal">
				  <a style="text-decoration:none" href="index.php"><li class="list-group-item list-group-item-success">Menú principal</li></a>
				  <li class="list-group-item list-group-item">Subir capacitaciones</li>
				</ul>
			</div> 
		</div>
	</div>
</div>

<form action=""  method="POST">
    <div class="container">
        <div class="text-right mt-1">
            <div class="row"> 
                <div class="col-md-12">
                    <h3 align="center">Filtrar Capacitaciones</h3>
                </div>

                <div class="col-md-12">
                    <hr><br>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Año <font color="red"><strong>*</strong></font> </label>
                        <input class="form-control" type="number" min="2022" name="Anio" required>
                    </div> 
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                       <label>Mes <font color="red"><strong>*</strong></font> </label>
                            <select list="Mes" class="form-control" type="text" name="Mes" required>
                                <option></option>  
                                  <?php foreach ($Func->ListMeses(1, 0) as $admon) {
                                        echo '<option value="'.$admon['Mes'].'">'.$admon['NombMes'].'</option>'; 
                                  } ?> 
                            </select>
                    </div> 
                </div> 

                <div class="col-md-4">
                    <div class="form-group">
                        <center><input name="Verprog" style="width: 100%; height: 40px; margin-top:22px;" class="btn btn-success" type="submit" value="Buscar"/></center>
                    </div> 
                </div>
    	 	</div>
    	 </div>
</form>

<?php if (isset($_POST['Verprog'])) { ?>
    
    <form action="popup/VerProgramacion.php" target="popup" onsubmit="window.open('', 'popup', 'width = 2000, height = 1200')" method="POST">
		<div class="container">
		    <div class="text-right mt-5">
				<div class="row">
				    <div align="center" class="col-md-6">
				    	<strong>Año: </strong> <?php echo $Anio ?>
				    </div>
				    <div align="center" class="col-md-6">
				    	<strong>Mes: </strong> <?php echo $Func->ListMeses(2, $Mes) ?>
				    </div> 
				    <div class="col-md-12">
				    	<br>
				    </div>
				    <div class="col-md-12">
				    <table align="center" style="width: 100%">
						<tr>
							<td bgcolor="#198754" align='center'><font color="white"><strong>✔</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Cump. Legal</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Tipo formación</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Capacitacion</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Capacitador</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Categoria</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Subtipo</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Total programados</strong></font></td>
						</tr>
					
                        <?php foreach ($Func->ListProgramacion($Anio, $Mes) as $a){
                            echo "<tr align='center'>
                            <td><div class='form-group'>
                            <div class='form-check'>
                            <input required class='form-check-input radioNPro' type='radio' value='".$a['NROPROG']."' name='NROPROG'>
                            </div>	
                            </div></td>
                            <td>".$a['Cumpleg']."</td>
                            <td>".$a['TFORM']."</td>
                            <td>".utf8_encode($a['CAPACITACION'])."</td>
                            <td>".utf8_encode($a['NOMCAP'])."</td>
                            <td>".utf8_encode($a['CATEGORIA'])."</td>
                            <td>".utf8_encode($a['SUBTIPO'])."</td>	
                            <td>".$a['CANTIDADPROG']."</td>
                            <input id='cantidad' type='hidden' value='".$a['CANTIDADASIS']."' name='CANASIST'>
							</tr>";	
						} ?> 
			</table>                                                          
		</div>
        <?php if (count($Func->ListProgramacion($Anio, $Mes)) !== 0) { ?>
            <div class="col-md-12 mt-5">
                <center><input name="cargarCapac" style="width: 100%; margin-top: 30px;" class="btn btn-success" type="submit" value="¡Cargar Información!"/></center>
            </div>
        <?php }else{ ?>
            <div class="alert alert-danger" style="margin-top: 50px;" role="alert" align="center">No hay información disponible para cargar, primero debe cargar una programacion</div>
        <?php } ?>
	</form>

<?php } else { ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-success" style="margin-top: 50px;">
		<div class="container">
			<center><a class="navbar-brand">Consulta las capacitaciones por fechas</a> </center>
		</div>
    </nav> 
    
<?php } ?>

<?php }else{ 
?><script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href="../login.php"; 
</script><?php 
}
?>