<?php
  $title = "Error";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <main id="errors">
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>

    <div>
      <h1>Page not found</h1>
    </div>
  </main>

  <?php require_once 'views/'.$lenguage.'/footer.php'; ?>

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