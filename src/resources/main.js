
var NEW_CARD_STYLE      = "topic-javascript";
var USER_CARD_STYLE     = "topic-design";
var DEFAULT_CARD_STYLE  = "topic-data-analysis";
var STUDENT_CARD_STYLE  = "topic-android";
var rootURL             = "http://35.186.163.16/crearp/public/index.php/api";

// Close modal with 'esc'
$(document).keyup(function(e) {
  if (e.keyCode == 27) {
    $(".modal-wrapper").fadeOut().removeClass("open-modal");
  }
});

//sticky cta
$(document).scroll(function() {
  var y = $(this).scrollTop();
  if (y > 120) {
    $('html').addClass('scrolled-past-hero');
  } else {
    $('html').removeClass('scrolled-past-hero');
  }
});

// Open Mobile Nav
$("[data-nav-toggle]").click(function(e){
  e.preventDefault();
  $("html").toggleClass("nav-shelf-expanded");
});

//hide All sections
$(".page-content").addClass("hide");


/**
* Snack Bar en Css para Alertas
*/
function showSnackBar( message ) {
    var x = document.getElementById("snackbar");
    x.innerHTML = message;
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}//END showSnackBar


/**
* Mostrar un section usando su ID
*/
function showSection( section_id ){
  //hide All sections
  $(".page-content").addClass("hide");
  $("#"+section_id).removeClass("hide");
  $('#results').addClass("hide");
}//END showSection


/**
* Validacion Principal se verifica que el objeto user exista
*/
function checkUserType(){
  $('#results').addClass("hide");
  if( user != null ){
    $('#guest-nav').addClass("hide");
    $('#user-board').removeClass("hide");

      if( user.is_admin == true ){
        $('#admin-nav').removeClass("hide");
        $('#post-title').html("Bienvenido Administrador <br/><b>"+user.name+"</b>");
        $('#btn-new-course').removeClass("hide");
        $('#btn-my-inscriptions').addClass("hide");

      }else{
        $('#user-nav').removeClass("hide");
        $('#post-title').html("Bienvenido Usuario <br/><b>"+user.name+"</b>");
        $('#btn-new-course').addClass("hide");
        $('#btn-my-inscriptions').removeClass("hide");
      }
  }else{
    $("#login").removeClass("hide");
  }

}//END checkUserType








/************************************************
*
* Peticiones Ajax para consumir la API REST
*
**************************************************/


/**
* Construir la estructura en HTML para el tooltip de un Usuario (Estudiante)
*/
function buildStudent( student ){
  var studentStyles = [
    "topic-html topic topic-html",
    "topic-css topic topic-css",
    "topic-design topic topic-design",
    "topic-javascript topic topic-javascript",
    "topic-ruby topic topic-ruby",
    "topic-php topic topic-php",
    "topic-ios topic topic-ios",
    "topic-android topic topic-android",
    "topic-business topic topic-business"
    ];

    return '<li class="'+studentStyles[Math.floor(Math.random() * studentStyles.length)]+'"><a><span>'+student.name+'</span></a></li>';
}//END buildStudent



/**
* Intermediario que define que tipo de tarjeta construir dependiendo del ROL del usuario actual
*/
function buildCourseCard( course , cardStyle ){

  if( user.is_admin == true ){
    return buildCourseAdminCard( course );
  }else{
    return buildCourseUserCard( course , cardStyle );
  }

}//End buildCourseCard



/**
* Construir la estructura en HTML para la tarjeta de un Curso (Electiva) Rol Administrador
*/
function buildCourseAdminCard( course ){
  var cardStyles = [ "topic-data-analysis" , "topic-design" , "topic-css" , "topic-undefined" , "topic-android" , "topic-javascript" , "topic-business" , "topic-python" , "topic-csharp"];


  return '<li id="course_card_'+course.id+'" class="card course syllabus topic-javascript"> \n\
        \n\
      <div class="card-box" href="#results">\n\
        <div class="card-progress">\n\
          <span class="card-estimate">Electiva '+course.id+'</span>\n\
        </div>\n\
        \n\
        <strong class="card-type">'+course.capacity+' Cupos Totales</strong>\n\
        <input id="capacity" type="hidden" value="'+course.capacity+'" />\n\
        <h3 class="card-title" data-value="'+course.name+'" >'+course.name+'</h3>\n\
        <p class="card-description" data-value="'+course.description+'">\n\
          '+course.description+'\n\
        </p>\n\
        <p class="card-status"></p>\n\
      </div>\n\
      \n\
      <ul class="card-tags tags">\n\
        <li id="desuscribe" class="pro-content">\n\
        <a onClick="admin_remove_course('+course.id+')" >\n\
          <svg class="course-icon card-icon" preserveAspectRatio="xMinYMin meet" viewBox="-2 0 10 10" class="remove-icon">\n\
              <path d="M8.2,6l3.3-3.3c0.6-0.6,0.6-1.6,0-2.2s-1.6-0.6-2.2,0L6,3.8L2.7,0.5c-0.6-0.6-1.6-0.6-2.2,0s-0.6,1.6,0,2.2L3.8,6L0.5,9.3\n\
              c-0.6,0.6-0.6,1.6,0,2.2c0.6,0.6,1.6,0.6,2.2,0L6,8.2l3.3,3.3c0.6,0.6,1.6,0.6,2.2,0c0.6-0.6,0.6-1.6,0-2.2L8.2,6z"></path>\n\
          </svg>\n\
        </a></li>\n\
        <li id="inscribe" class="pro-content">\n\
        <a onClick="admin_start_course_edition('+course.id+')" >\n\
          <svg class="course-icon card-icon" preserveAspectRatio="xMinYMin meet" viewBox="-30 0 100 10" class="plus-icon">\n\
            <path d="M5,87.9L0,120l32.1-5l60.1-59.1L64.1,27.8L5,87.9z M111.2,8.8c-8-8-17-11-21-7l-15,15l28.1,28.1l15-15\n\
                    C122.2,25.8,119.2,15.8,111.2,8.8z"></path>\n\
          </svg>\n\
        </a></li>\n\
        <li class="topics"><span>Inscritos</span><ul></ul></li>\n\
        <li class="difficulty"><span></span></li>\n\
        <li class="truncated-tags"><span></span><ul></ul></li>\n\
      </ul>\n\
    </li>';

}//END buildCourseAdminCard




/**
* Construir la estructura en HTML para la tarjeta de un Curso (Electiva) Rol Usuario
*/
function buildCourseUserCard( course , cardStyle ){
  var cardStyles = [ "topic-data-analysis" , "topic-design" , "topic-css" , "topic-undefined" , "topic-android" , "topic-javascript" , "topic-business" , "topic-python" , "topic-csharp"];

  if( typeof(cardStyle) != "string" ) cardStyle = DEFAULT_CARD_STYLE;

  return '<li id="course_card_'+course.id+'" class="card course syllabus '+cardStyle+'"> \n\
        \n\
      <div class="card-box" href="#results">\n\
        <div class="card-progress">\n\
          <span class="card-estimate">Electiva '+course.id+'</span>\n\
        </div>\n\
        \n\
        <strong class="card-type">'+course.capacity+' Cupos Totales</strong>\n\
        <input id="capacity" type="hidden" value="'+course.capacity+'" />\n\
        <h3 class="card-title">'+course.name+'</h3>\n\
        <p class="card-description">\n\
          '+course.description+'\n\
        </p>\n\
        <p class="card-status"></p>\n\
      </div>\n\
        \n\
      <ul class="card-tags tags">\n\
        <li id="desuscribe" class="pro-content hidden">\n\
        <a onClick="remove_inscription('+course.id+')" >\n\
          <svg class="course-icon card-icon" preserveAspectRatio="xMinYMin meet" viewBox="-2 0 10 10" class="remove-icon">\n\
              <path d="M8.2,6l3.3-3.3c0.6-0.6,0.6-1.6,0-2.2s-1.6-0.6-2.2,0L6,3.8L2.7,0.5c-0.6-0.6-1.6-0.6-2.2,0s-0.6,1.6,0,2.2L3.8,6L0.5,9.3\n\
    c-0.6,0.6-0.6,1.6,0,2.2c0.6,0.6,1.6,0.6,2.2,0L6,8.2l3.3,3.3c0.6,0.6,1.6,0.6,2.2,0c0.6-0.6,0.6-1.6,0-2.2L8.2,6z"></path>\n\
          </svg>\n\
        </a></li>\n\
        <li id="inscribe" class="pro-content">\n\
        <a onClick="inscribe('+course.id+')" >\n\
          <svg class="course-icon card-icon" preserveAspectRatio="xMinYMin meet" viewBox="-50 0 200 10" class="plus-icon">\n\
            <path d="M230,100h-70V30c0-16.6-13.4-30-30-30s-30,13.4-30,30v70H30c-16.6,0-30,13.4-30,30s13.4,30,30,30h70v70\n\
            c0,16.6,13.4,30,30,30s30-13.4,30-30v-70h70c16.6,0,30-13.4,30-30S246.6,100,230,100z"></path>\n\
          </svg>\n\
        </a></li>\n\
        <li class="topics"><span>Inscritos</span><ul></ul></li>\n\
        <li class="difficulty"><span></span></li>\n\
        <li class="truncated-tags"><span></span><ul></ul></li>\n\
      </ul>\n\
    </li>';

}//END buildCourseUserCard



/**
* Añadir un texto indicando que la busqueda no obtuvo resultados
*/
function emptyList(){
  $('#results').removeClass("hide");
  $('#results>ul li').remove();
  $('#results>ul').append('<li>Sin Resultados</li> ');
}//END emptyList



/**
* Configurar y crear los objetos tipo Curso y añadirlos usando la funcion buildClassCard()
*/
function renderList(data , style) {
  if( data == null ){ emptyList(); }
  console.log(data);

  // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
  var list = data == null ? [] : (data instanceof Array ? data : [data]);

    $('#results h3 em').html( "( "+ data.length +" )" );
    $('#course_form').addClass("hide");
    $('#results').removeClass("hide");
    $('#results>ul li').remove();
    $.each(list, function(index, course) {
      $('#results>ul').append( buildCourseCard(course , style) );
      user_get_all_students_in_course( course.id );
      user_get_teacher_of_course( course.id );
    });

}//END renderList



/**
* Configurar y crear los objetos tipo Estudiante y añadirlos usando la funcion buildStudent()
*/
function renderStudentTooltipList(data , curse_id) {
  if( data == null ) return;
  console.log(data);

  // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
  var list = data == null ? [] : (data instanceof Array ? data : [data]);

  $.each(list, function(index, student) {
    if( user.id == student.id ){
      $('#course_card_'+curse_id).removeClass( DEFAULT_CARD_STYLE );
      $('#course_card_'+curse_id).addClass( USER_CARD_STYLE );
      $('#course_card_'+curse_id+" #inscribe").addClass( "hidden" );
      $('#course_card_'+curse_id+" #desuscribe").removeClass( "hidden" );
    }
    $('#course_card_'+curse_id+' .topics > ul').append( buildStudent(student) );
  });

  var courseCapacity = $('#course_card_'+curse_id+' #capacity').val();
  $('#course_card_'+curse_id+' .difficulty > span').html( "Hay " + (courseCapacity - list.length) + " Cupos Disponibles" );

}//END renderStudentTooltipList





/*********
* USUARIO
********/

/**
* Se envia por POST el ID y se verifica de que exista
*/
function submit_login(){
  var send_data = JSON.stringify({ "id": $('#user_id_login').val() });
  console.log('submit_login > '+send_data);

  $.ajax({
    type: 'POST',
    contentType: 'application/json',
    url: rootURL + "/user/login",
    dataType: "json",
    data: send_data,
    success: function(data, textStatus, jqXHR){
      if( data == false){
        showSnackBar( "Usuario con id \""+$('#user_id_login').val()+"\" no encontrado" );
      }else{
        location.reload();
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });
}//END submit_login



/**
* Se envia por POST la peticion de remover la SESSION
*/
function submit_logout(){
  console.log('submit_logout');

  $.ajax({
    type: 'POST',
    contentType: 'application/json',
    url: rootURL + "/user/logout",
    dataType: "json",
    data: null,
    success: function(data, textStatus, jqXHR){
        location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
      location.reload();
    }
  });
}//END submit_logout



/**
* Se envia por POST los datos para crear un nuevo Usuario
*/
function submit_sign_up(){
  var send_data = JSON.stringify({  "id": $('#user_id_signup').val() ,
                                    "name": $('#user_name').val() ,
                                    "is_admin": $('#is_admin').val()
                                  });
  console.log('submit_sign_up > ' + send_data);

  $.ajax({
    type: 'POST',
    contentType: 'application/json',
    url: rootURL + "/user/add",
    dataType: "json",
    data: send_data,
    success: function(data, textStatus, jqXHR){
      showSnackBar( jqXHR.responseText );
      showSection('login');
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });
}//END submit_sign_up


/**
* Obtener todas las Electivas con Inscripcion del Usuario
*/
function user_get_my_courses() {
  console.log("user_get_my_courses");
  $('#results h3').html("Mis Electivas <em></em>");

    $.ajax({
        type: 'GET',
        url: rootURL + "/courses/my",
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderList(data , USER_CARD_STYLE);
        },
        error: emptyList
    });
}//END user_get_my_courses



/**
* Obtener todas las Electivas
*/
function user_get_all_courses() {
  console.log("user_get_all_courses");
  $('#results h3').html("Electivas <em></em>");

    $.ajax({
        type: 'GET',
        url: rootURL + "/courses",
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderList(data , DEFAULT_CARD_STYLE);
        },
        error: emptyList
    });
}//END user_get_all_courses




/**
* Obtener todas las Electivas usando una palabra clave
*/
function find_courses() {
  console.log("find_courses");

  var key_word = $("#q").val();

  if( key_word.length < 3 ){
    showSnackBar("Consulta invalida, Minimo 3 Caracteres");
    return;
  }
  $('#results h3').html("Cursos con la Palabra Clave : \""+key_word+"\" <em></em>");

    $.ajax({
        type: 'GET',
        url: rootURL + "/courses/find/"+key_word,
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderList(data , DEFAULT_CARD_STYLE);
        },
        error: emptyList
    });
}//END find_courses


/**
* Obtener todos los Usuarios Inscritos en una Electiva
*/
function user_get_all_students_in_course( course_id ) {
  console.log("user_get_all_student_in_course");

    $.ajax({
        type: 'GET',
        url: rootURL + "/users/in/course/"+course_id,
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderStudentTooltipList( data , course_id );
        },
        error: emptyList
    });
}//END user_get_all_students_in_course



/**
* Obtener el Profesor de una Electivas
*/
function user_get_teacher_of_course( course_id ) {
  console.log("user_get_teacher_of_course");

    $.ajax({
        type: 'GET',
        url: rootURL + "/user/teacher/course/"+course_id,
        dataType: "json",
        success: function(teacher, textStatus, jqXHR){
            $('#course_card_'+course_id+' .card-status').html( '<a class="card-status-title" onClick="user_get_all_courses_by_teacher(\''+teacher.id+'\' , \''+teacher.name+'\');" data-value="'+teacher.id+'" >Dictado por: '+ teacher.name + "</a>" )
        },
        error: emptyList
    });
}//END user_get_teacher_of_course



/**
* Obtener todas las Electivas dictadas por un Profesor
*/
function user_get_all_courses_by_teacher( teacher_id, teacher_name ) {
  console.log("user_get_all_courses_by_teacher");
  $('#results h3').html("Electivas dictadas por el Profesor: \"<b>"+teacher_name+"</b>\" <em></em>");

    $.ajax({
        type: 'GET',
        url: rootURL + "/courses/teacher/"+teacher_id,
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderList(data , DEFAULT_CARD_STYLE);
        },
        error: emptyList
    });
}//END user_get_all_courses_by_teacher



/**
* Desuscribirse de una Electiva
*/
function remove_inscription( course_id ) {
  var send_data = JSON.stringify({ "course_id": course_id, "user_id":user.id });
  console.log('remove_inscription');

  $.ajax({
    type: 'DELETE',
    contentType: 'application/json',
    url: rootURL + "/inscription/delete",
    dataType: "json",
    data: send_data,
    success: function(data, textStatus, jqXHR){
      showSnackBar( jqXHR.responseText );
      user_get_all_courses();
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });

}//END remove_inscription



/**
* Inscribirse a una Electiva
*/
function inscribe( course_id ) {
  var send_data = JSON.stringify({ "course_id": course_id, "user_id":user.id });
  console.log('inscribe');

  $.ajax({
    type: 'POST',
    contentType: 'application/json',
    url: rootURL + "/inscription/add",
    dataType: "json",
    data: send_data,
    success: function(data, textStatus, jqXHR){
      showSnackBar( jqXHR.responseText );
      user_get_all_courses();
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });

}//END inscribe







/****************************************************************
*
*     END USER SECTION
*
*   STARTS ADMIN SECTION
*
******************************************************************/



/**
* Configurar y crear los objetos tipo Usuario y añadirlos usando la funcion buildUserCard()
*/
function renderUserList(data , style) {
  if( data == null ){ emptyList(); }
  console.log(data);

  // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
  var list = data == null ? [] : (data instanceof Array ? data : [data]);

    $('#results h3 em').html( "( "+ data.length +" )" );
    $('#results').removeClass("hide");
    $('#course_form').addClass("hide");
    $('#results>ul li').remove();
    $.each(list, function(index, user) {
      $('#results>ul').append( buildUserCard(user) );
      //user_get_all_students_in_course( course.id );
    });

}//END renderUserList


/**
* Construir la estructura en HTML para la tarjeta de un Curso (Electiva)
*/
function buildUserCard( user ){

  return '<li id="user_card_'+user.id+'" class="card course syllabus '+STUDENT_CARD_STYLE+'"> \n\
\n\
      <div class="card-box" href="#results">\n\
        <div class="card-progress">\n\
          <span class="card-estimate">ID '+user.id+'</span>\n\
        </div>\n\
\n\
        <strong class="card-type"></strong>\n\
        <h3 class="card-title">'+user.name+'</h3>\n\
      </div>\n\
\n\
      <ul class="card-tags tags">\n\
        <li class="pro-content"><a onClick="find_user_inscriptions(\''+user.id+'\' , \''+user.name+'\')" >Ver Inscripciones</a></li>\n\
        <li class="topic-data-analysis topic topic"><a href="#results"><span></span></a></li>\n\
        <li class="truncated-tags"><span></span><ul></ul></li>\n\
      </ul>\n\
    </li>';

}//END buildUserCard



/**
* Buscar los Usuarios que coincidan con una palabra clave
*/
function find_users() {
  console.log("find_users");

  var key_word = $("#q").val();

  if( key_word.length < 3 ){
    showSnackBar("Consulta invalida, Minimo 3 Caracteres");
    return;
  }

  $('#results h3').html("Usuarios con la Palabra Clave : \""+key_word+"\" <em></em>");

    $.ajax({
        type: 'GET',
        url: rootURL + "/users/find/"+key_word,
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderUserList(data , DEFAULT_CARD_STYLE);
        },
        error: emptyList
    });
}//END find_users



/**
* Buscar las Inscripciones de un Usuario
*/
function find_user_inscriptions( user_id , user_name ) {
  console.log("find_user_inscriptions");

  $('#results h3').html("Inscripciones de el Usuario : \"<b>"+user_name+"</b>\" <em></em>");

    $.ajax({
        type: 'GET',
        url: rootURL + "/courses/student/"+user_id,
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            renderList(data , DEFAULT_CARD_STYLE);
        },
        error: emptyList
    });
}//END find_user_inscriptions



/**
* Mostrar el Formulario para Crear una nueva Electiva
*/
function admin_new_course( ) {
  console.log("admin_new_course");

  $('#course_form h3').html("Crear Electiva <em></em>");
  $('#course_form').removeClass( "hide" );
  $('#new_course_create_button').removeClass("hide");
  $('#new_course_update_button').addClass("hide");
  $('#results').addClass("hide");
  $('#results>ul li').remove();

  $('#course_form_id').val("");
  $('#new_course_name').val("");
  $('#new_course_description').val("");
  $('#new_course_capacity').val("");
  $('#course_form_teacher_id').val("");

    $.ajax({
        type: 'GET',
        url: rootURL + "/users",
        dataType: "json",
        success: function(data, textStatus, jqXHR){
          if( data == null ){ emptyList(); }
          console.log(data);

          // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
          var list = data == null ? [] : (data instanceof Array ? data : [data]);

          $('#new_course_teacher option').remove();
          $.each(list, function(index, user) {
            $('#new_course_teacher').append( '<option value="'+user.id+'">' + user.name + "</option>" );
          });

          $('#new_course_teacher').val( $('#course_form_teacher_id').val() );

        },
        error: emptyList
    });

}//END admin_new_course


/**
* Crear una nueva Electiva
*/
function admin_add_course( ) {

  var send_data = {  "name":         $('#new_course_name').val().trim(),
                    "description":  $('#new_course_description').val().trim(),
                    "capacity":     $('#new_course_capacity').val().trim(),
                    "teacher_id":   $('#new_course_teacher').val()
                  };
  console.log('admin_add_course > ' + send_data);

  if( send_data["name"].length < 3 ) return showSnackBar("Minimo 3 Caracteres para el Nombre");
  if( send_data["name"].length > 100 ) return showSnackBar("Maximo 100 Caracteres para el Nombre");
  if( send_data["description"].length < 3 ) return showSnackBar("Minimo 3 Caracteres para la Descripcion");
  if( send_data["description"].length > 255 ) return showSnackBar("Maximo 255 Caracteres para la Descripcion");
  if( send_data["capacity"]<1 || isNaN(send_data["capacity"]) ) return showSnackBar("El Cupo debe ser numerico positivo mayor que cero");
  if( send_data["teacher_id"]<1 || isNaN(send_data["teacher_id"]) ) return showSnackBar("Elige un Profesor de la Lista de Usuarios");



  $.ajax({
    type: 'POST',
    contentType: 'application/json',
    url: rootURL + "/course/add",
    dataType: "json",
    data: JSON.stringify(send_data),
    success: function(data, textStatus, jqXHR){
      showSnackBar( jqXHR.responseText );
      user_get_all_courses();
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });

}//END admin_add_course



/**
* Eliminar una Electiva
*/
function admin_remove_course( course_id ) {
  var send_data = JSON.stringify({ "course_id": course_id, "user_id":user.id });
  console.log('admin_remove_course');

  $.ajax({
    type: 'DELETE',
    contentType: 'application/json',
    url: rootURL + "/course/delete/"+course_id,
    dataType: "json",
    data: send_data,
    success: function(data, textStatus, jqXHR){
      showSnackBar( jqXHR.responseText );
      user_get_all_courses();
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });

}//END admin_remove_course



/**
* Inicializar variables y complementos para editar una Electiva
*/
function admin_start_course_edition( course_id ) {


  var course_capacity     = $("#course_card_"+course_id+" #capacity").val().trim();
  var course_name         = $("#course_card_"+course_id+" .card-title").attr("data-value").trim();
  var course_description  = $("#course_card_"+course_id+" .card-description").attr("data-value").trim();
  var course_teacher      = $("#course_card_"+course_id+" .card-status-title").attr("data-value").trim();

  admin_new_course();

  $('#new_course_create_button').addClass("hide");
  $('#new_course_update_button').removeClass("hide");

  $('#course_form h3').html("Actualizar Electiva " + course_id);

  $('#course_form_id').val(course_id);
  $('#course_form_teacher_id').val(course_teacher);
  $('#new_course_name').val(course_name);
  $('#new_course_description').val(course_description);
  $('#new_course_capacity').val(course_capacity);

}//END admin_start_course_edition



/**
* Editar una Electiva
*/
function admin_edit_course() {
  var course_id = $('#course_form_id').val().trim();

  if( isNaN(course_id) || course_id<0 ){ location.reload(); return; }

  var send_data = {
                    "name":         $('#new_course_name').val().trim(),
                    "description":  $('#new_course_description').val().trim(),
                    "capacity":     $('#new_course_capacity').val().trim(),
                    "teacher_id":   $('#new_course_teacher').val()
                  };

  console.log('admin_edit_course > ' + send_data);

  if( send_data["name"].length < 3 ) return showSnackBar("Minimo 3 Caracteres para el Nombre");
  if( send_data["name"].length > 100 ) return showSnackBar("Maximo 100 Caracteres para el Nombre");
  if( send_data["description"].length < 3 ) return showSnackBar("Minimo 3 Caracteres para la Descripcion");
  if( send_data["description"].length > 255 ) return showSnackBar("Maximo 255 Caracteres para la Descripcion");
  if( send_data["capacity"]<1 || isNaN(send_data["capacity"]) ) return showSnackBar("El Cupo debe ser numerico positivo mayor que cero");
  if( send_data["teacher_id"]<1 || isNaN(send_data["teacher_id"]) ) return showSnackBar("Elige un Profesor de la Lista de Usuarios");


  $.ajax({
    type: 'PUT',
    contentType: 'application/json',
    url: rootURL + "/course/update/"+course_id,
    dataType: "json",
    data: JSON.stringify(send_data),
    success: function(data, textStatus, jqXHR){
      $('#course_form_id').val("");
      $('#new_course_name').val("");
      $('#new_course_description').val("");
      $('#new_course_capacity').val("");
      $('#course_form_teacher_id').val("");
      showSnackBar( jqXHR.responseText );
      user_get_all_courses();
    },
    error: function(jqXHR, textStatus, errorThrown){
      showSnackBar( jqXHR.responseText );
    }
  });

}//END admin_edit_course


//Inicializar componentes
checkUserType();