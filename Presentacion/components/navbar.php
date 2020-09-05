<?php

// Importación de clases

include_once('../rutas.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CARPETA_RAIZ . RUTA_PERSISTENCIA . 'Conexion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CARPETA_RAIZ . RUTA_NEGOCIO . 'manejoEstudiante.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CARPETA_RAIZ . RUTA_NEGOCIO . 'manejoEmpresa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CARPETA_RAIZ . RUTA_NEGOCIO . 'manejoVacante.php');


// Conexión con la base de datos

$c = Conexion::getInstancia();
$conexion = $c->conectarBD();

// Ejecución de métodos (Manejos)

$idUsuario = $_SESSION['usuario'];
$rolUsuario = $_SESSION['rol'];

$usuario = "";

if (strcasecmp($rolUsuario, "Empresa") == 0) 
{
    $manejoEmpresas = new ManejoEmpresa($conexion);
    $usuario = $manejoEmpresas->buscarEmpresa($idUsuario);
} 
else if (strcasecmp($rolUsuario, "Estudiante") == 0) 
{
    $manejoEstudiante = new ManejoEstudiante($conexion);
    $usuario = $manejoEstudiante->buscarEstudiante($idUsuario);
} 
else 
{
    $usuario = "Administrador";
}

$ruta = "";

if (strcasecmp($rolUsuario, "Empresa") == 0) 
{
    $ruta = "portalEmpresa.php";
} 
else if (strcasecmp($rolUsuario, "Estudiante") == 0) 
{
    $ruta = "portalEstudiante.php";
}


?>

<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href=""><?php echo $rolUsuario ?>

                <?php

                if (strcasecmp($rolUsuario, "Empresa") == 0) {
                    echo "- " . $usuario->getRazonSocial();
                } else if (strcasecmp($rolUsuario, "Estudiante") == 0) {
                    echo "- " . $usuario->getNombre();
                }

                ?></a>
        </div>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            Account
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="<?php echo $ruta ?>">Cuenta</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href=" <?php echo "/" . CARPETA_RAIZ . "/Sesion/cerrarSesion.php" ?> ">Cerrar sesión</a>
                    </div>
                </li>
                <!-- your navbar here -->
            </ul>
        </div>
    </div>
</nav>