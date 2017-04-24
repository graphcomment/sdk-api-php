<?php
/**
 * Created by IntelliJ IDEA.
 * User: ddtraceweb
 * Date: 19/04/2017
 * Time: 11:26
 */


require "../../vendor/autoload.php";


$client = new Graphcomment\Sdk('graphcomment', 'graphcomment', '543c35e2bc2f505121bc2aa3');

$client->authentification();
$client->getThread("//dev.graphcomment.com/demo/");