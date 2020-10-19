<?php

    namespace App;

use PDO;
use PDOException;

class Connection {
        public static function getDb() {

            try {
                $conexao = new \PDO(
                    "mysql:host=localhost;dbname=twitter_clone;charset=utf8",
                    "root",
                    ""
                );
                
                return $conexao;

            } catch (\PDOException $e) {

                echo '<p>' . $e .'</p>';
            }
        }
    }


?>