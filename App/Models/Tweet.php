<?php
    
namespace App\Models;
use MF\Model\Model;


class Tweet extends Model{

    private $id;
    private $id_usuario;
    private $tweet;
    private $data;  
    private $id_tweet;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    //* SALVAR TWEET NO BANCO DE DADOS
    public function salvar(){
        $query ='insert into 
                    tweets
                        (id_usuario, tweet)
                    values
                        (:id_usuario, :tweet)
        ';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':tweet', $this->__get('tweet'));
        $stmt->execute();

        return $this;
    }


    //*RECUPERAR TWEET
    public function getAll(){

        $query =" select
                    t.id, 
                    t.id_usuario, 
                    t.tweet, 
                    DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data, u.nome
                from
                    tweets as t
                    left join usuarios as u on (t.id_usuario = u.id)
                where
                    t.id_usuario = :id_usuario
                    or t.id_usuario in (select id_usuario_seguindo from usuarios_seguidores where id_usuario = :id_usuario)
                order by
                    t.data desc
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getultimo(){
        $query =" select
                    t.id, t.id_usuario, t.tweet, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data, u.nome
                from
                    tweets as t
                    left join usuarios as u on (t.id_usuario = u.id)
                where
                    id_usuario = :id_usuario
                order by
                    t.data desc limit 1
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function removerTweet($id){
        
        $query = 'delete from 
                tweets
            where
                id = :id_tweet and id_usuario = :id_usuario
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindvalue(':id_tweet',$id );
        $stmt->bindvalue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return 'excluido';                
    }

    public function removerTweet2($id){
        
        $query = 'delete from 
                tweets
            where
                id = :id_tweet and id_usuario = :id_usuario
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindvalue(':id_tweet', $this->__get('id_tweet'));
        $stmt->bindvalue(':id_usuario', $id);
        $stmt->execute();

        return 'excluido';
    }


}
?>