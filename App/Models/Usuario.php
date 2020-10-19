<?php
    namespace App\Models;
    use MF\Model\Model;

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
            $espacoVazio = false;            
            $arrobaFaltando = false;
            $nome = $this->__get('nome');
            $email = $this->__get('email');
            $senha = $this->__get('senha');


            //# Verificar se ha esaços vazios 
            if(strlen($nome) == 0 || strlen($email) == 0 || strlen($senha) == 0){
                $espacoVazio = true;
            }            
                       
            
            
            if (strlen($email) < 9 || strpos($email, '@') === false){
                $arrobaFaltando = true;
            }

            
            if(strlen($senha) < 5) {                
                $valido =false;
                
            }         

            
            

            $erros = ['valido'=>$valido, 'espacoVazio' => $espacoVazio, 'arrobaFaltando' => $arrobaFaltando];
            
            return $erros;
        }

        //. Recuperar um usuário por e-mail para verificar se ja existe 
        public function getUsuarioPorEmail() {
            $query= 'select 
                        nome, email 
                    from 
                        usuarios 
                    where 
                        email = :email                   
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

    


?>