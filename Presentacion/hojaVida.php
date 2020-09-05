<?php

session_start();

if (!isset($_SESSION['usuario'])) {

  header("location:../index.php");
}

// Importación de clases

include_once('../rutas.php');
include_once('../Persistencia/Conexion.php');
include_once('../Negocio/ManejoEstudiante.php');
include_once('../Negocio/ManejoHojaDeVida.php');

// Conexión con la base de datos

$c = Conexion::getInstancia();
$conexion = $c->conectarBD();

// Ejecución de métodos (Manejos)

$idUsuario = $_SESSION['usuario'];
$manejoEstudiantes = new ManejoEstudiante($conexion);
$estudiante = $manejoEstudiantes->buscarEstudiante($idUsuario);

$manejoHojaVida = new ManejoHojaDeVida($conexion);
$hojaVida = $manejoHojaVida->buscarHojaVida($idUsuario);
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Hoja de vida</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "css/aos.css" ?> rel="stylesheet">
  <link href=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "css/bootstrap.min.css" ?> rel="stylesheet">
  <link href=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "styles/main.css" ?> rel="stylesheet">
</head>

<body id="top">
  <div class="page-content">
    <div>
      <div class="profile-page">
        <div class="wrapper">
          <div class="page-header page-header-small" filter-color="green">
            <div class="page-header-image" data-parallax="true" style="background: rgb(62, 71, 41);"></div>
            <div class="container">
              <div class="content-center">
                <div class="cc-profile-image"><a href="#"><img class="img" src= <?php echo "/" . CARPETA_RAIZ . RUTA_FOTOS . "Estudiante/" . $estudiante->getRutaFoto() ?>></a></div>
                <div class="h2 title"> <?php echo $estudiante->getNombre() ?> </div>
                <p class="category text-white"> <?php echo $estudiante->getProgramaAcademico() ?> </p><a class="btn btn-primary" href="#" data-aos="zoom-in" data-aos-anchor="data-aos-anchor">PDF</a><a class="btn btn-primary" href="#" data-aos="zoom-in" data-aos-anchor="data-aos-anchor">Volver</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section" id="about">
        <div class="container">
          <div class="card" data-aos="fade-up" data-aos-offset="10">
            <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card-body">
                  <div class="h4 mt-0 title">Información básica</div>
                  <div class="row mt-3">
                    <div class="col-sm-4"><strong class="text-uppercase">Documento:</strong></div>
                    <div class="col-sm-8"><?php echo $estudiante->getTipoDeDocumento() . " " . $estudiante->getNumeroDocumento() ?></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-4"><strong class="text-uppercase">Correo electrónico:</strong></div>
                    <div class="col-sm-8"><?php echo $estudiante->getCorreo() ?></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-4"><strong class="text-uppercase">Edad:</strong></div>
                    <div class="col-sm-8"><?php echo $estudiante->getEdad() ?></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-4"><strong class="text-uppercase">Teléfono:</strong></div>
                    <div class="col-sm-8"><?php echo $estudiante->getTelefono() ?></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-4"><strong class="text-uppercase">Programa Académico:</strong></div>
                    <div class="col-sm-8"><?php echo $estudiante->getProgramaAcademico() ?></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="card-body">
                  <div class="h4 mt-0 title">Perfil profesional</div>
                  <p> <strong> Perfil profesional: </strong> <?php echo $hojaVida->getPerfilProfesional() ?> </p>
                  <p> <strong> Certificaciones: </strong> <?php echo $hojaVida->getCertificaciones() ?> </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section" id="skill">
        <div class="container">
          <div class="h4 text-center mb-4 title">Idiomas</div>
          <div class="card" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-body">

              <?php

              foreach ($hojaVida->getIdiomas() as $idioma) {

                $nivel = "0";

                if (strcasecmp($idioma[1], "Básico") == 0) {
                  $nivel = "30";
                }
                if (strcasecmp($idioma[1], "Intermedio") == 0) {
                  $nivel = "50";
                }
                if (strcasecmp($idioma[1], "Avanzado") == 0) {
                  $nivel = "70";
                }
                if (strcasecmp($idioma[1], "Nativo") == 0) {
                  $nivel = "100";
                }

              ?>

                <div class="row">
                  <div class="col-md-12">
                    <div class="progress-container progress-primary"><span class="progress-badge"> <?php echo $idioma[0] ?> </span>
                      <div class="progress">
                        <div class="progress-bar progress-bar-primary" data-aos="progress-full" data-aos-offset="10" data-aos-duration="2000" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $nivel . "%" ?>;"></div><span class="progress-value"> <?php echo $idioma[1] ?> <?php echo "(" . $nivel . "%)" ?> </span>
                      </div>
                    </div>
                  </div>
                </div>

              <?php
              }
              ?>

            </div>
          </div>
        </div>
      </div>
      <div class="section" id="experience">
        <div class="container cc-experience">
          <div class="h4 text-center mb-4 title">Experiencia laboral</div>

          <?php

          foreach ($hojaVida->getExperienciaLaboral() as $experiencia) {

          ?>

            <div class="card">
              <div class="row">
                <div class="col-md-3 bg-primary" data-aos="fade-right" data-aos-offset="50" data-aos-duration="500">
                  <div class="card-body cc-experience-header">
                    <p>  <?php echo $experiencia[3] ?> </p>
                    <div class="h5"> <?php echo $experiencia[2] ?> </div>
                  </div>
                </div>
                <div class="col-md-9" data-aos="fade-left" data-aos-offset="50" data-aos-duration="500">
                  <div class="card-body">
                    <div class="h5"> <?php echo $experiencia[0] ?> </div>
                    <p> <?php echo $experiencia[1] ?> </p>
                  </div>
                </div>
              </div>
            </div>

          <?php
          }
          ?>

        </div>
      </div>
      <div class="section">
        <div class="container cc-education">
          <div class="h4 text-center mb-4 title">Educación</div>

          <?php

          foreach ($hojaVida->getEstudios() as $estudio) {

          ?>
            <div class="card">
              <div class="row">
                <div class="col-md-3 bg-primary" data-aos="fade-right" data-aos-offset="50" data-aos-duration="500">
                  <div class="card-body cc-education-header">
                    <p> <?php echo $estudio[4] ?> </p>
                    <div class="h5"><?php echo $estudio[3] ?> </div>
                  </div>
                </div>
                <div class="col-md-9" data-aos="fade-left" data-aos-offset="50" data-aos-duration="500">
                  <div class="card-body">
                    <div class="h5"> <?php echo $estudio[0] ?> </div>
                    <p class="category"> <?php echo $estudio[2] ?> </p>
                    <p> Area de estudio: <?php echo $estudio[1] ?></p>
                  </div>
                </div>
              </div>
            </div>

          <?php
          }
          ?>

        </div>
      </div>
    </div>
    <div class="section" id="reference">
      <div class="container cc-reference">
        <div class="h4 mb-4 text-center title">Referencias personales</div>

        <?php

        foreach ($hojaVida->getReferenciasPersonales() as $referencia) {

        ?>
<div class="card" data-aos="zoom-in">
            <div class="row">
              <div class="col-lg-2 col-md-3 cc-reference-header">
                <div class="h5 pt-2"> <img src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "images/users.png" ?> alt="Image" /> </div>
              </div>
              <div class="col-lg-10 col-md-9">
                <p> Nombre: <?php echo $referencia[0] ?> </p>
                <p> Teléfono: <?php echo $referencia[1] ?> </p>
                <p> Parentesco: <?php echo $referencia[2] ?> </p>
              </div>
            </div>
</div>
        <?php
        }
        ?>

      </div>
    </div>
  </div>
  </div>
  <footer class="footer">
    <div class="h4 title text-center">Anthony Barnett</div>
    <div class="text-center text-muted">
      <p>&copy; Creative CV. All rights reserved.<br>Design - <a class="credit" href="https://templateflip.com" target="_blank">TemplateFlip</a></p>
    </div>
  </footer>
  <script src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "js/core/jquery.3.2.1.min.js" ?>></script>
  <script src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "js/core/popper.min.js" ?>></script>
  <script src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "js/core/bootstrap.min.js" ?>></script>
  <script src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "js/now-ui-kit.js?v=1.1.0" ?>></script>
  <script src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "js/aos.js" ?>></script>
  <script src=<?php echo "/" . CARPETA_RAIZ . RUTA_ASSETS . "cv/" . "scripts/main.js" ?>></script>
</body>

</html>