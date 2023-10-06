<?php
require '../Funciones/funcionalidades.php';
$Func = new Funciones;

if (isset($_GET['cargo'])) {
    $selectedCargo = $_GET['cargo'];
    $nombres = $Func->ListEMPL($selectedCargo);

    foreach ($nombres as $nombre) {
        echo '<option value="' . $nombre['CODIGO'] . '">' . utf8_encode($nombre['NOMBRE']) . '</option>';
    }
}
?>