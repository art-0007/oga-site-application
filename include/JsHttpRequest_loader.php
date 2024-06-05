<?php
/**
 * В данном файле размещаются конструкции необходимые для подключения библиотеки "JsHttpRequest" на стороне серверного скрипта
 * Этот файл подключается везде, где необходимо использовать данную библиотеку
 * */

require_once(PATH."/js/ajax/lib/JsHttpRequest/JsHttpRequest.php");
$JsHttpRequest = new JsHttpRequest("UTF-8");

?>