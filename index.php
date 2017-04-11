<?php
ini_set("display_errors", 'on');

define('VIEW', 'App/views/');
define('CONTROLLER', 'App/controller/');
define('MODEL', 'App/model/');

define('CSS_PATH', '/Static/css/');
define('JS_PATH', '/Static/js/');
define('IMG_PATH', '/Static/imgs/');

require 'Core/common.php';
require 'Core/framework.php';
require 'Core/dbpdo.php';

\Core\Framework::start();

