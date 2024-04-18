<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Asignar Examenes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <style>


        .header-image {
            width: 100%; /* Ajusta el ancho de la imagen */
            margin-bottom: 20px; /* Margen inferior para separar la imagen del contenido */
            /* Agrega más estilos según sea necesario */
        }



        .tablehenx {
            border-collapse: collapse;
            width: 100%;
            margin: 0px auto;
        }

        .tablehenx th, .tablehenx td {
            border: 1px solid #000;
            padding: 8px;
        }

        .tablehenx th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #000;
        }

        .tablehenx tr:nth-child(even) {
            background-color: #fff;
        }

        .tablehenx input[type="text"] {
            width: 100%;
            padding: 2px;
        }

        #btnCrearPdf {
            display: none; /* No mostrar el botón en la impresión */
        }

        #btnCrearPdf {
            background-color: #4CAF50; /* Color de fondo */
            border: none;
            color: white; /* Color del texto */
            padding: 10px 20px; /* Espaciado interno */
            text-align: center;
            text-decoration: none;
            display: block; /* Convertir en bloque para centrar */
            margin: 20px auto; /* Centrar horizontalmente */
            font-size: 16px;
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
            transition: background-color 0.3s; /* Transición suave para el color de fondo */
        }

        /* Cambiar color de fondo cuando el cursor está encima del botón */
        #btnCrearPdf:hover {
            background-color: #45a049;
        }

        .firma {
            margin-top: 100px; /* Espacio entre la tabla y la firma */
            text-align: center;
        }

        .firma hr {
            width: 20%; /* Ancho de la línea */
            border: none;
            height: 2px; /* Grosor de la línea */
            background-color: #000000; /* Color de la línea */
        }

        .datos {
            margin: 20px auto;
            text-align: center;
        }



        label {
            font-weight: bold;
            margin-right: 10px;
        }

        /* Estilo para input de tipo date */
        input[type="date"] {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px;
            box-sizing: border-box;
            width: 100%; /* Ajusta el ancho según sea necesario */
            font-size: 14px;
            background-color: #f8f9fa; /* Color de fondo */
            color: #495057; /* Color de texto */
            height: 55%; /* Ajusta la altura según sea necesario */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; /* Transiciones */
        }

        /* Estilo para el input de tipo date cuando está enfocado */
        input[type="date"]:focus {
            border-color: #80bdff; /* Color del borde cuando está enfocado */
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Sombra cuando está enfocado */
        }
    </style>

</head>
<body>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>REGISTRO ASIGNAR EXAMENES</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <button class = "btn btn-danger btn-sm float-right " onclick="cargar_contenido('contenido_principal', 'resultado/mantenimiento_resultado_registro.php')"><i class="fas fa-arrow-left"></i>
                    Atras</button>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><b>Asignar Examenes Paciente </b></h3>
        </div>

        <div class="card-body">

            <?php
                // Conexión a la base de datos
                $conexion = new mysqli('localhost', 'root', '', 'laboratorio', 3306);

                if ($conexion->connect_error) {
                    die("La conexión a la base de datos falló: " . $conexion->connect_error);
                }

                $sql = "CALL `SP_REGISTRAR_FACTURA_DETALLE_CARACTERISTICAS`(" . ($conexion->real_escape_string($_GET['id_dfactu'] ?? '0')) . ")";

                $resultado = $conexion->query($sql);

                if (!$resultado) {
                    die("Error al ejecutar la consulta: " . $conexion->error);
                }

                $data = [];
                while ($fila = $resultado->fetch_assoc()) {
                    $data[] = $fila;
                }

                $conexion->close();

                echo "<table class='tablehenx'>
                        <thead>
                            <tr>
                                <th>Nombre del Examen</th>
                                <th>Resultado</th>
                                <th>Valor de Referencia</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($data as $key => $value) {
                    echo "<tr>
                            <td>" . $value['pruebas_nombre'] . "</td>
                            <td><input type='text' id='resultadoExamen1' placeholder='Escribir resultado'></td>
                            <td>" . $value['pruebas_valor'] . "</td>
                        </tr>";
                }

                echo "</tbody></table>";


            ?>
            <!-- Fin de la tabla de exámenes -->

            <!-- Resto del formulario y botones -->

            <div class="firma">
                <!-- Contenido de la firma aquí -->
            </div>



            <div class="col-4 mx-auto">
                <label for="">&nbsp;</label><br>
                <a id="btnCrearPdf" onclick="generarPDF()" class="btn btn-success btn-lg" style="width:80%">
                    <i class="fas fa-print"></i> Imprimir Examen
                </a>
            </div>





            <!--Inicio Modal -->
            <div class="modal fade" id="modal_ver_paciente"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">SELECCIONAR PACIENTE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-primary card-outline card-tabs">
                                        <div class="card-header p-0 pt-1 border-bottom-0">
                                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Listado Pacientes</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Nuevo Paciente</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                    <div class="col-12 table-responsive">
                                                        <table id="tabla_ver_paciente" class="display" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>DNI</th>
                                                                <th>Paciente</th>
                                                                <th>Edad</th>
                                                                <th>Sexo</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="">DNI</label>
                                                            <input type="text" id="txt_dni" placeholder="DNI" class="form-control" onkeypress="return soloNumeros(event)" maxlength="13">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Nombres</label>
                                                            <input type="text" id="txt_nombres" placeholder="Nombres del paciente" class="form-control" onkeypress="return soloLetras(event)">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Apellido Paterno</label>
                                                            <input type="text" id="txt_apepat" placeholder="Apellido Paterno del paciente" class="form-control" onkeypress="return soloLetras(event)">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Apellido Materno</label>
                                                            <input type="text" id="txt_apemat" placeholder="Apellido Materno del paciente" class="form-control" onkeypress="return soloLetras(event)">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Celular</label>
                                                            <input type="text" id="txt_celular" placeholder="Celular Paciente" class="form-control" onkeypress="return soloNumeros(event)">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Edad</label>
                                                            <input type="text" id="txt_edad" placeholder="Edad Paciente" class="form-control" onkeypress="return soloNumeros(event)">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Tipo edad</label>
                                                            <select class="form-control form-control-sm" id="select_tipo" style="width:100%">
                                                                <option value="">SELECCIONAR TIPO EDAD</option>
                                                                <option value="AÑOS">AÑOS</option>
                                                                <option value="MESES">MESES</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">SEXO</label>
                                                            <select class="form-control form-control-sm" id="select_sexo" style="width:100%">
                                                                <option value="">SELECCIONAR SEXO DEL PACIENTE</option>
                                                                <option value="MASCULINO">MASCULINO</option>
                                                                <option value="FEMENINO">FEMENINO</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12" id="div_mensaje_error">

                                                        </div>
                                                        <div class="col-12" style="text-align:center;"><br><br>
                                                            <button type="button" class="btn btn-primary btn-lg" onclick="Registrar_Paciente()">Registrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!--Fin Modal -->


        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/henri.js?rev=<?php echo time();?>"></script>
<script src="../js/html2pdf.bundle.min.js?rev=<?php echo time();?>"></script>


<script>
     function cargar_contenido(id,vista){
            $("#"+id).load(vista);
        }
</script>

<script type="text/javascript">
    // Función para generar el PDF con la tabla de exámenes
    function generarPDF() {

        // Verificar si se ha seleccionado una fecha
        var fechaSeleccionada = document.getElementById('fecha_actual').value;
        if (fechaSeleccionada === "") {
            alert("Por favor, seleccione una fecha antes de guardar el PDF.");
            return; // Salir de la función si no se ha seleccionado una fecha
        }

        // Verificar si se ha seleccionado un paciente
        var nombrePaciente = document.getElementById('txt_paciente').value;
        if (nombrePaciente === "") {
            alert("Por favor, seleccione un paciente antes de guardar el PDF.");
            return; // Salir de la función si no se ha seleccionado un paciente
        }

        var tabla = document.querySelector('.tablehenx').cloneNode(true); // Clona la tabla original

        // Resto del código para generar el PDF...

        // Aplicar estilos CSS para ajustar el tamaño de la tabla
        tabla.style.width = "97%"; // Por ejemplo, establece el ancho al 100%

        var inputs = tabla.querySelectorAll('input'); // Encuentra todos los inputs en la tabla clonada
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].parentNode.innerHTML = inputs[i].value; // Reemplaza el input con su valor
        }

        var nombre = document.getElementById('txt_paciente').value;
        var edad = document.getElementById('txt_edad').value;
        var sexo = document.getElementById('txt_sexo').value;
        var fecha = document.getElementById('fecha_actual').value;

        // Crear elementos para mostrar el título de QUIMICA en negrita
        var tituloQuimica = document.createElement('div');
        tituloQuimica.innerHTML = "<strong>QUIMICA</strong>";
        tituloQuimica.style.textAlign = 'center'; // Centrar el título
        tituloQuimica.style.fontSize = '24px'; // Tamaño grande de la fuente
        tituloQuimica.style.marginTop = '-16px';
        tituloQuimica.style.marginBottom = '20px'; // Espacio entre el título y los datos del paciente

        // Crear elementos para mostrar los datos ingresados en una sola línea
        var datosContainer = document.createElement('div');
        datosContainer.style.marginTop = '20px'; // Espacio superior para separación del título
        datosContainer.innerHTML = "<strong>Nombre:</strong> " + nombre + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Edad:</strong> " + edad + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Sexo:</strong> " + sexo + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Fecha:</strong> " + fecha;
        datosContainer.style.marginBottom = '30px'; // Espacio inferior para separación de la tabla

        // Envolver los datos en un div para centrarlos
        var datosWrapper = document.createElement('div');
        datosWrapper.style.textAlign = 'center'; // Centrar los datos
        datosWrapper.appendChild(tituloQuimica); // Agregar el título de QUIMICA
        datosWrapper.appendChild(datosContainer); // Agregar los datos al contenedor de datos

        // Crear elemento para la imagen
        var imagen = document.createElement('img');
        imagen.src = 'Henri/henrit.png'; // Especifica la ruta de la imagen que deseas imprimir
        imagen.className = 'header-image'; // Agrega la clase de estilo CSS para la imagen
        imagen.style.marginTop = '-70px'; // Ajusta el margen superior de la imagen para ubicarla más arriba

        // Crear contenedor para la línea de firma y el texto
        var firmaContainer = document.createElement('div');
        firmaContainer.style.textAlign = 'center'; // Centrar la línea de firma y el texto

        // Crear línea para la firma
        var lineaFirma = document.createElement('hr');
        lineaFirma.style.width = '35%'; //
        lineaFirma.style.margin = '60px auto 20px'; // Espacio antes y después de la línea de firma
        lineaFirma.style.border = 'none'; // Eliminar el borde predeterminado
        lineaFirma.style.backgroundColor = 'black'; // Cambiar el color a negro
        lineaFirma.style.height = '2px'; // Aumentar el grosor de la línea de firma

        // Crear texto "Firma del Regente"
        var textoFirmaRegente = document.createElement('div');
        textoFirmaRegente.textContent = 'Firma del Regente';
        textoFirmaRegente.style.textAlign = 'center';

        var firma = document.querySelector('.firma').cloneNode(true); // Clona la sección de firma
        var contenido = document.createElement('div'); // Crea un nuevo div para contener la tabla, los datos y la firma
        contenido.appendChild(imagen); // Agrega la imagen
        contenido.appendChild(datosWrapper); // Agrega el contenedor de datos envuelto
        contenido.appendChild(tabla); // Agrega la tabla clonada
        firmaContainer.appendChild(lineaFirma); // Agrega la línea de firma al contenedor
        firmaContainer.appendChild(textoFirmaRegente); // Agrega el texto "Firma del Regente" al contenedor
        contenido.appendChild(firmaContainer); // Agrega el contenedor de línea de firma y texto
        contenido.appendChild(firma); // Agrega la sección de firma clonada

        html2pdf()
            .from(contenido)
            .set({
                margin: 1,
                filename: 'documento.pdf',
                image: {
                    type: 'jpeg',
                    quality: 10
                },
                html2canvas: {
                    scale: 5, // A mayor escala, mejores gráficos, pero más peso
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "in",
                    format: "a3",
                    orientation: 'portrait' // landscape o portrait
                }
            })
            .set({ quality: 100 }) // Ajustes de calidad de PDF
            .save(); // Genera el PDF con alta calidad de impresión
    }
</script>

</body>
</html>
