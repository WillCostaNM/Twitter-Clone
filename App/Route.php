<?php
    namespace App;
    use MF\Init\Bootstrap;

    class Route extends Bootstrap {

        protected function initRoutes() {

            $routes['home'] = [
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'

            ];
            
            $routes['inscreverse'] = [
                'route' => '/inscreverse',
                'controller' => 'indexController',
                'action' => 'inscreverse'

            ];
            
            $routes['registrar'] = [
                'route' => '/registrar',
                'controller' => 'indexController',
                'action' => 'registrar'

            ];

            $routes['email'] = [
                'route' => '/getEmail',
                'controller' => 'indexController',
                'action' => 'getEmail'
            ];
            
            $routes['autenticar'] = [
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            ];

            $routes['timeline'] = [
                'route' => '/timeline',
                'controller' => 'AppController',
                'action' => 'timeline'
            ];

            $routes['sair'] = [
                'route' => '/sair',
                'controller' => 'AuthController',
                'action' => 'sair'
            ];

            $routes['tweet'] = [
                'route' => '/tweet',
                'controller' => 'AppController',
                'action' => 'tweet'
            ];
            
            $routes['conteudo'] = [
                'route' => '/conteudo',
                'controller' => 'AppController',
                'action' => 'conteudo'
            ];

            $routes['quem_seguir'] = [
                'route' => '/quem_seguir',
                'controller' => 'AppController',
                'action' => 'quemSeguir'
            ];

            


            $this->setRoutes($routes);
        }

        

        
        
    }

?>