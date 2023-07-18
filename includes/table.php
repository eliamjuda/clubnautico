<?php 

    require dirname(__DIR__)."../db.php";

?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Membresía</th>
            <th>Dueño</th>
        </tr>
    </thead>

    <tbody>
        <?php 
            
            $stmt = $conn -> prepare(
                "SELECT * FROM socio"
            );

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $result = ($stmt -> fetchAll());

            
            foreach($result as $data){

            $duenio = ($data['es_duenio'] == 1) ? "Sí" : "No";
            $membresia = ($data['membresia'] == 1) ? "Vigente" : "Vencida";
        ?>

            <tr>
                <td><?php echo $data['id_sco'] ?></td>
                <td><?php echo $data['nombre'] ?></td>
                <td><?php echo $data['apellidos'] ?></td>
                <td><?php echo $data['telefono'] ?></td>
                <td><?php echo $data['correo'] ?></td>
                <td><?php echo $membresia ?></td>
                <td><?php echo $duenio ?></td>
                <td><a href="clubnautico/../config/editar.php?id=<?php echo $data['id_sco'] ?>">Actualizar</a></td>
                <td><a class="delete" href="clubnautico/../config/eliminar.php?id=<?php echo $data['id_sco'] ?>">Eliminar</a></td>
            </tr>

        <?php 
        } 
            $conn = null;
        ?>
    </tbody>

    

</table>