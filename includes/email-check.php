<?php 
//The file name was change from 'validation' to 'email-check'
//and moved from the config folder to includes

//We don't need all the data, just want to know if exist the email or phone number in our DB
    require dirname(__DIR__) . "../db.php";

    //we get the data that was sent from the ajax request
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    if(!empty($correo) && !empty($telefono)){

        $stmt = $conn->prepare("SELECT * FROM socio WHERE correo = :email OR telefono = :telephone");
        $stmt->bindParam(':email', $correo);
        $stmt->bindParam(':telephone', $telefono);
        $stmt->execute();

        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $result = ($stmt -> fetchAll());
        
        //Convert PHP data into the JSON format
        echo json_encode($result);
    }


?>