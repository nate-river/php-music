<?php

namespace App\controller;

use App\model\MusicModel;
use Core\Framework;

require MODEL . 'MusicModel.php';

class indexController extends Framework
{
  /////// ajax 获取新一页
  public function get_more()
  {
    $m = new MusicModel();
    $this->json($m->getAlbumByPage($_GET['page'], 5));
  }

  ////// ajax获取某张专辑下的歌曲
  public function get_music()
  {
    $album_id = $_GET['albumId'];
    $m = new MusicModel();
    $this->json($m->getMusic($album_id));
  }

  ///// 前台首页
  public function index()
  {
    $m = new MusicModel();
    $page = 1;
    $size = 5;
    $this->assign('num', ceil($m->count('album') / $size));
    $this->assign('album', $m->getAlbumByPage($page, $size));
    $this->display('default/index.html');
  }
}