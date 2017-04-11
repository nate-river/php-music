<?php
namespace App\model;

use Core\dbpdo;

class UserModel extends dbpdo
{
  public function __construct()
  {
    parent::__construct();
  }

  /////////// 账号密码验证
  public function check($account, $password)
  {
    $r = $this->fetchAll('select * from user');
    if ($account === $r[0]['account'] && $password === $r[0]['password']) {
      return true;
    } else {
      return false;
    }
  }
}