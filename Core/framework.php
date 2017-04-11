<?php
namespace Core;
class Framework
{
  public $arr;

  public function assign($k, $v)
  {
    $this->arr[$k] = $v;
  }

  public function findPage($page, $num, $url)
  {
    //上一页
    $prev = ($page - 1 < 1) ? 'javascript:void(0)' : ($url . '?page=' . ($page - 1));
    $html = '<nav><ul class="pagination"><li><a href="' . $prev . '"><span>&laquo;</span></a></li>';
    //页数
    for ($i = 1; $i <= $num; $i++) {
      if ($i == $page) {
        $html .= "<li class='active'><a href='{$url}?page={$i}'>{$i}</a></li>";
      } else {
        $html .= "<li><a href='{$url}?page={$i}'>{$i}</a></li>";
      }
    }
    //下一页
    $next = ($page + 1 > $num) ? 'javascript:void(0)' : ($url . '?page=' . ($page + 1));
    $html .= ' <li> <a href="' . $next . '"> <span>&raquo;</span> </a> </li> </ul> </nav>';
    return $html;
  }

  public function display($file)
  {
    $file = VIEW . $file;
    if (file_exists($file)) {
      if ($this->arr) {
        extract($this->arr);
      }
      include $file;
    } else {
      include VIEW . '404.html';
    }
  }

  public function session($k, $v)
  {
    session_start();
    $_SESSION[$k] = $v;
  }

  public function json($v)
  {
    header('Content-Type:text/json');
    echo json_encode($v);
  }

  public function redirect($url)
  {
    header('Location:' . $url);
  }

  public static function start()
  {
    $tmp = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
    if (empty($tmp[1])) {
      $class_name = 'indexController';
    } else {
      $class_name = $tmp[1] . 'Controller';
    }
    $method_name = isset($tmp[2]) ? $tmp[2] : 'index';
    $file = CONTROLLER . $class_name . '.php';
    if (file_exists($file)) {
      require $file;
      $c_name = '\\App\\controller\\' . $class_name;
      if (class_exists($c_name) && method_exists($c_name, $method_name)) {
        $page = new $c_name();
        $page->$method_name();
      } else {
        include VIEW . '404.html';
      }
    } else {
      include VIEW . '404.html';
    }
  }
}
