<?php
class Contacto {
    private $conn;
    private $table_name = "contactos";

    public $id;
    public $nombre;
    public $email;
    public $telefono;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, telefono) VALUES (:nombre, :email, :telefono)";
        $stmt = $this->conn->prepare($query);

        
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));

        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefono", $this->telefono);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}