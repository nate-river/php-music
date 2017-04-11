<?php
namespace App\model;

use Core\dbpdo;

class MusicModel extends dbpdo
{

  public function __construct()
  {
    parent::__construct();
  }

  //////////////////获取某张表中一共有多少数据////////////////////
  public function count($table)
  {
    $con = $this->pdo->prepare('select count(*) as num from ' . $table);
    $con->execute();
    return $con->fetch()['num'];
  }

  /////////////////////对专辑的各种操作
  public function getAllAlbum()
  {
    return $this->fetchAll('select * from album');
  }

  public function getAlbumByPage($page, $size)
  {
    $con = $this->pdo->prepare('select * from album order by id desc limit ' . $size . ' offset ' . ($page - 1) * $size);
    $con->execute();
    return $con->fetchAll();
  }

  public function addAlbum($data)
  {
    return $this->insert('album', $data);
  }

  public function deleteAlbumById($id)
  {
    $where = Array(
      'id' => $id
    );
    return $this->delete('album', $where);
  }

  public function getAlbumById($id)
  {
    return $this->fetch("select * from album where id = {$id}");
  }

  public function updateAlbum($id, $data)
  {
    $where = Array(
      'id' => $id
    );
    return $this->update('album', $where, $data);
  }

  ///////////////////对音乐的各种操作////////////////////////////
  public function getMusicById($id)
  {
    return $this->fetch("select * from music where id = {$id}");
  }

  public function getMusic($id)
  {
    return $this->fetchAll('select * from music where album_id = ' . $id);
  }

  public function addMusic($data)
  {
    return $this->insert('music', $data);
  }
}

