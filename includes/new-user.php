<?php 

    require dirname(__DIR__) . "../db.php";

    if ( $_POST ) {

        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $membresia_select = $_POST['membresia'];
        $duenio_select = $_POST['duenio'];
        $es_duenio = 0;
        $membresia = 0;

        if ( strlen($telefono) > 10 || strlen($telefono) < 10 ) {
            exit;
        }

        if ( strlen($nombre) > 30) {
            exit;
        }

        if ( strlen($apellidos) > 60 ) {
            exit;
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            exit;
        }

        $telefono = preg_replace('/\D/', '', $telefono);

        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            exit;
        }

        if ( $duenio_select === 'es_duenio' ){
            $es_duenio = 1;
        }

        if ( $membresia_select === 'vigente' ){
            $membresia = 1;
        }

        $stmt = $conn -> prepare(
            "INSERT INTO socio (id_sco, nombre, apellidos, telefono, correo, membresia, es_duenio )
            VALUES(NULL, :nombre, :apellidos, :telefono, :correo, :membresia, :es_duenio)"
        );

        $stmt -> bindParam(":nombre", $nombre);
        $stmt -> bindParam(":apellidos", $apellidos);
        $stmt -> bindParam(":telefono", $telefono);
        $stmt -> bindParam(":correo", $correo);
        $stmt -> bindParam(":membresia", $membresia);
        $stmt -> bindParam(":es_duenio", $es_duenio);

        $stmt -> execute();
        $conn = null;
        header("Location: ../index.php");

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../config/global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    
</head>
<body>
    
    <div class="form-wrapper">
        <form method="post" id="formInput">
            
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" autocomplete="off">
            <small></small>
            <br>
    
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos">
            <small></small> <br>
    
            <label for="telefono">Telefono</label>
            <input type="tel" name="telefono" id="telefono">
            <small></small> <br>
    
            <label for="correo">Correo</label>
            <input type="email" name="correo" id="correo">
            <small></small> <br>
    
            <label for="membresia">Membresía</label>
            <select name="membresia" id="membresia">
                <option value="vencida">Vencida</option>
                <option value="vigente">Vigente</option>
            </select>
            <small></small>
    
            <br>
    
            <label for="duenio">Dueño</label>
            <select name="duenio" id="duenio">
                <option value="no_duenio">No</option>
                <option value="es_duenio">Sí</option>
            </select>
            <small></small>
    
            <br>
            <input type="submit" value="Registrar socio">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script async src="../config/script.js"></script>

</body>
</html>