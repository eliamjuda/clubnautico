<?php 

    require dirname(__DIR__)."../db.php";

    $id = $_GET['id'];

    $stmt = $conn -> prepare(
        "DELETE FROM socio WHERE id_sco = :id_sco"
    );

    $stmt -> bindParam(":id_sco", $id);

    $stmt -> execute();

    $conn = null;

    header("Location: ../index.php");





?>