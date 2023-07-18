<?php

    require dirname(__DIR__) . "../db.php";

    $id = $_GET['id'];

    $stmt = $conn -> prepare(
        "SELECT * FROM socio WHERE id_sco = :id"
    );

    $stmt -> bindParam(":id",$id);
    $stmt -> execute();

    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    
    $res = $stmt -> fetchAll();

    $stmt = null;

    if ( $_POST ) {

        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $membresia_select = $_POST['membresia'];
        $duenio_select = $_POST['duenio'];
        $es_duenio = 0;
        $membresia = 0;

        if ( $duenio_select === 'es_duenio' ){
            $es_duenio = 1;
        }

        if ( $membresia_select === 'vigente' ){
            $membresia = 1;
        }

        $stmt = $conn -> prepare(
            "UPDATE socio SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, correo = :correo,
            membresia = :membresia, es_duenio = :es_duenio WHERE id_sco = :id"
        );

        $stmt -> bindParam(":id",$id);
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
    <link rel="stylesheet" href="global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    
</head>
<body>
    <script src="script.js" async ></script>

    <div class="form-wrapper">
        
        <form method="post" id="formInput">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo$res[0]['nombre']?>"  maxlength="30" required> <br>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" value="<?php echo $res[0]['apellidos']  ?>"  maxlength="60" required> <br>

            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo $res[0]['telefono']  ?>"  maxlength="10" required> <br>

            <label for="correo">Correo</label>
            <input type="email" name="correo" id="correo" value="<?php echo $res[0]['correo']  ?>" maxlength="255" required> <br>

            <label for="membresia">Membresía</label>
            <select name="membresia" id="membresia">
                <?php 
                    if ($res[0]['membresia'] == 1 ) {
                ?>
                <option value="vigente">Vigente</option>
                <option value="vencida">Vencida</option>
                <?php 
                    }else{
                ?>

                <option value="vencida">Vencida</option>
                <option value="vigente">Vigente</option>

                <?php 
                    }
                ?>
            </select>

            <br>

            <label for="duenio">Dueño</label>
            <select name="duenio" id="">
                <?php 
                    if ($res[0]['es_duenio'] == 1 ) {
                ?>
                <option value="es_duenio">Sí</option>
                <option value="no_duenio">No</option>
                <?php 
                    }else{
                ?>

                    <option value="no_duenio">No</option>
                    <option value="es_duenio">Sí</option>

                <?php 
                    }
                ?>
            </select>

            <br>
            <input type="submit" id="formInput" value="Actualizar">
        </form>
        
    </div>

</body>
</html>