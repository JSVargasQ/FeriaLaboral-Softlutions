<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//$rutaLib = $_SERVER['DOCUMENT_ROOT'] . "/softlutions/Negocio/lib/PHPMailer/";

require "Exception.php";
require "PHPMailer.php";
require "SMTP.php";

/**
 * Clase encargada de enviar correos pro medio de la libreria PHPMailer
 */
class EnvioCorreo
{
    //----------------------------------
    // Atributos
    //----------------------------------

    const NOMBRE_FERIA = "FERIA DE OPORTUNIDADES - UEB";
    const CORREO_FERIA = "feriaoportunidadtestmail@gmail.com";
    const CONTRASEÑA_FERIA = "123456789Abc";

    private $correoDestinatario;
    private $asunto;
    private $destinatario;
    private $mensaje;

    private $mail;


    //----------------------------------
    // Constructor
    //----------------------------------

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        try {
            //Server settings
            $this->mail->SMTPDebug = 0;                      // Enable verbose debug output
            $this->mail->isSMTP();                                            // Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mail->Username   = self::CORREO_FERIA;                     // SMTP username
            $this->mail->Password   = self::CONTRASEÑA_FERIA;                 // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $this->mail->setFrom(self::CORREO_FERIA, self::NOMBRE_FERIA);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }


    //----------------------------------
    // Metodos
    //----------------------------------


    public function prepararCorreo(String $pCorreoDestinatario, String $pAsunto, String $pMensaje)
    {
        $this->setCorreoDestinatario($pCorreoDestinatario);
        $this->setAsunto($pAsunto);
        $this->setMensaje($pMensaje);
    }

    public function enviarCorreo()
    {
        try {

            $this->mail->addAddress($this->correoDestinatario);     // Add a recipient

            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $this->asunto;   // ASUNTO
            $this->mail->Body    = $this->mensaje;  // MENSAJE

            $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }


    /**
     * Método para obtener el correo del destinatario
     * 
     * @return String
     */
    public function getCorreoDestinatario()
    {
        return $this->correoDestinatario;
    }

    /**
     * Método para establecer el correo del destinatario
     * 
     * @return String
     */
    public function setCorreoDestinatario(String $pCorreoDestinatario)
    {
        $this->correoDestinatario = $pCorreoDestinatario;
    }

    /**
     * Método para obtener el asunto del correo
     * 
     * @return String
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Método para establecer el asunto del correo
     * 
     * @return String
     */
    public function setAsunto(String $pAsunto)
    {
        $this->asunto = $pAsunto;
    }

    /**
     * Método para obtener el nombre del destinatario
     * 
     * @return String
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Método para establecer el correo del destinatario
     * 
     * @return String
     */
    public function setDestinatario(String $pDestinatario)
    {
        $this->destinatario = $pDestinatario;
    }

    /**
     * Método para obtener el mensaje del correo
     * 
     * @return String
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Método para establecer el mensaje del correo
     * 
     * @return String
     */
    public function setMensaje(String $pMensaje)
    {
        $this->mensaje = $pMensaje;
    }
}