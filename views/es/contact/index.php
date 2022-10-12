<?php
  $title = "Contacto";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

<?php require_once 'views/'.$lenguage.'/nav.php'; ?>

<header><p>Contacto</p></header>

<main id="contact">
  <section id="messages">
    <?php $this->showMessages();?>
    <div id="charge">
        <img src="../assets/svg/charge.svg" alt="">
        <p></p>
    </div>
  </section>

  <div class="center">
  <form action="<?php echo constant('URL'); ?>es/contact/sendMail" method="post" name="contact" class="form1" id="form_contact">
    <ol>
      <li>
        <ul>
          <li>
            <input type="text" name="email" id="email" placeholder="Email*" title="Email">
          </li>
          <li>
            <input type="text" name="name" id="name" placeholder="Nombre*" title="Nombre">
          </li>
          <li>
            <input type="text" name="subject" id="subject" placeholder="Asunto*" title="Asunto">
          </li>
          <li>
            <textarea name="contact_message" id="contact_message" cols="30" rows="10" placeholder="Mensaje*" title="Mensaje"></textarea>
          </li>
        </ul>
      </li>
      
      <button type="button" title="Enviar mensaje" id="send">
      <svg class="svg1"><path d="M20 4H6c-1.103 0-2 .897-2 2v5h2V8l6.4 4.8a1.001 1.001 0 0 0 1.2 0L20 8v9h-8v2h8c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm-7 6.75L6.666 6h12.668L13 10.75z"></path><path d="M2 12h7v2H2zm2 3h6v2H4zm3 3h4v2H7z"></path></svg>
      </button>
    </ol>
  </form>
  </div>
  
</main>

<?php require_once 'views/'.$lenguage.'/footer.php'; ?>

<script src="<?php echo constant("URL"); ?>public/js/contact.js" type="module"></script>

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