<?php
namespace App\Api;

class MSSQL {
  private $conn;
  private static $serverName;
  private static $database;
  private static $uid;
  private static $pwd;
  function __construct($params) {
    list($serverName, $database, $uid, $pwd) = $params;
    self::$serverName = $serverName;
    self::$database = $database;
    self::$uid = $uid;
    self::$pwd = $pwd;
    $this->connect();
  }
  private function connect() {
    try {
        $this->conn = new \PDO(
            "sqlsrv:server=".self::$serverName.";Database=".self::$database,
            self::$uid,
            self::$pwd,
            [ \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION ]
        );
    } catch(PDOException $e) {
        die("MSSQL connection not established: " . $e->getMessage());
    }
    return null;
  }
  public function query($query) {
    $result = [];
    $stmt = $this->conn->query( $query );
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
  }
  public function queryFirst($query) {
    $stmt = $this->conn->query( $query );
    $result[] = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }
}
?>
