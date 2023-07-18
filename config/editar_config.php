    <?php 

    require dirname(__DIR__) . "../db.php";

    if ( $_POST ) {

        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $membresia_select = $_POST['membresia'];
        $duenio_select = $_POST['duenio'];
        $es_duenio = FALSE;
        $membresia = FALSE;

        if ( $duenio_select === 'es_duenio' ){
            $es_duenio = TRUE;
        }

        if ( $membresia_select === 'vigente' ){
            $membresia = TRUE;
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
        print_r($stmt);
        $conn = null;

    }

    header("Location: ../index.php");
    

?>