<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public array $email;
    public array $nombre;
    public $proveedor;

    public function __construct($email, $nombre, $proveedor)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->proveedor = $proveedor;
    }

    public function enviarConfirmacion()
    {


        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom($_ENV['EMAIL_USER'], $this->proveedor->usuario);

        for ($i = 0; $i < count($this->email); $i++) {
            $mail->addAddress($this->email[$i], $this->nombre[$i]);


            $mail->Subject = 'Solicitud para Subir de Nivel (Ferretinoco)';

            // Set HTML
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            $contenido = '<html>';
            $contenido .= "<p><strong>Hola " . $this->nombre[$i] .  "</strong> soy el usuario: <strong>" . $this->proveedor->usuario . "</strong> necesito subir mi nivel de acceso.</p>";
            $contenido .= "<p>Presiona aquí:  <a href='". $_ENV['HOST']."/subirNivel?token=".$this->proveedor->token."'> Subir Nivel </a> </p>";
            $contenido .= '</html>';
            $mail->Body = $contenido;

            //Enviar el mail
            $mail->send();
                
            
        }
    }
}
