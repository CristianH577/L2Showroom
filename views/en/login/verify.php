<?php
  $title = "Confirm account";
  $show = $this->d['show'];
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

<?php require_once 'views/'.$lenguage.'/nav.php'; ?>

<header><p>Confirm account</p></header>

<main id="verify">
  <section id="messages">
    <?php $this->showMessages(); ?>
  </section>

  <?php if ($show == "resend") { ?> 
  <form action="<?php echo constant('URL').$lenguage; ?>/verify/resendVerifyLink" method="GET" name="form_verify" class="form1">
    <ol>
      <li>
        <label for="email">Resend verification email: </label>
      </li>
      <li>
        <input type="email" name="email" id="email" placeholder="Email" title="Email">
      </li>
      <li>
        <button type="button" id="validate" title="Resend validation">
          <svg class="svg1"><path d="M20 4H6c-1.103 0-2 .897-2 2v5h2V8l6.4 4.8a1.001 1.001 0 0 0 1.2 0L20 8v9h-8v2h8c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm-7 6.75L6.666 6h12.668L13 10.75z"></path><path d="M2 12h7v2H2zm2 3h6v2H4zm3 3h4v2H7z"></path></svg>
        </button>
      </li>
    </ol>
  </form>
  <?php } ?>

  <?php if ($show == "login") { ?>
    <button class="button">
      <a href="<?php echo constant('URL').$lenguage; ?>/login" id="login" title="Log in">Log in</a>
    </button> 
  <?php } ?>

</main>

<?php require_once 'views/'.$lenguage.'/footer.php'; ?>

<script src="<?php echo constant("URL"); ?>public/js/verify.js" type="module"></script>

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