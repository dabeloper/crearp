<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

// Middleware que permite el control sobre las peticiones provenientes del cliente
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});


/**
* Funcion que crea la respuesta con la cabece HTTP y el BODY dado
*   A menos que se especifique lo contrario, la respuesta sera Exitosa (HTTP CODE = 200)
*/
function buildResponse( $response , $data , $http_code = 200 ){
    return $response->withStatus( $http_code )
                    ->withHeader('Content-Type', 'application/json')
                    ->write( $data );
}


$app->get('/routes/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    switch ($name) {
    	case 'user':
    		$response->getBody()->write("<h1>Rutas para <b>$name</b> </h1>");
    		$response->getBody()->write("<h2>GET</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/users\">users</a>: Obtiene todos los usuarios de BD");
    			$response->getBody()->write("<br/><a href=\"http://localhost/crearp/public/index.php/user/ID\">user/ID</a>: Obtiene el usuario con id {ID} de BD");
    		$response->getBody()->write("<h2>POST</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/user/add\">user/add</a>: Insertar un nuevo usuario en BD, se esperan los datos: <b>isAdmin</b>(1:True o 0:False), <b>name</b>(Max 255 caracteres)} ");
    		$response->getBody()->write("<h2>PUT</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/user/ID\">user/ID</a>: Actualizar el usuario con id {ID} de BD, se esperan los datos {'name'(Max 255 caracteres)}" );
    		$response->getBody()->write("<h2>DELETE</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/user/ID\">user/ID</a>: Remover el usuario con id {ID} de BD");

    		break;

    	case 'course':
    		$response->getBody()->write("<h1>Rutas para <b>$name</b> </h1>");
    		$response->getBody()->write("<h2>GET</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/courses\">courses</a>: Obtiene todas las electivas de BD");
    			$response->getBody()->write("<br/><a href=\"http://localhost/crearp/public/index.php/course/ID\">course/ID</a>: Obtiene la electiva con id {ID} de BD");
    		$response->getBody()->write("<h2>POST</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/course/add\">course/add</a>: Insertar un nuevo usuario en BD, se esperan los datos: <b>isAdmin</b>(1:True o 0:False), <b>name</b>(Max 255 caracteres)} ");
    		$response->getBody()->write("<h2>PUT</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/course/ID\">course/ID</a>: Actualizar la electiva con id {ID} de BD, se esperan los datos <b>capacity</b>(ENTERO POSITIVO), <b>name</b>(Max 100 caracteres), <b>description</b>(Max 255 caracteres), <b>teacher</b>(Max 255 caracteres), " );
    		$response->getBody()->write("<h2>DELETE</h2>");
    			$response->getBody()->write("<a href=\"http://localhost/crearp/public/index.php/course/ID\">course/ID</a>: Remover la electiva con id {ID} de BD");

    		break;

    	default:
    		# code...
    		break;
    }

    return $response;
});
