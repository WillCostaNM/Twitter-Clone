<?php
    namespace MF\Init;

    abstract class Bootstrap {
        private $routes;

        abstract protected function initRoutes();
        
        //* FUNÇÃO CONSTRUTORA QUE É CHAMADA AUTOMATICAMENTE QUANDO A CLASSE ROUTE FOR INSTANCIADA
        public function __construct() {

            //* A FUNÇÃO CONSTRUTORA PORTANTO IRÁ SETAR O VALOR DA VARIAVEL $ROUTES USANDO OUTRA FUNÇÃO
            $this->initRoutes();


            //* A FUNÇÃO CONSTRUTORA TAMBÉM IRÁ EXECUTAR OUTRA FUNÇÃO(RUN) QUE ESPERA RECEBER INCLUSIVE OUTRA FUNÇÃO(GETURL), ESSA FUNÇÃO GETURL() RETORNA O PATH DA URL REQUISITADA PELO USUÁRIO, PORTANTO PATH É ENVIADO COMO PARÂMETRO DA FUNÇÃO RUN

            //*--------------------------------------------------------------- 
    
            //* A FUNÇÃO RUN() VERIFICA SE A ROTA DIGITADA PELO USUÁRIO EXISTE, SE EXISTIR ELE EXECUTA OUTRO MÉTODO DA CLASSE DO CONTROLLER ESSE MÉTODO TAMBÉM É CHAMADO DE AÇÃO
            $this->run($this->getUrl());
        }

        public function setRoutes(array $routes) {
            $this->routes = $routes;
        }

        public function getRoutes() {
            return $this->routes;
        }

        protected function run($url) {
            foreach ($this->getRoutes() as $key => $rota) {   
                
                
                if($url == $rota['route']){
                    $class = "App\\Controllers\\" . ucfirst($rota['controller']);
                    $controller = new $class;
                    $action = $rota['action'];
                    $controller->$action();
                }
            }
        }

        protected function getUrl() {
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

    }

?>