<?php
ini_set('display_errors', 'On');

session_start();


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

require '../src/routes/default.php';

//Rutas para Usuarios
require '../src/routes/user.php';
//Rutas para Electivas
require '../src/routes/course.php';
//Rutas para Inscripciones
require '../src/routes/inscription.php';

$app->run();

