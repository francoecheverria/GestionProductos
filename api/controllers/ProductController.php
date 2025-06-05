<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $product;
    
    public function __construct() {
        $this->product = new Product();
    }
    
    private function getUsdValue() {
        $usdValue = getenv('PRECIO_USD');
        if (!$usdValue || !is_numeric($usdValue) || $usdValue <= 0) {
            return 1;
        }
        return (float)$usdValue;
    }
    
    private function addUsdPrice($product) {
        $usdValue = $this->getUsdValue();
        //var_dump($usdValue);
        $product['precio_usd'] = round($product['precio'] / $usdValue, 2);
        return $product;
    }
    
    public function getAll() {
        try {
            $products = $this->product->getAll();
            $productsWithUsd = array_map([$this, 'addUsdPrice'], $products);
            $this->sendResponse(200, $productsWithUsd);
        } catch (Exception $e) {
            $this->sendResponse(500, ['error' => $e->getMessage()]);
        }
    }
    
    public function getById($id) {
        try {
            $product = $this->product->getById($id);
            if ($product) {
                $product = $this->addUsdPrice($product);
                $this->sendResponse(200, $product);
            } else {
                $this->sendResponse(404, ['error' => 'Producto no encontrado']);
            }
        } catch (Exception $e) {
            $this->sendResponse(500, ['error' => $e->getMessage()]);
        }
    }
    
    public function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['nombre']) || !isset($data['precio'])) {
                $this->sendResponse(400, ['error' => 'Datos incompletos']);
                return;
            }
            
            $id = $this->product->create($data);
            $newProduct = $this->product->getById($id);
            $newProduct = $this->addUsdPrice($newProduct);
            $this->sendResponse(201, $newProduct);
        } catch (Exception $e) {
            $this->sendResponse(500, ['error' => $e->getMessage()]);
        }
    }
    
    public function update($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $affectedRows = $this->product->update($id, $data);
            if ($affectedRows > 0) {
                $updatedProduct = $this->product->getById($id);
                $updatedProduct = $this->addUsdPrice($updatedProduct);
                $this->sendResponse(200, $updatedProduct);
            } else {
                $this->sendResponse(404, ['error' => 'Producto no encontrado']);
            }
        } catch (Exception $e) {
            $this->sendResponse(500, ['error' => $e->getMessage()]);
        }
    }
    
    public function delete($id) {
        try {
            $affectedRows = $this->product->delete($id);
            if ($affectedRows > 0) {
                $this->sendResponse(200, ['message' => 'Producto eliminado']);
            } else {
                $this->sendResponse(404, ['error' => 'Producto no encontrado']);
            }
        } catch (Exception $e) {
            $this->sendResponse(500, ['error' => $e->getMessage()]);
        }
    }
    
    private function sendResponse($statusCode, $data) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}