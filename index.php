<?php
	@session_start();
?>
<!DOCTYPE html>
<html lang="es-CO">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title> Prueba Tecnica - Crear Publicitarios</title>

  <link rel="shortcut icon" href="./src/resources/logo.png">

  <meta name="description" content="Solucion Prueba Técnica para Crear Publicitarios ltda. Por David Antonio Bolaños Lamprea AKA DABELOPER">
  <link rel="stylesheet" href="./src/resources/all.css" type="text/css" media="all">
  <link rel="stylesheet" href="./src/resources/library.css" type="text/css" media="all">
</head>

<body class="single single-post postid-67 single-format-standard">

<nav>

  <section>

    <a href="#" class="brand">
     <img src="./src/resources/logo.png" width="50"/>
    </a>
    <div id="mobile-nav-toggle">
      <a href="#" id="nav-toggle" data-nav-toggle="">
        <span class="hamburger"></span>
      </a>
    </div>
    <a class="fixed-cta" href="#">Prueba Tecnica - Crear Publicitarios</a>

    <ul id="guest-nav" class="nav-list">
      <li class="nav-item ">
        <a href="#login" onClick="showSection('login')" class="nav-anchor">Ingresar</a>
      </li>
      <li class="nav-item nav-item-more">
        <a href="#sign_up" onClick="showSection('sign_up')" class="nav-anchor">Registrarse</a>
      </li>
    </ul>

    <ul id="user-nav" class="nav-list hide">
      <li class="nav-item hide">
        <a href="#courses" class="nav-anchor">Electivas</a>
      </li>
      <li class="nav-item hide">
        <a href="#account" class="nav-anchor">Mi Cuenta</a>
      </li>
      <li class="nav-item nav-item-more">
        <a href="#logout" onClick="submit_logout()" class="nav-anchor">Salir</a>
      </li>
    </ul>

    <ul id="admin-nav" class="nav-list hide">
      <li class="nav-item hide">
        <a href="#admin" class="nav-anchor">Administrar</a>
      </li>
      <li class="nav-item nav-item-more">
        <a href="#logout" onClick="submit_logout()" class="nav-anchor">Salir</a>
      </li>
    </ul>

  </section>
</nav>

  <div class="page-container">

	<div id="snackbar"></div>

  <section class="hero has-tag-icon tag-php">
    <h1 id="post-title" >
      Prueba Tecnica
    </h1>
  </section>



  <!-- Seccion para "Ingresar" -->
	<section id="login" class="page-content">

	  <div class="row">

	    <div class="skinny-read">
	      <div class="meta"><em>Ingresar</em></p>
	    </div>

		<div>
		  <p>
		  	<label for="user_id_login"><small style="opacity: 1;">Identificación o Cedula<em>*</em></small></label>
		  	<input type="text" name="user_id_login" id="user_id_login" value="" size="11" tabindex="1" aria-required="true" required>
		  </p>

		  <p style="display: inline-block;">
		  	<input type="button" style="width: 100%;" class="button primary" onClick="submit_login()" value="Ingresar">
		  </p>
		</div>

	    </div>
	  </div>
	</section>
  <!-- FIN :: Seccion para "Ingresar" -->



  <!-- Seccion para "Registro" -->
	<section id="sign_up" class="page-content">

	  <div class="row">

	    <div class="skinny-read">
	       <div class="meta">
          <em>Registro</em></p>
	       </div>

  		<div>

  		  <p>
  		  	<label for="user_id_signup"><small style="opacity: 1;">Identificación o Cedula<em>*</em></small></label>
  		  	<input type="text" name="user_id_signup" id="user_id_signup" value="" size="11" tabindex="1" aria-required="true" required>
  		  </p>

  		  <p>
  		  	<label for="user_name"><small style="opacity: 1;">Nombre<em>*</em></small></label>
  		  	<input type="text" name="user_name" id="user_name" value="" size="255" tabindex="1" aria-required="true" required>
  		  </p>

  		  <p>
  		  	<label for="is_admin"><small style="opacity: 1;">Tipo de Usuario<em>*</em></small></label>
  		  	<select id="is_admin" name="is_admin" required>
  		      <option value="false">Estudiante</option>
  		      <option value="false">Profesor</option>
  		      <option value="true">Administrador</option>
  		    </select>

  		  </p>

  		  <p style="display: inline-block;">
  		  	<input type="button" style="width: 100%;" class="button primary" onClick="submit_sign_up()" value="Registrarse">
  		  </p>
  		</div>

	    </div>
	  </div>
	</section>
  <!-- FIN :: Seccion para "Registro" -->


  <!-- Seccion para Usuario Logueado -->
	<section id="user-board" class="page-content">
    <div class="row">
    <div class="contained control-container search" ><!-- add class search-focused -->
    <!-- Search -->
    <div class="search-container">
      <form class="control-search search-form">
        <label for="search">
          <svg preserveAspectRatio="xMinYMin meet" viewBox="0 0 18 18" class="loading-icon">
            <path class="loading-circle" d="M9,4c2.76,0,5,2.24,5,5s-2.24,5-5,5s-5-2.24-5-5S6.24,4,9,4 M9,0C4.03,0,0,4.03,0,9s4.03,9,9,9s9-4.03,9-9S13.97,0,9,0L9,0z"></path>
            <path class="loading-quarter-circle" d="M16,11c-1.1,0-2-0.9-2-2c0-2.76-2.24-5-5-5C7.9,4,7,3.1,7,2s0.9-2,2-2c4.96,0,9,4.04,9,9C18,10.1,17.1,11,16,11z"></path>
          </svg>

          <svg preserveAspectRatio="xMinYMin meet" viewBox="0 0 16 16" class="search-icon">
            <path d="M15.6,13.5l-4-4c0.6-1,1-2.1,1-3.3C12.5,2.8,9.8,0,6.3,0C2.9,0,0,2.8,0,6.2c0,3.4,2.8,6.2,6.3,6.2
            c1.2,0,2.2-0.3,3.1-0.9l4,4.1c0.5,0.5,1.5,0.5,2.1,0C16.1,15,16.1,14.1,15.6,13.5z M6.5,9.4c-1.8,0-3.3-1.5-3.3-3.2
            C3.2,4.4,4.7,3,6.5,3s3.3,1.5,3.3,3.2C9.7,8,8.3,9.4,6.5,9.4z"></path>
          </svg>
        </label>

        <div class="search-input">
            <input type="text" class="search input-text" id="q" placeholder="Buscar Usuarios y Electivas...">
        </div>
      </form>
    </div>

    <!-- Control Page Items -->
    <ul class="control-page-items">
        <li class="static-option">
          <a class="static-option-label" onClick="find_users()" >Buscar Usuario</a>
        </li>

        <li class="static-option">
          <a class="static-option-label" onClick="find_courses()" >Buscar Electiva</a>
        </li>
    </ul>

    </div>
    <a id="btn-all-inscriptions"class="button button-blue" onClick="user_get_all_courses()" >Mostrar todas las Electivas</a>
    <a id="btn-my-inscriptions" class="button button-blue" onClick="user_get_my_courses()" >Mis Inscripciones</a>
    <a id="btn-new-course" class="button button-alert hide" onClick="admin_new_course()" >Crear Electiva</a>


    <div id="results" class="row" >
      <h3></h3>
      <ul></ul>
    </div>

    <div id="course_form" class="row hide">

        <h3></h3>
        <input type="hidden" value="" id="course_form_id" />
        <input type="hidden" value="" id="course_form_teacher_id" />

        <p>
          <label for="new_course_name">Nombre<em>*</em></label>
          <input type="text" name="new_course_name" id="new_course_name" value="" size="100" tabindex="1" aria-required="true" required>
        </p>

        <p>
          <label for="new_course_description">Descipción<em>*</em></label>
          <input type="text" name="new_course_description" id="new_course_description" value="" size="255" tabindex="1" aria-required="true" required>
        </p>

        <p>
          <label for="new_course_capacity">Cupo<em>*</em></label>
          <input type="text" name="new_course_capacity" id="new_course_capacity" style="max-width:200px;" value="" size="100" tabindex="1" aria-required="true" required>
        </p>

        <p>
          <label for="new_course_teacher">Profesor<em>*</em></label><br/>
          <select id="new_course_teacher" name="new_course_teacher" required></select>
        </p>

          <input id="new_course_create_button" type="button" style="width: 100%;" class="button primary hide" onClick="admin_add_course()" value="Crear">
          <input id="new_course_update_button" type="button" style="width: 100%;" class="button primary hide" onClick="admin_edit_course()" value="Actualizar">
      </div>


	</section>
  <!-- FIN :: Seccion para Usuarios" -->



<section>

  <footer id="footer">

    <div class="treehouse-typelockup"></div>

    <p>
      ©2017 David Antonio Bolaños Lamprea AKA DABELOPER
    </p>

  </footer>

</section>

<script type="text/javascript" language="javascript">
    var user = <?php echo json_encode($_SESSION['user']); ?>;
</script>

<script type="text/javascript" src="./src/resources/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="./src/resources/main.js"></script>

  <body>
<html>