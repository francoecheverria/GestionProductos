<?php
class Product {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll() {
        $query = $this->db->query("SELECT * FROM productos");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $query = $this->db->prepare(
            "INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)"
        );
        $query->execute([$data['nombre'], $data['descripcion'], $data['precio']]);
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $query = $this->db->prepare(
            "UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?"
        );
        $query->execute([$data['nombre'], $data['descripcion'], $data['precio'], $id]);
        return $query->rowCount();
    }
    
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }
}