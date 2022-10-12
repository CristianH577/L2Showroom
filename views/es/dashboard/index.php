<?php 
  $title = "Cuenta";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <header><p>Mi Cuenta</p></header>

  <main>
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>
    
    <section id="profile">
      <div class="row">
        <div>
          <?php 
            $previewID = "new_profile_img";
            $previewALT = "Imagen de perfil de ".$user->getNick();
            $previewSRC = constant('URL').'assets/profiles/'.$user->getImg();
            $previewCLASS = "img";
            include 'includes/preview.php';
          ?>
          
          <div class="center" id="actions_profile_img">
            <button type="button" title="Eliminar imagen de perfil" id="delete_img">
              <svg class="svg1"><path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path><path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path></svg>
            </button>
          </div>
        </div>
        
      <form action="<?php echo constant('URL'); ?>es/dashboard/updateChanges" method="POST" name="form_update" id="form_update" enctype="multipart/form-data" class="form1">
      <ul>
        <li>
          <input type="hidden" name="id" id="id" autocomplete="off" value="<?php echo $user->getId(); ?>">
        </li>
        <li>
          <label for="email">Email: </label>
          <input type="email" name="email" id="email" placeholder="Email*" value="<?php echo $user->getEmail(); ?>" title="Email">
        </li>
        <li>
          <label for="nick">Alias: </label>
          <input type="text" name="nick" id="nick" placeholder="Alias*" value="<?php echo $user->getNick(); ?>" title="Alias">
        </li>
        <li>
          <label for="discord">Discord: </label>
          <input type="text" name="discord" id="discord" placeholder="Discord" value="<?php echo $user->getDiscord(); ?>" title="Discord">
        </li>
        <div id="change_data">
          <li>
            <input type="file" name="new_profile_img" id="new_profile_img" hidden>
            <input type="text" name="action_img" id="action_img" hidden>
          </li>
          <li>
            <div class="password">
            <input type="password" name="new_password" id="new_password" placeholder="Nueva contraseña" autocomplete="off" title="Nueva contraseña">
            <svg class="svg_password" data-id="new_password"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
            </div>
          </li>
          <li>
            <div class="password">
            <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirmar contraseña" autocomplete="off" title="Confirmar nueva contraseña">
            <svg class="svg_password" data-id="confirm_new_password"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
            </div>
          </li>
          <li>
            <div class="password">
              <input type="password" name="password" id="password" placeholder="Contraseña actual*" autocomplete="off" title="Contraseña actual">
              <svg class="svg_password" data-id="password"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
            </div>
          </li>
        
          <div class="center" id="actions_profile_data">
            <button type="button" id="update" title="Guardar cambios">
              <svg class="svg1"><path d="M5 21h14a2 2 0 0 0 2-2V8a1 1 0 0 0-.29-.71l-4-4A1 1 0 0 0 16 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2zm10-2H9v-5h6zM13 7h-2V5h2zM5 5h2v4h8V5h.59L19 8.41V19h-2v-5a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v5H5z"></path></svg>
            </button>

            <button type="button" id="resetForm" title="Resetear formulario">
              <svg class="svg1"><path d="M19.89 10.105a8.696 8.696 0 0 0-.789-1.456l-1.658 1.119a6.606 6.606 0 0 1 .987 2.345 6.659 6.659 0 0 1 0 2.648 6.495 6.495 0 0 1-.384 1.231 6.404 6.404 0 0 1-.603 1.112 6.654 6.654 0 0 1-1.776 1.775 6.606 6.606 0 0 1-2.343.987 6.734 6.734 0 0 1-2.646 0 6.55 6.55 0 0 1-3.317-1.788 6.605 6.605 0 0 1-1.408-2.088 6.613 6.613 0 0 1-.382-1.23 6.627 6.627 0 0 1 .382-3.877A6.551 6.551 0 0 1 7.36 8.797 6.628 6.628 0 0 1 9.446 7.39c.395-.167.81-.296 1.23-.382.107-.022.216-.032.324-.049V10l5-4-5-4v2.938a8.805 8.805 0 0 0-.725.111 8.512 8.512 0 0 0-3.063 1.29A8.566 8.566 0 0 0 4.11 16.77a8.535 8.535 0 0 0 1.835 2.724 8.614 8.614 0 0 0 2.721 1.833 8.55 8.55 0 0 0 5.061.499 8.576 8.576 0 0 0 6.162-5.056c.22-.52.389-1.061.5-1.608a8.643 8.643 0 0 0 0-3.45 8.684 8.684 0 0 0-.499-1.607z"></path></svg>
            </button>

            <button type="button" id="cancel" title="Cancelar edicion">
              <svg class="svg1"><path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path><path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path></svg>
            </button>
          </div>
        </div>
        
        </ul>

        </form>
      </div>

      <div class="center" id="actions">
        <button type="button" 
        title="Eliminar cuenta" 
        class="emergent_form" 
        data-id="<?php echo $user->getId(); ?>" 
        data-action="<?php echo constant('URL'); ?>es/dashboard/deleteAccount" 
        data-msg="Esta seguro que desea ELIMINAR su cuenta PERMANENTEMENTE?" 
        data-name="delete_user">
          <svg class="svg1">
            <path d="m15.71 15.71 2.29-2.3 2.29 2.3 1.42-1.42-2.3-2.29 2.3-2.29-1.42-1.42-2.29 2.3-2.29-2.3-1.42 1.42L16.58 12l-2.29 2.29zM12 8a3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4zM6 8a1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z"></path>
          </svg>
        </button>

        <button type="button" id="edit" title="Editar perfil">
          <svg class="svg1">
            <path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path><path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path>
          </svg>
        </button>
      </div>
      
    </section>
  </main>

<?php require_once 'views/'.$lenguage.'/footer.php'; ?>

<script src="<?php echo constant("URL"); ?>public/js/dashboard.js" type="module"></script>

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