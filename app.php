
<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.3/cyborg/bootstrap.min.css" integrity="sha512-M+Wrv9LTvQe81gFD2ZE3xxPTN5V2n1iLCXsldIxXvfs6tP+6VihBCwCMBkkjkQUZVmEHBsowb9Vqsq1et1teEg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Catálogo de alumnos</h1>
        </div>
    </div>
    <div class="row">
        <form id="frmBuscar" name="frmBuscar">
            <div class="mb-3">
                <label class="form-label" for="nombre"> Nombres: </label>
                <input class="form-control" type="text" id="nombre-buscar" name="nombre-buscar" placeholder="Escribe el nombre del alumno">
            </div>
            <div class="mb-3">
                <button type="button" name="btnBuscar" id="btnBuscar" class="btn btn-success btn-sm"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                <button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-warning btn-sm"><i class="fa-solid fa-plus"></i> Nuevo</button>
            </div>
        </form>
    </div>

    
    <div class="row">
        <div class="col-12" id="tablita" name="tablita">
            <!-- Aquí se mostrarán la tabla-->
        </div>
    </div>
    

</div>

<!--Modal-->

<div class="modal" role="dialog" tabindex="-1" id="form-add-alumno">
    <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
            <h5 class="modal-title">Crear un Alumno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="nombre" class="control-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="apellido_paterno" class="control-label">Apellido Paterno:</label>
                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="apellido_materno" class="control-label">Apellido Materno:</label>
                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control">
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button id="btnAgregar" type="button" class="btn btn-success d-none" onclick="crearAlumno()"><i class="fa-solid fa-floppy-disk"></i>Crear</button>
            <button id="btnGuardarCambios" type="button" class="btn btn-primary d-none"><i class="fa-solid fa-floppy-disk"></i> Guardar cambios</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i>Cerrar</button>
            
        </div>
        </div>
    </div>
</div>

<!--Fin del Modal-->

<script type="text/javascript">

    $(function(){
        //Interceptar el click del botón
        $("#btnBuscar").on("click",function(event){
            event.preventDefault(); // Evita la recarga de la página
            buscar();
        });

        //Interceptar el click del botón nuevo
        $("#btnNuevo").on("click",function(event){
            // limpiar los campos del forms
            $("#nombre").val("");
            $("#apellido_paterno").val("");
            $("#apellido_materno").val("");
            
            $("#btnAgregar").removeClass("d-none");
            $("#btnGuardarCambios").addClass("d-none");

            $("#form-add-alumno").modal("show");
        });

        //Interceptar el click del botón eliminar
        $(document).on("click", "#btnEliminar", function(event){
            event.preventDefault();
            var id = $(this).data("id"); // ID del alumno
            eliminarAlumno(id);
        });

        //Interceptar el click del botón editar
        $(document).on("click", "#btnEditar", function(event){
            event.preventDefault();
            var id = $(this).data("id");
            var nombre = $(this).data("nombre");
            var apellido_paterno = $(this).data("apellido_paterno");
            var apellido_materno = $(this).data("apellido_materno");
            
            // mostrar valores en el modal
            $("#nombre").val(nombre);
            $("#apellido_paterno").val(apellido_paterno);
            $("#apellido_materno").val(apellido_materno);

            // cambiar el botón del modal
            $("#btnGuardarCambios").removeClass("d-none");
            $("#btnAgregar").addClass("d-none");
            $("#btnGuardarCambios").data("id", id); // guardar el id en el botón


            $("#form-add-alumno").modal("show");
            
        });

        //Interceptar el click del botón guardar cambios
        $(document).on("click", "#btnGuardarCambios", function(event){
            event.preventDefault();
            var id = $(this).data("id");
            editarAlumno(id);
        });

        buscar(); // mostarr tabla al cargar la página
    });

    function buscar() {
        $.ajax({
            type: "POST",
            url: "operaciones.php",
            data: "accion=buscar&" + $("#frmBuscar").serialize(),
            cache: false,
            beforeSend: function() {
                $("#tablita").html('<p> Cargando... </p>');
            },
            success: function(resultado) {
                $("#tablita").html(resultado);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }

    function crearAlumno() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "operaciones.php",
            data: {
                accion: "insertar",
                nombre: $("#nombre").val(),
                apellido_paterno: $("#apellido_paterno").val(),
                apellido_materno: $("#apellido_materno").val()
            },
            cache: false,
            beforeSend: function() {
                $("#form-add-alumno").modal("hide");
            },
            success: function(resultado) {
                if (resultado.status === "OK") {
                    buscar();
                } else {
                    alert("Error al insertar el alumno");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }

    function eliminarAlumno(id) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "operaciones.php",
            data: {
                accion: "eliminar",
                id_alumno: id
            },
            cache: false,
            success: function(resultado) {
                if (resultado.status === "OK") {
                    buscar();
                } else {
                    alert("Error al eliminar el alumno");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function editarAlumno(id) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "operaciones.php",
            data: {
                accion: "editar",
                id_alumno: id,
                nombre: $("#nombre").val(),
                apellido_paterno: $("#apellido_paterno").val(),
                apellido_materno: $("#apellido_materno").val()
            },
            cache: false,
            beforeSend: function() {
                $("#form-add-alumno").modal("hide");
            },
            success: function(resultado) {
                if (resultado.status === "OK") {
                    buscar();
                } else {
                    alert("Error al modificar el alumno");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }
    </script>
</body>
</html>


