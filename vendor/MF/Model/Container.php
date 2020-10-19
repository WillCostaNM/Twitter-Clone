<?php

    //; CONTAINER QUE INSTANCIA A CLASSE ENVIADA COMO PARAMETRO 
    namespace MF\Model;
    use App\Connection;

    class Container {
        public static function getModel($model) {

            $class = "\\App\\Models\\".ucfirst($model);
            $connect= Connection::getDb();
            return new $class($connect);

            //*class=  "\\App\\Models\\Usuario";
            //* $connect= Connection::getDb();

            //*return new \\App\\Models\\Usuario(conexao)
            
        }
    }


?>