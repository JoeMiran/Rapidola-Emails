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
    public $status = array('codigo_status' => null, 'descricao_status' => null);

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
    header('Location: index.php');
    die();
} 

$mail = new PHPMailer(true);
try {
        //Server settings
        $mail->SMTPDebug = false;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'testeemai876@gmail.com';               //SMTP username
        $mail->Password   = 'zbchwsunlzqdwjaf';                     //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('testeemai876@gmail.com', 'Teste DESTINATARIO');
        $mail->addAddress($mensagem->__get('para'));     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem-> __get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['descricao_status'] = 'E-mail enviado com succcesso!';

} catch (Exception $e) {
    $mensagem->status['codigo_status'] = 2;
    $mensagem->status['descricao_status'] = 'Falha ao enviar o e-mail' . $mail->ErrorInfo ;
}

?>

<html>
    <head>
    <meta charset="utf-8" />
    	<title>Rapidola Email</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>

        <div class="container">
            <div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="img/logo.png" alt="" width="72" height="72">
				<h2>Rapidola</h2>
				<p class="lead">Enviei seu email de forma mais objetiva com o Rapidola email</p>
			</div>
            <div class="row">
				<div class="col-md-12">

					<?php if($mensagem->status['codigo_status'] == 1) { ?>

						<div class="container">
							<h1 class="display-4 text-success">Sucesso</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>

					<?php } ?>

					<?php if($mensagem->status['codigo_status'] == 2) { ?>

						<div class="container">
							<h1 class="display-4 text-danger">Ops!</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>

					<?php } ?>

				</div>
            </div>
        </div>

    </body>
</html>


