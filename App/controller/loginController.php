<?php

namespace App\controller;

use App\model\UserModel;
use Core\Framework;

class loginController extends Framework
{
  /////////////////////////////登录页面
  public function index()
  {
    if (isset($_COOKIE['login'])) {
      $this->session('login', true);
      $this->redirect('/admin');
    } else {
      $this->display('admin/login.html');
    }
  }

  //////////////////////////退出登录//////////
  public function logout()
  {
    session_start();
    unset($_SESSION['login']);
    setcookie('login', '', time() + 3600, '/');
    $this->redirect('/login');
  }

  ///////////////////////账号密码验证///////////////
  public function check()
  {
    $account = $_POST['user'];
    $password = md5($_POST['password']);
    require MODEL . 'UserModel.php';
    $m = new UserModel();
    if ($m->check($account, $password)) {
      $this->session('login', true);
      if (isset($_POST['check'])) {
        setcookie('login', 'true', time() + 3600, '/');
      }
      $this->redirect('/admin');
    } else {
      $this->assign('info', '账号密码错误');
      $this->assign('url', '/login');
      $this->display('admin/error.html');
    }
  }
}