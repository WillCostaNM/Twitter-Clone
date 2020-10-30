<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class  AppController extends Action {

    public function timeline(){        

        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);
        $tweets = $tweet->getAll();
        $this->view->tweets = $tweets;


        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $this->view->infoUsuario = $usuario->getInfoUsuario();
        $this->view->totalTweets = $usuario->getTotalTeets();
        $this->view->totalSeguindo = $usuario->getTotalSeguindo();
        $this->view->totalSeguidores = $usuario->getTotalSeguidores();

        $this->render('timeline','layout');
    }

    public function removerTweet(){

        $this->validaAutenticacao();

        $idTweet = isset($_GET['id']) ? $_GET['id'] : '';
        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);
        $tweet->removerTweet($idTweet);
        header('Location: /timeline');

    }

    public function tweet(){
        
        $this->validaAutenticacao();
        $tweet = Container::getModel('Tweet');
        $tweet->__set('tweet', $_POST['tweet']);        
        $tweet->__set('id_usuario', $_SESSION['id']);
        $tweet->salvar();
        
        $ultimoTweet = $tweet->getultimo();
        echo json_encode($ultimoTweet);
    }

    public function quemSeguir() {
        
        $this->validaAutenticacao();

		$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';
		
		$usuarios = array();

		if($pesquisarPor != '') {

			$usuario = Container::getModel('Usuario');
			$usuario->__set('nome', $pesquisarPor);
			$usuario->__set('id', $_SESSION['id']);
			$usuarios = $usuario->getAll();

        }
		$usuario = Container::getModel('Usuario');
        
        $usuario->__set('id', $_SESSION['id']);
        $this->view->infoUsuario = $usuario->getInfoUsuario();
        $this->view->totalTweets = $usuario->getTotalTeets();
        $this->view->totalSeguindo = $usuario->getTotalSeguindo();
        $this->view->totalSeguidores = $usuario->getTotalSeguidores();
		$this->view->usuarios = $usuarios;
        
       $this->render('quemSeguir','layout');
    }

    public function acao() {

		$this->validaAutenticacao();
		$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
		$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

		$usuario = Container::getModel('Seguir');
		$usuario->__set('id', $_SESSION['id']);

		if($acao == 'seguir') {
            $usuario->seguirUsuario($id_usuario_seguindo);

		} else if($acao == 'deixar_de_seguir') {
			$usuario->deixarSeguirUsuario($id_usuario_seguindo);
		}

		header('Location: /quem_seguir');
    }

    
    public function remover(){
        
        $this->validaAutenticacao();
        $id = $_SESSION['id'];
        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_tweet', $_POST['id_tweet']);

        $resultado = $tweet->removerTweet2($id);
        echo $resultado;
    }
    

    public function validaAutenticacao(){

        session_start();
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){

            header('Location: /?login=erro');

        }
    }


    

    
}

?>