<?php

interface IConnectInfo{
	const HOST="localhost";
	const USER="root";
	const DB="php-practice";
	const PASS="secret";
	function testConnection();
}

class ConSQL implements IConnectInfo{
// in short, interfaces support constants
private $host=IConnectInfo::HOST;
private $user=IConnectInfo::USER;
private $db=IConnectInfo::DB;
private $pass=IConnectInfo::PASS;

public function testConnection(){
	$dsn="mysql:host={$this->host};dbname={$this->db}; charset=utf8";
	$db = new PDO($dsn,
	"{$this->user}",
	"{$this->pass}"
	);
	return $db;
} 
}

$useConstant=new ConSQL();
$pdo=$useConstant->testConnection();

$statement=$pdo->prepare("SELECT * FROM products WHERE id=?;");
$result=$statement->execute(array(1));
$row=$statement->fetch();

print_r($row);
 ?>
