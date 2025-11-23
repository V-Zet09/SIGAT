<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_USER', 'Admin_Zaet'); 
define('DB_PASS', 'Zaet123octubre'); 
define('DB_NAME', 'SIGAT'); 

function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>