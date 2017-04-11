<?php
namespace App\controller;

use App\model\MusicModel;
use Core\Framework;

require MODEL . 'MusicModel.php';

class adminController extends Framework
{
  ////////////////////////////////////////////////
  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['login'])) {
      $this->redirect('/login');
    }
  }

  ////////////////////后台首页//////////////////////
  public function index()
  {
    $m = new MusicModel();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $size = 5;
    $num = ceil($m->count('album') / $size);

    $_SESSION['page'] = $page;
    $this->assign('page', $this->findPage($page, $num, '/admin'));
    $this->assign('album', $m->getAlbumByPage($page, $size));
    $this->display('admin/index.html');
  }


  //////////////////添加专辑////////////////////////
  public function add_album()
  {
    $this->display('admin/add_album.html');
  }

  public function _add()
  {
    $src = $_FILES['file']['tmp_name'];
    $filename = md5(time()) . '.' . explode('/', $_FILES['file']['type'])[1];
    $dest = realpath('./') . '/Static/upload/' . $filename;
    move_uploaded_file($src, $dest);
    $m = new MusicModel();
    $_POST['pic'] = '/Static/upload/' . $filename;
    if ($m->addAlbum($_POST)) {
      $this->redirect('/admin?page=' . $_SESSION['page']);
    };
  }

  /////////////////////删除专辑/////////////////////
  public function delete_album()
  {
    $id = $_GET['album_id'];
    $m = new MusicModel();
    $file = $m->getAlbumById($id)['pic'];
    if (!empty($file)) {
      unlink(realpath('./') . $file);
    }
    if ($m->deleteAlbumById($id)) {
      $this->redirect('/admin?page=' . $_SESSION['page']);
    }
  }

  ///////////////////更新专辑//////////////////////////
  public function update_album()
  {
    $id = $_GET['album_id'];
    $m = new MusicModel();
    $this->assign('al', $m->getAlbumById($id));
    $this->display('admin/update_album.html');
  }

  public function _update()
  {
    if (!empty($_FILES['file']['tmp_name'])) {
      $src = $_FILES['file']['tmp_name'];
      $filename = md5(time()) . '.' . explode('/', $_FILES['file']['type'])[1];
      $desc = realpath('./') . '/Static/upload/' . $filename;
      move_uploaded_file($src, $desc);
      if (!empty($_POST['pic'])) {
        unlink(realpath('./') . $_POST['pic']);
      }
      $new_path = '/Static/upload/' . $filename;
    } else {
      $new_path = $_POST['pic'];
    }
    $id = $_POST['id'];
    $data = Array(
      'name' => $_POST['name'],
      'artist_name' => $_POST['artist_name'],
      'pic' => $new_path
    );
    $m = new MusicModel();
    if ($m->updateAlbum($id, $data)) {
      $this->redirect('/admin?page=' . $_SESSION['page']);
    }
  }

  /////////////////展示某张专辑中的mp3////////////////////////////
  public function music()
  {
    $album_id = $_GET['album_id'];
    $m = new MusicModel();
    $this->assign('music', $m->getMusic($album_id));
    $this->display('admin/music.html');
  }

  /////////////////为专辑添加音乐////////////////
  public function add_music()
  {
    $this->display('admin/add_music.html');
  }

  /////////////////为专辑删除音乐////////////////
  public function delete_music()
  {
    $m = new MusicModel();

    unlink(realpath('./') . $m->getMusicById($_GET['mid'])['src']);

    $where = Array(
      'id' => $_GET['mid']
    );
    if ($m->delete('music', $where)) {
      $this->redirect('/admin/music?album_id=' . $_GET['album_id']);
    }
  }

  public function _add_music()
  {
    $ext_name = explode('/', $_FILES['file']['type'])[1];

    if ($ext_name === 'mp3') {
      $src = $_FILES['file']['tmp_name'];
      $filename = md5(time()) . '.' . $ext_name;
      $dest = realpath('./') . '/Static/musics/' . $filename;
      move_uploaded_file($src, $dest);
      $_POST['src'] = '/Static/musics/' . $filename;
      $m = new MusicModel();
      if ($m->addMusic($_POST)) {
        $this->redirect('/admin/music?album_id=' . $_POST['album_id']);
      }
    } else {
      $this->assign('info', '只支持mp3格式');
      $this->assign('url', '/admin/add_music?album_id=' . $_POST['album_id']);
      $this->display('admin/error.html');
    }
  }

}