<?php

namespace App\Controllers;



//*Recursos do miniframework

use App\Models\Usuario;
use MF\Controller\Action;
use MF\Model\Container;


class  IndexController extends Action {    

    public function index() {
        
        $this->render('index');
    }


    public function inscreverse() {

        

        $this->view->espacoVazio = false;
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
    
    public function registrar() {
                
        //# Sucesso 
        //* Aqui cria uma variavel que instancia a classe Usuario
        $usuario = Container::getModel('Usuario');

        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $_POST['senha']);

        $erro = $usuario->validarCadastro();

        $valido = $erro['valido'];
        $espacoVazio = $erro['espacoVazio'];
        $arrobaFaltando = $erro['arrobaFaltando'];
        
        
        $usuarioPoremail = $usuario->getUsuarioPorEmail();
        
        if ($valido && count($usuarioPoremail) == 0 && $arrobaFaltando == false && $espacoVazio == false) {
            $usuario1;
            $usuario->salvar();

            $this->render('cadastro');


        } else {

            $this->view->usuario = [
                'nome' => $_POST['nome'],
                'senha' =>$_POST['senha'],
                'email' =>$_POST['email']
            ];

            $this->view->espacoVazio = false;
            $this->view->arrobaFaltando = false;
            $this->view->valido = true; 
            $this->view->usuarioExistente = false;

            //* Se o usuario existir
            if(count($usuarioPoremail) > 0) {
                $this->view->usuarioExistente = true;
                
            }
            //* se o campo é valido 
            if($valido == false){
                $this->view->valido = false;
                $this->view->usuarioExistente = false;
                
            }
            
            //* verificar espaços vazios
            if($espacoVazio){
                $this->view->espacoVazio = true;
                $this->view->usuarioExistente = false;

            }

            //* verifica se o email é valido
            if($arrobaFaltando){
                $this->view->arrobaFaltando = true;
                $this->view->usuarioExistente = false;

            }            

            $this->render('inscreverse');

        }


        //# Erro 
    }

}


?>