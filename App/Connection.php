<?php

    namespace App;

use PDO;
use PDOException;

class Connection {
        public static function getDb() {

            try {
                $conexao = new \PDO(
                    "",
                    "",
                    ""
                );
                
                return $conexao;

            } catch (\PDOException $e) {

                echo '<p>' . $e .'</p>';
            }
        }
    }


?>
