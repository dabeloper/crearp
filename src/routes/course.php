<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


//GET All courses
$app->get('/api/courses', function(Request $request , Response $response){
	$sql = "SELECT * FROM course";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $courses = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode(($courses)) );

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


// GET Single course
$app->get('/api/course/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM course";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt 		= $db->query($sql);
        $course 	= $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode(($course)) );

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


//GET Teacher's course
$app->get('/api/courses/teacher/{teacher_id}', function(Request $request, Response $response){
    $teacher_id = $request->getAttribute('teacher_id');

    try{

        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
		$sql = "SELECT * FROM course WHERE fk_teacher = $teacher_id";

        $stmt       = $db->query($sql);
        $courses    = $stmt->fetchAll(PDO::FETCH_OBJ);

        return buildResponse( $response , json_encode(($courses)) );

    } catch(Exception $e){

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


//GET All User's courses (Authenticate User)
$app->get('/api/courses/my', function(Request $request , Response $response){

    if( !isset($_SESSION["user"]) ){
        return buildResponse( $response , "Autenticate primero." , 406 );
	}

	$user_id = $_SESSION["user"]->id;

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

		$sql = "SELECT * FROM inscription WHERE fk_user = $user_id";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();

        $courses_ids = array();
		foreach($data as $row) {
			array_push( $courses_ids , $row['fk_course'] );
		}

        if( count($courses_ids) > 0 ){
    		$sql = "SELECT * FROM course WHERE id IN ( ". implode(",",$courses_ids) ." ) " ;
            $stmt = $db->query($sql);
            $courses = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return buildResponse( $response , json_encode($courses) );
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



//GET All Courses using a Key Word
$app->get('/api/courses/find/{key_word}', function(Request $request , Response $response){

    $key_word = $request->getAttribute('key_word');

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $sql = "SELECT * FROM course WHERE name LIKE \"%". $key_word ."%\" OR description LIKE \"%". $key_word ."%\" " ;
        $stmt = $db->query($sql);
        $courses = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        return buildResponse( $response , json_encode(($courses)) );

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



//GET All User's courses
$app->get('/api/courses/student/{user_id}', function(Request $request , Response $response){

    $user_id = $request->getAttribute('user_id');

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

		$sql = "SELECT * FROM inscription WHERE fk_user = $user_id";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();

        $courses_ids = array();
		foreach($data as $row) {
			array_push( $courses_ids , $row['fk_course'] );
		}

        if( count($courses_ids) > 0 ){
    		$sql = "SELECT * FROM course WHERE id IN ( ". implode(",",$courses_ids) ." ) " ;
            $stmt = $db->query($sql);
            $courses = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return buildResponse( $response , json_encode($courses) );
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


// Add course (ADMIN)
$app->post('/api/course/add', function(Request $request, Response $response){

	if( !isset($_SESSION["user"]) || $_SESSION["user"]->is_admin != true ){
        return buildResponse( $response , "Solo para Administradores." , 406 );
	}

    try{
	    $name 			= htmlentities( trim( $request->getParam('name') ) );
	    $description 	= htmlentities( trim( $request->getParam('description') ) );
	    $teacher 		= htmlentities( trim( $request->getParam('teacher_id') ) );
	    $capacity 		= htmlentities( trim( $request->getParam('capacity') ) );

		if( empty($name) || empty($description) || empty($teacher) || empty($capacity) ){
            return buildResponse( $response , "Nombre, Descripción, Profesor o Cupo no recibido." , 406 );
	    }

		if( is_nan($capacity) || !is_numeric($capacity) ){
            return buildResponse( $response , "El Cupo debe ser numerico." , 406 );
	    }

		if( is_nan($teacher) || !is_numeric($teacher) ){
            return buildResponse( $response , "El ID del Profesor debe ser numerico." , 406 );
	    }

	    $sql = "INSERT INTO course (name , description , fk_teacher , capacity )
	    					 VALUES (:name , :description , :teacher , :capacity )";

        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name',  $name);
        $stmt->bindParam(':description',  $description);
        $stmt->bindParam(':teacher',  $teacher);
        $stmt->bindParam(':capacity',  $capacity);

        $stmt->execute();
        $db = null;

        return buildResponse( $response , json_encode("Electiva Creada") );

    } catch(PDOException $e){

        switch ( $e->getCode() ) {
            case 23000:
                //Error getting properties of a bad PDO Objects, means BAD response
                return buildResponse( $response , "El ID no corresponde a un Usuario(Profesor) Registrado" , 406 );

            case 42000:
                //Error in PDO query
                return buildResponse( $response , "[]" );

            default:
                # Unexpected Error
                return buildResponse( $response , $e->getMessage() , 406 );
        }//END error switch
    }
});


// Update course (ADMIN)
$app->put('/api/course/update/{id}', function(Request $request, Response $response){

	if( !isset($_SESSION["user"]) || $_SESSION["user"]->is_admin != true ){
        return buildResponse( $response , "Solo para Administradores." , 406 );
	}

    try{
	    $id 			= htmlentities( trim( $request->getAttribute('id') ) );
	    $name 			= htmlentities( trim( $request->getParam('name') ) );
	    $description 	= htmlentities( trim( $request->getParam('description') ) );
	    $teacher 		= htmlentities( trim( $request->getParam('teacher_id') ) );
	    $capacity 		= htmlentities( trim( $request->getParam('capacity') ) );


		if( is_nan($capacity) || !is_numeric($capacity) ){
            return buildResponse( $response , "El Cupo debe ser numerico." , 406 );
	    }

		if( is_nan($teacher) || !is_numeric($teacher) ){
            return buildResponse( $response , "El ID del Profesor debe ser numerico." , 406 );
	    }

	    $sql = "UPDATE course SET ";
	    $update = false;

	    if( !empty($name) ){
	    	$update = true;
	    	$sql = $sql . "name = :name";
	    }
	    if( !empty($description) ){
	    	if( $update ) $sql = $sql . " , ";
	    	$sql = $sql . "description = :description";
	    	$update = true;
	    }
	    if( !empty($teacher) ){
	    	if( $update ) $sql = $sql . " , ";
	    	$sql = $sql . "fk_teacher = :teacher";
	    	$update = true;
	    }
	    if( !empty($capacity) ){
	    	if( $update ) $sql = $sql . " , ";
	    	$sql = $sql . "capacity = :capacity";
	    	$update = true;
	    }

	    if( !$update ){
            return buildResponse( $response , "Nada para actualizar." , 406 );
	    }

	    $sql = $sql . " WHERE id = $id";

        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        if( !empty($name) ) 		$stmt->bindParam(':name', $name);
        if( !empty($description) ) 	$stmt->bindParam(':description', $description);
        if( !empty($teacher) ) 		$stmt->bindParam(':teacher', $teacher);
        if( !empty($capacity) ) 	$stmt->bindParam(':capacity', $capacity);

        $stmt->execute();
        $db = null;

        return buildResponse( $response , json_encode("Electiva Actualizada") );

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


// Delete course (ADMIN)
$app->delete('/api/course/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

	if( !isset($_SESSION["user"]) || $_SESSION["user"]->is_admin != true ){
       return buildResponse( $response , "Solo para Administradores." , 406 );
	}

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

    	$sql = "DELETE FROM inscription WHERE fk_course = $id";
        $stmt = $db->prepare($sql);
        $stmt->execute();

    	$sql = "DELETE FROM course WHERE id = $id";
    	$stmt = $db->prepare($sql);
        $stmt->execute();

        $db = null;
        return buildResponse( $response , json_encode("Electiva Eliminada") );
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

