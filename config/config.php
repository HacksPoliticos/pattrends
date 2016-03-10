<?php
//CONFIG GLOBAL
//session_start();

header('Content-Type: text/html; charset=utf-8');

/*
ini_set("memory_limit", "200M");
ini_set("max_execution_time", "900");
ini_set("max_input_time", "900");
ini_set("post_max_size", "200M");
*/

error_reporting( E_ALL | E_STRICT );
ini_set("display_errors", 0);

date_default_timezone_set('America/Sao_Paulo');

/*function __autoload($class_name) { require_once '/home/thiago/www/p-trends/app/lib/' . $class_name . '.php';}*/



define("LIB_PATH", "/home/thiago/www/p-trends/app/lib/");

include(LIB_PATH."Cache.php");
include(LIB_PATH."Assignees.php");
include(LIB_PATH."Dados.php");
include(LIB_PATH."PatentAssignees.php");
include(LIB_PATH."Patents.php");
include(LIB_PATH."PatentTags.php");
include(LIB_PATH."Stopwords.php");
include(LIB_PATH."Tags.php");
include(LIB_PATH."Benchmark.php");


//DATABASE CONFIGURATION
define("BD_ENDERECO", "localhost");
//DATABASE
define("BD_BANCO", "ptrends");
//USER
define("BD_USUARIO", "root");
//PASS
define("BD_SENHA", "");

//OUTROS
define("XML_PATH", "xml/");

//CACHE DEFINE SE O CACHE ESTA HABILITADO
define("CACHE", 1);
define("CACHE_PATH", "cache/");

//BENCHMARK
define("BENCHMARK", 0);

?>