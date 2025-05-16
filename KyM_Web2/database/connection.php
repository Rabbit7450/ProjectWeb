<?php

class Database {
    private static $instance = null;
    private $client;
    private $database;

    private function __construct() {
        try {
            // URL de conexión a MongoDB Atlas
            $uri = "mongodb+srv://adalittic:kRsn3d7UEHU2kG1f@cluster0.o6thbwx.mongodb.net/";
            
            // Crear una nueva instancia del cliente MongoDB
            $this->client = new MongoDB\Client($uri);
            
            // Seleccionar la base de datos (puedes cambiar 'kym_db' por el nombre de tu base de datos)
            $this->database = $this->client->selectDatabase('kym_db');
            
        } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            die("Error de conexión a MongoDB: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error general: " . $e->getMessage());
        }
    }

    // Método para obtener la instancia única (Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para obtener la conexión a la base de datos
    public function getDatabase() {
        return $this->database;
    }

    // Método para obtener una colección específica
    public function getCollection($collectionName) {
        return $this->database->selectCollection($collectionName);
    }

    // Prevenir la clonación del objeto
    private function __clone() {}

    // Prevenir la deserialización del objeto
    public function __wakeup() {
        throw new Exception("No se puede deserializar un singleton.");
    }
}

// Ejemplo de uso:
/*
try {
    $db = Database::getInstance();
    $collection = $db->getCollection('nombre_coleccion');
    
    // Ejemplo de inserción
    $result = $collection->insertOne([
        'nombre' => 'Ejemplo',
        'fecha' => new MongoDB\BSON\UTCDateTime()
    ]);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
*/ 