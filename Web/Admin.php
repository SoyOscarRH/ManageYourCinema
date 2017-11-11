<?php
    /*=======================================================================================================================
    ============================================         ADMINISTRATOR POWERS          ======================================
    =========================================================================================================================

    THIS IS THE GENERAL PAGE FOR THE ADMINISTRADOR TO SEE THINGS */
    include("PHP/ForAllPages.php");                                                             //Dame todas las ventajas

    // ================ VARIABLES =============================
    $HTMLTitle  = $Title = 'Administrador';                                                  	//Titulo de cada Pagina
    $UpdateDate = '23 de Julio del 2017';                                                       //Fecha de actualizacion de pagina

    $AlertMessages = array();                                                                   //Mensajes que mostramos 

    // ============ VER SOLO SI INCIA SESION  =================
    if (empty($_SESSION)) {                                                                     //Si ya iniciaste sesión
        $TitleErrorPage      = "Error Permisos";                                                //Error variables
        $MessageErrorPage    = "No iniciaste sesión en el Sistema";                             //Error variables
        $ButtonLinkErrorPage = $HTMLDocumentRoot."Login.php";                                   //Error variables
        $ButtonTextErrorPage = "Accede al Sistema";                                             //Error variables

        include("Error.php");                                                                   //Llama a la pagina de error
        exit();                                                                                 //Adios vaquero
    }

    // ============ ABRAMOS LA BASE DE DATOS =================
    $DataBase = @new mysqli("127.0.0.1", "root", "root", "Proyect");                            //Abrir una conexión
    if ((mysqli_connect_errno() != 0) or !$DataBase) {                                          //Si hubo problemas
        $TitleErrorPage      = "Error con la BD";                                               //Error variables
        $MessageErrorPage    = "No podemos acceder a la base de datos";                         //Error variables
        $ButtonLinkErrorPage = $HTMLDocumentRoot."Login.php";                                   //Error variables
        $ButtonTextErrorPage = "Intenta otra vez";                                              //Error variables

        include("Error.php");                                                                   //Llama a la pagina de error
        exit();                                                                                 //Adios vaquero
    }

    $QueryInfoEmployees = $DataBase->query('SELECT * FROM Empleado;');                          //Haz la consulta

    if ($QueryInfoEmployees->num_rows == 0)                                                     //Si es que no hay tuplas
        array_push($AlertMessages, "No se puede acceder a Info de los Empleados");              //Envia mensajes



    // *****************************************************************************************
    // *************************     PROCESS TO START THE SYSTEM   *****************************
    // *****************************************************************************************
    include("PHP/HTMLHeader.php");                                                              //Incluimos un Asombroso Encabezado
?>

    <br><br>

    <div class="container center-align">

        <!-- ========  MATERIAL CARD  ================ -->
        <div class="card-panel grey lighten-4 col s12 m8 l8 offset-m2 offset-l2">

            <h4 class="grey-text text-darken-2">
                <br><b>Información </b> de Empleados
            </h4>

            <span class="grey-text" style="font-size: 1.25rem;">
                Acceder a un registro con todos los empleados activos
                <br><br>
            </span>

            <!-- ========  MATERIAL TABLE CARD  ================ -->
            <table
                id="EmployeesTables" 
                style="display: none;"
                class="centered hoverable striped responsive-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sueldo</th>
                        <th>Turno</th>
                        <th>Genero</th>
                        <th>Nombre</th>
                        <th>Apellido 1</th>
                        <th>Apellido 2</th>
                        <th>Correo</th>
                        <th>Rol Actual</th>
                        <th>ID del Gerente</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                    while ($Row = $QueryInfoEmployees->fetch_row()) : ?>


                    <tr>
                    
                    <?php foreach ($Row as $Number => $Value): 
                        if ($Number == 8) continue;?>

                        <td><?php echo $Value; ?></td>
                        
                    <?php endforeach; ?>

                    </tr>

                    <?php endwhile;

                    $QueryInfoEmployees->close();

                $DataBase->close(); 
                ?>

                </tbody>
            </table>

            <br>

    		<button 
                id="EmployeesTablesButton"
                class="btn waves-effect waves-light"
                name="ShowEmployees">
    			Ve los Empleados
    		</button>
            <script>
                $("#EmployeesTablesButton").click( function() {$("#EmployeesTables").toggle();});
            </script>

        </div>

        <br><br><br><br>
        <br><br><br><br>


    </div>


    <script>
        $(document).ready(function() {
            <?php 
                $ErrorSymbol = '<span class = "yellow-text"><b>Error: &nbsp; </b></span>';

                foreach ($AlertMessages as $Alert) {
                    echo "Materialize.toast('{$ErrorSymbol} {$Alert}', 9000);";           //Envia esto
                }
            ?>
        });
    </script>


	<?php include("PHP/HTMLFooter.php"); ?>
