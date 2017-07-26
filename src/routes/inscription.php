<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


//GET All Inscriptions
$app->get('/api/inscriptions', function(Request $request , Response $response){
	$sql = "SELECT * FROM inscription";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $inscriptions = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode(($inscriptions)) );

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



// Get Single Inscription
$app->get('/api/inscription/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM inscription WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $inscription = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        return buildResponse( $response , json_encode(($inscription)) );

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


// Add inscription
$app->post('/api/inscription/add', function(Request $request, Response $response){

    try{

		if( !isset($_SESSION["user"]) ){
	    	return buildResponse( $response , "Inscripción fallida, Autenticate de nuevo." , 406 );
		}

	    $fk_course = htmlentities( trim( $request->getParam('course_id') ));
	    $user_id   = $_SESSION["user"]->id;
	    if( empty($fk_course) || empty($user_id) ){
	    	return buildResponse( $response , "Identificador de Usuario o Electiva no recibida." , 406 );
	    }

	    $sql = "INSERT INTO inscription (fk_user , fk_course) VALUES (:fk_user,:fk_course)";

        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':fk_user', $user_id);
        $stmt->bindParam(':fk_course',  $fk_course);

        $stmt->execute();
        $db = null;

        return buildResponse( $response , json_encode("Inscripcion Realizada") );

    } catch(PDOException $e){

    	switch ( $e->getCode() ) {
    		case 23000:
    			return buildResponse( $response , "Usuario Inscrito o el ID no corresponde a una Asignatura." , 406 );
                break;

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


// Delete inscription
$app->delete('/api/inscription/delete', function(Request $request, Response $response){


    $fk_course 	= htmlentities( trim( $request->getParam('course_id') ));
    $fk_user  		= htmlentities( trim( $request->getParam('user_id') ));

    if( empty($fk_course) || empty($fk_user) ){
        return buildResponse( $response , "Usuario o Electiva no recibida." , 406 );
    }

    if( is_nan($fk_course) ){
        return buildResponse( $response , "Electiva ID invalido." , 406 );
    }

    if( is_nan($fk_user) ){
        return buildResponse( $response , "Usuario ID invalido." , 406 );
    }

    $sql = "DELETE FROM inscription WHERE fk_user = :fk_user	 AND fk_course = :fk_course	";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':fk_user', $fk_user);
        $stmt->bindParam(':fk_course',  $fk_course);

        $stmt->execute();
        $db = null;
        return buildResponse( $response , json_encode("Inscripcion Eliminada") );

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
