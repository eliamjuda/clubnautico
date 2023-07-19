<?php 
    //Este es un comentario
    // Esta es una función de validación, en la que le paso esos 4 parámetros que tiene que validar, los 4 son Strings

    function Validation($nombre, $apellidos, $telefono, $correo) {
        
        // Requiere la base de datos (require e include son diferentes, pero por su nombre se sabe en qué se diferencian)
        // el dirname es para que te traiga la ruta actual del proyecto (http://localhost/) 
        // porque sólo funciona con rutas absolutas.

        require dirname(__DIR__) . "../db.php";

        // validación bien simple que seguro entiendes xd 

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

        // hace una busqueda en socio para ver si el correo y/o el socio ya existe, 
        // si existe hace el row count, que si sale 1 pues es que ese dato ya existe, entonces se sale y no se ejecuta

        $stmtEmail = $conn->prepare("SELECT * FROM socio WHERE correo = :email");
        $stmtEmail->bindParam(':email', $correo);
        $stmtEmail->execute();

        $stmtTelephone = $conn->prepare("SELECT * FROM socio WHERE telefono = :telephone");
        $stmtTelephone->bindParam(':telephone', $telefono);
        $stmtTelephone->execute();

        if ($stmtEmail->rowCount() > 0) {
            exit;
        }

        if ($stmtTelephone->rowCount() > 0) {
            exit;
        }

    }

?>