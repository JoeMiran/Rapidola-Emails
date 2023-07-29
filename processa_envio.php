<?php

require "./LibPHP/PHPMailer/Exception.php";
require "./LibPHP/PHPMailer/OAuth.php";
require "./LibPHP/PHPMailer/PHPMailer.php";
require "./LibPHP/PHPMailer/POP3.php";
require "./LibPHP/PHPMailer/SMTP.php";

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

if($mensagem->mensagemValida()) { //Verificando se a mensagem é válida
    echo '<p>Mensagem válida</p>';
} else {
    echo '<p>Mensagem inválida</p>';
}

