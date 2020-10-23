<?php
    namespace App\Models;
    use MF\Model\Model;
use PDOException;

class Usuario extends Model{
        private $id;
        private $nome;
        private $email;
        private $senha;


        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }


        //. Salvar 


        public function salvar() {

            //*query que vai ser encaminhada para o banco de dados
            $query = "insert into 
                        usuarios(nome, email, senha) 
                    values 
                        (:nome, :email, :senha)
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            return $this;        
        }


        //. Validar se um cadastro pode ser feito 
        public function validarCadastro() {

            $valido = true;            
            $nome = $this->__get('nome');            
            $senha = $this->__get('senha');
            $email = $this->__get('email');

            $naoTemArroba = false;
            $usuarioNull = false;

            if(strpos($email, '@') === false){
                $naoTemArroba = true;
            }

            if(strlen($nome) < 5) {
                $valido = false;
            }

            if($email === null){
                $usuarioNull = true;
            }

            if(strlen($senha) < 5) {            
                $valido =false;    
                
            }           
            

            $erros = ['usuarioNull'=>$usuarioNull, 'valido'=>$valido, 'naotemArroba'=>$naoTemArroba];
            
            return $erros;
        }

        //. Recuperar um usuário por e-mail para verificar se ja existe 
        public function getUsuarioPorEmail($email) {
            $query = 'select 
                        nome, email 
                    from 
                        usuarios 
                    where 
                        email = :email                   
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $soma = $stmt->rowCount();   

            $resultado = 0;
            if($soma > 0) {
                $resultado = 'Encontrado';
            }else {
                $resultado = 'email valido';
            }

            return $resultado;            
        }
        
        
        
    }    
    

?>