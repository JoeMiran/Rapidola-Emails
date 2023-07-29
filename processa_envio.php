<?php

//incluindo os arquivos da biblioteca
require "./LibPHP/PHPMailer/Exception.php";
require "./LibPHP/PHPMailer/OAuth.php";
require "./LibPHP/PHPMailer/PHPMailer.php";
require "./LibPHP/PHPMailer/POP3.php";
require "./LibPHP/PHPMailer/SMTP.php";

//Adicionando namespaces
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

class Mensagem {  //Definindo a classe Mensagem

    // Definindo os atributos da classe mensagem com base na view da aplicação
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    //Definindo os métodos especiais getter e setter
    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    //Definindo o método para validar a mensagem
    public function mensagemValida() {

        if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        } else {
            return true;            
        }
    }

}

$mensagem = new Mensagem();//Criando um novo objeto mensagem

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if(!$mensagem->mensagemValida()) { //Verificando se a mensagem é válida
    echo '<p>Mensagem não é válida</p>';
    die();
} 

$mail = new PHPMailer(true);
try {
        //Server settings
        $mail->SMTPDebug = 2;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'testeemai876@gmail.com';               //SMTP username
        $mail->Password   = 't3st&senh@';                           //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
} catch (Exception $e) {
        echo "Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde.";
        echo 'Detalhes do erro: ' . $mail->ErrorInfo;
}


