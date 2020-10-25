<?php
namespace App\Controllers;
session_start();




//*Recursos do miniframework

use MF\Controller\Action;
use MF\Model\Container;


class  IndexController extends Action { 
       

    public function index() {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('index');
    }


    public function inscreverse() {
        
        $this->view->emailCadastrado = false;
        $this->view->arrobaFaltando = false;
        $this->view->valido = true; 
        $this->view->usuarioExistente = false;

        $this->view->usuario = [
            'nome' => '',
            'senha' =>'',
            'email' =>''

        ];

        $this->render('inscreverse');
        
        
    }
  

    //* AQUI ESTÁ A ROTA DO MÉTODO AJAX JQUERY QUE VERIFICA SE O USUÁRIO JA FOI CADASTRADO, ASSIM ENVIANDO UMA RESPOSTA PARA UM MELHOR FEEDBACK VISUAL
    public function getEmail() {

        $emailString = $_POST;
        $string = implode($emailString);
        $usuario = Container::getModel('Usuario');
        $email = $usuario->getUsuarioPorEmail($string);

        if($email !== 'Encontrado'){
            $_SESSION['email'] = $string;
        }else{
            $_SESSION['email'] = null;
            echo 'Encontrado';
        }           
        
        

    }

    //* AQUI É A FUNÇÃO QUE REGISTRA E TAMBÉM VERIFICA SE O USUÁRIO JÁ FOI CADASTRADO, SÓ QUE AGR VERIFICADO PELA PARTE DO SERVIDOR, POIS SE O USUÁRIO JA EXISTE O MESMO NÃO É CADASTRADO
    public function registrar() {

        $email = $_SESSION['email'];
        
                
        //# Sucesso 
        // //* Aqui cria uma variavel que instancia a classe Usuario        
        $usuario = Container::getModel('Usuario');
        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $email);
        $usuario->__set('senha', md5($_POST['senha']));
        
        $emailDigitado = $usuario->getUsuarioPorEmail($email);

        $emailExistente = false;

        if($emailDigitado == 'Encontrado'){
            $emailExistente = true;
        }       
        
        $erro = $usuario->validarCadastro();

        $valido = $erro['valido'];        
        $naoTemArroba = $erro['naotemArroba'];                 
        $usuarioNull = $erro['usuarioNull'];
        
        
        if ($emailExistente == false && $valido && $naoTemArroba === false && $usuarioNull === false) {
            
            $usuario->salvar();
            $this->render('cadastro');

        } else {

            if($emailExistente){                
                $this->view->emailCadastrado = true;
                

            }else{
                $this->view->emailCadastrado = false;

            }


            $this->view->usuario = [
                'nome' => $_POST['nome'],
                'senha' =>$_POST['senha'],
                'email' =>$_POST['email']
            ];            
            

            $this->render('inscreverse');
            
            
        }


        //# Erro 
    }

    
    
    

}


?>