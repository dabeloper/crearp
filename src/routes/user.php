<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


//POST Authenticate
// Validar la informacion enviada y de concordar en BD guardar el objecto en la SESSION
$app->post('/api/user/login', function(Request $request , Response $response){
	$id = htmlentities( trim( $request->getParam('id') ));

	if( $id!="0" && empty($id) || !is_numeric($id) ){
        return buildResponse( $response , "El ID del Usuario debe ser numerico." , 406 );
    }

    $sql = "SELECT * FROM user WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;

        $_SESSION["user"] = $user;
        return buildResponse( $response , json_encode($user) );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


//POST Logout
// Eliminar la variable de SESSION del Usuario actual
$app->post('/api/user/logout', function(Request $request , Response $response){
	$_SESSION['user'] = null;
	unset( $_SESSION['user'] );
    return buildResponse( $response , "Deslogueado" );
});




//GET All Users
// Obtener todos los Usuarios en BD
$app->get('/api/users', function(Request $request , Response $response){
	$sql = "SELECT * FROM user WHERE is_admin = FALSE";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode($users) );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});



//GET All Courses using a Key Word
$app->get('/api/users/find/{key_word}', function(Request $request , Response $response){

    $key_word = $request->getAttribute('key_word');

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $sql = "SELECT * FROM user WHERE name LIKE \"%". $key_word ."%\" OR id = \"". $key_word ."\" " ;
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        return buildResponse( $response , json_encode(($users)) );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


//GET the Teacher (User) of a Course
// Obtener el Usuario (Profesor) de un curso
$app->get('/api/user/teacher/course/{course_id}', function(Request $request , Response $response){

    $course_id = $request->getAttribute('course_id');

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $sql = "SELECT * FROM course WHERE id = $course_id";
        $stmt = $db->query($sql);
        $course = $stmt->fetch(PDO::FETCH_OBJ);

        $sql = "SELECT * FROM user WHERE id = ".$course->fk_teacher;
        $stmt = $db->query($sql);
        $users = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode($users) );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});

//GET All Users of a Course
// Obtener todos los Usuarios (Estudiantes) inscritos en un curso
$app->get('/api/users/in/course/{course_id}', function(Request $request , Response $response){

    $course_id = $request->getAttribute('course_id');

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $sql = "SELECT * FROM inscription WHERE fk_course = $course_id";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();

        $users_ids = array();
        foreach($data as $row) {
            array_push( $users_ids , $row['fk_user'] );
        }

        if( count($users_ids) > 0 ){
            $sql = "SELECT * FROM user WHERE id IN ( ". implode(",",$users_ids) ." ) " ;
            $stmt = $db->query($sql);
            $users = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return buildResponse( $response , json_encode($users) );
        }else{
            return buildResponse( $response , "[]");
        }

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


// Get Single User
// Obtener de BD el usuario con el ID
$app->get('/api/user/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

	if( !is_numeric($id) || is_nan($id) ){
        return buildResponse( $response , "El ID del Usuario debe ser numerico." , 406 );
    }

    $sql = "SELECT * FROM user WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode($user) );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


// Add User
// Registrar un nuevo Usuario en BD
$app->post('/api/user/add', function(Request $request, Response $response){

    $id 		= htmlentities( trim( $request->getParam('id') ));
    $isAdmin 	= htmlentities( trim( $request->getParam('is_admin') ));
    $name 		= htmlentities( trim( $request->getParam('name') ));

    if( empty($name) || empty($isAdmin) ){
        return buildResponse( $response , "Nombre o Tipo de Usuario no recibido." , 406 );
    }

    if( empty($id) || !is_numeric($id) ){
        return buildResponse( $response , "Identificacion invalida." , 406 );
    }

    $isAdmin = ($isAdmin=="true");

    $sql = "INSERT INTO user (id, is_admin, name) VALUES (:id, :is_admin, :name)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':is_admin', $isAdmin );
        $stmt->bindParam(':name',  $name);

        $stmt->execute();
        $db = null;

        return buildResponse( $response , json_encode("Registro Exitoso") );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


// Update User
//  Actualizar la informacion de un Usuario
$app->put('/api/user/update/{id}', function(Request $request, Response $response){


    try{

	    $id 		= htmlentities( trim( $request->getAttribute('id') ) );
	    $isAdmin 	= htmlentities( trim( $request->getParam('isAdmin') ) );
	    $name 		= htmlentities( trim( $request->getParam('name') ) );

	    if( $isAdmin === 'true' || $isAdmin === '1'){
	    	$isAdmin = true;
	    }

	    $sql = "UPDATE user SET ";

		$update = false;

	    if( !empty($name) ){
	    	$update = true;
	    	$sql = $sql . "name = :name";
	    }
	    if( !empty($isAdmin) ){
	    	if( $update ) $sql = $sql . " , ";
	    	$sql = $sql . "is_admin = :is_admin";
	    	$update = true;
	    }


	    if( !$update ){
            return buildResponse( $response , "Nada para actualizar" , 406 );
	    }

	    $sql = $sql . " WHERE id = $id";

        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        if( !empty($isAdmin) ) 	$stmt->bindParam(':is_admin', $isAdmin);
        if( !empty($name) ) 	$stmt->bindParam(':name', $name);

        $stmt->execute();
        $db = null;

        return buildResponse( $response , json_encode("Usuario Actualizado") );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


// Delete User
//  Eliminar un Usuario de BD
$app->delete('/api/user/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM user WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        return buildResponse( $response , json_encode("Usuario Eliminado") );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "{}" , 406  );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});

