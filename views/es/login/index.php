<?php 
  $title = "Iniciar Sesion";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <header><p>Iniciar sesion</p></header>

  <main id="login">
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>

    <div class="center">
    <form action="<?php echo constant('URL').$lenguage; ?>/login/authenticate" method="POST" name="login" class="form1">
      <ol>
        <li>
          <ul>
            <li>
              <input type="text" name="email" id="email" placeholder="Email" title="Email">
            </li>
            <li>
              <div class="password">
              <input type="password" name="password" id="password" placeholder="Contraseña" autocomplete="off" title="Contraseña">
              <svg class="svg_password" id="svg_password"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
              </div>
            </li>
            <li>
              <label class="content-input">
                <input type="checkbox" name="remember_user" id="remember_user" hidden>Mantener sesion abierta
                <i title="Mantener sesion abierta"></i>
              </label>
            </li>
          </ul>
        </li>
        <li>
          <button type="button" title="Iniciar sesion" id="log">
            <svg class="svg1"><path d="m10.998 16 5-4-5-4v3h-9v2h9z"></path><path d="M12.999 2.999a8.938 8.938 0 0 0-6.364 2.637L8.049 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051S20 10.13 20 12s-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637C21.063 16.665 22 14.405 22 12s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z"></path></svg>
          </button>
        </li>
        <li>
          <p>¿No tienes cuenta? <a href="<?php echo constant('URL').$lenguage; ?>/signup" title="Registrarse">Registrarse</a></p>
        </li>
      </ol>
    </form>
    </div>
    
  </main>

<?php require_once 'views/'.$lenguage.'/footer.php'; ?>
  
<script src="<?php echo constant("URL"); ?>public/js/login.js" type="module"></script>

</body>

</html>

<?php
ob_end_flush(); 
function compressPage($buffer) { 
    $get = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'); 
    $replace = array('>','<','\\1'); 
    return preg_replace($get, $replace, $buffer); 
} 
?>