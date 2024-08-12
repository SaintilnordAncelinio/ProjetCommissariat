<?php
abstract class Database {
    private $servername;
    private $username;
    private $dbname;
    private $pwd;
    private static $db;

    public function __construct($dbname, $servername = 'localhost', $username = 'root', $pwd = '') {
        $this->dbname = $dbname;
        $this->servername = $servername;
        $this->username = $username;
        $this->pwd = $pwd;
    }

    public static function getConnect() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO('mysql:host=localhost;dbname=gestion_commissariat', 'root', '');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
            }
        }
        return self::$db;
    }
}
?>
