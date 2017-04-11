<?php
namespace Core;

use PDO;
use PDOException;

class dbpdo
{
  public $pdo;

  public function __construct()
  {
    try {
      $db = Array(
        'dsn' => 'mysql:host=localhost;dbname=audio;charset=utf8'
      );
      $options = Array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      );
      $this->pdo = new PDO($db['dsn'], 'root', 'root', $options);
    } catch (PDOException $e) {
      die('连接数据库失败' . $e->getMessage());
    }
  }

  //////////////////插入数据封装
  public function insert($table, $data)
  {
    ///////////////////////
    $sql = "insert into {$table} (";
    foreach ($data as $k => $v) {
      $sql .= $k . ',';
    }
    $sql = substr($sql, 0, -1);
    $sql .= ") values(";
    foreach ($data as $k => $v) {
      $sql .= '?,';
    }
    $sql = substr($sql, 0, -1);
    $sql .= ")";
    ////////////////////////////

    $con = $this->pdo->prepare($sql);

    for ($i = 1; $i <= count($data); $i++) {
      $con->bindValue($i, array_values($data)[$i - 1]);
    }
    //////////////////////////////
    try {
      $con->execute();
      return true;
    } catch (PDOException $e) {
      die('sql语句执行失败' . $e->getMessage());
    }
  }

  ///////////////////////// 获取所有符合sql查询的数据
  public function fetchAll($sql)
  {
    $con = $this->pdo->prepare($sql);
    try {
      $con->execute();//
      return $con->fetchAll();
    } catch (PDOException $e) {
      die('sql语句执行失败' . $e->getMessage());
    }
  }

  ////////////////////////获取一条符合sql查询的数据
  public function fetch($sql)
  {
    $con = $this->pdo->prepare($sql);
    try {
      $con->execute();//
      return $con->fetch();
    } catch (PDOException $e) {
      die('sql语句执行失败' . $e->getMessage());
    }
  }

  //////////////// 按条件更新某表的数据
  public function update($table, $where, $data)
  {
    $sql = 'update ' . $table . ' set ';
    foreach ($data as $k => $v) {
      $sql .= $k . ' = ? ,';
    }
    $sql = substr($sql, 0, -1);
    $sql .= ' where ';
    foreach ($where as $k => $v) {
      $sql .= $k . ' = ?';
    }
    $con = $this->pdo->prepare($sql);

    for ($i = 1; $i <= count($data); $i++) {
      $con->bindValue($i, array_values($data)[$i - 1]);
    }
    $con->bindValue($i, array_values($where)[0]);

    try {
      return $con->execute();
    } catch (PDOException $e) {
      die('语句执行错误' . $e->getMessage());
    }
  }

  ////////////////根据条件删除表中的数据
  public function delete($table, $where)
  {
    $sql = "delete from {$table} where ";
    foreach ($where as $k => $v) {
      $sql .= $k . ' = ' . $v;
    }
    try {
      return $this->pdo->exec($sql);
    } catch (PDOException $e) {
      die('sql语句执行失败' . $e->getMessage());
    }
  }

}
