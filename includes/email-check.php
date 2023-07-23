<?php 
//The file name was change from 'validation' to 'email-check'
//and moved from the config folder to includes

//We don't need all the data, just want to know if exist the email or phone number in our DB
    require dirname(__DIR__) . "../db.php";

    //we get the data that was sent from the ajax request
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];


    if(!empty($correo) && !empty($telefono) && !empty($nombre) && !empty($apellidos)){

        $text = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";

        $telefono = preg_replace('/\D/', '', $telefono);
        $telefono = strval($telefono);

        $message = [
            "name" => true,
            "lastnames" => true,
            "email" => true,
            "phone" => true,
        ];
        
        
        //name validation
        if(strlen($nombre) < 3 || strlen($nombre) > 30 || !preg_match($text,$nombre))
            $message["name"] = false;
        
        //surname validation
        if(strlen($apellidos) < 5 || strlen($apellidos)>60 || !preg_match($text,$apellidos))
            $message["lastnames"] = false;
        


        $stmt = $conn->prepare("SELECT * FROM socio WHERE correo = :email OR telefono = :telephone");
        $stmt->bindParam(':email', $correo);
        $stmt->bindParam(':telephone', $telefono);
        $stmt->execute();

        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $result = ($stmt -> fetchAll());
        
        //email and phone validation
        if(!empty($result)){
            foreach($result as $row){
                if($row["correo"] === $correo)
                    $message["email"] = false;
                if ($row["telefono"] === $telefono)
                    $message["phone"] = false;
            }
        }

        //Convert PHP data into the JSON format
        Header('Content-Type: application/json; charset=UTF8');
        echo json_encode($message);

    }


?>