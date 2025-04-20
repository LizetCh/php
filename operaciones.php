<?php
include("db.php");

$accion = $_POST['accion'];

if ($accion == "buscar") {
    $nombre = $_POST["nombre-buscar"];

    //Vamos a crear una tabla
    $query = "SELECT * FROM alumnos WHERE 1";
    if ($nombre != "") {
        $query .= " AND nombre LIKE '%" . $nombre . "%'";
    }

    $result = $db->query($query);

    if ($result->num_rows > 0) {
        echo '<table class="table table-hover">
        <thead>
            <tr>
            <th>ID</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Nombre</th>
            <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        ';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $row["id_alumno"] . '</td>
                <td>' . $row["apellido_paterno"] . '</td>
                <td>' . $row["apellido_materno"] . '</td>
                <td>' . $row["nombre"] . '</td>
                <td>
                    <button id="btnEditar" class="btn btn-warning" 
                        data-id="' . $row["id_alumno"] . '" 
                        data-nombre="' . $row["nombre"] . '"
                        data-apellido_paterno="' . $row["apellido_paterno"] . '"
                        data-apellido_materno="' . $row["apellido_materno"] . '"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button id="btnEliminar" class="btn btn-danger" data-id="' . $row["id_alumno"] . '"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Warning!</h4>
            <p class="mb-0">No hay registros que mostrar</p>
        </div>';
    }
}

//INSERCIÓN 
if ($accion == "insertar") {
    $nombre  = $_POST["nombre"];
    $apellido_paterno  = $_POST["apellido_paterno"];
    $apellido_materno  = $_POST["apellido_materno"];

    $qry = "INSERT INTO alumnos (nombre, apellido_paterno, apellido_materno) VALUES
        ('$nombre','$apellido_paterno','$apellido_materno')";

    $response = [];  // Inicializa el array correctamente

    if ($db->query($qry)) {
        $response["status"] = "OK";
    } else {
        $response["status"] = "ERROR";
        $response["error"] = $db->error;  // Muestra el error de la base de datos si hay uno
    }

    echo json_encode($response);
}

//Editar
if( $accion == "editar") {
    $id_alumno = $_POST["id_alumno"];
    $nombre  = $_POST["nombre"];
    $apellido_paterno  = $_POST["apellido_paterno"];
    $apellido_materno  = $_POST["apellido_materno"];

    $qry = "UPDATE alumnos SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno' WHERE id_alumno = $id_alumno";

    $response = [];  // Inicializa el array correctamente
    if ($db->query($qry)) {
        $response["status"] = "OK";
    } else {
        $response["status"] = "ERROR";
        $response["error"] = $db->error;  // Muestra el error de la base de datos si hay uno
    }
    echo json_encode($response);
}

//ELIMINACIÓN
if ($accion == "eliminar") {
    $id_alumno = $_POST["id_alumno"];

    $qry = "DELETE FROM alumnos WHERE id_alumno = $id_alumno";

    $response = [];  
    if ($db->query($qry)) {
        $response["status"] = "OK";
    } else {
        $response["status"] = "ERROR";
        $response["error"] = $db->error; 
    }
    echo json_encode($response);
}
?>
