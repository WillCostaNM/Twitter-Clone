<?php
namespace App\Models;
use MF\Model\Model;
use PDOException;

class Seguir extends Model{
    private $id;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;      
    }

    public function seguirUsuario($id){

        $query = 'insert into
                    usuarios_seguidores
                    (id_usuario, id_usuario_seguindo)
                values
                    (:id_usuario, :id_usuario_seguindo)
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id);
        $stmt->execute();

        return true;
    }

    public function deixarSeguirUsuario($id){

        $query = 'delete from
                    usuarios_seguidores
                where
                    id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo
        ';
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id);
        $stmt->execute();

        return true;

    }
        
}


?>