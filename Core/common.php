<?php
////////////////// 整个框架中到处都存在的公用函数
function c($var)
{
  if (is_bool($var)) {
    var_dump($var);
  } else {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }
}