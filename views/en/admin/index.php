<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <header></header>

  <main>
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>
    
    <h1>ADMIN</h1>

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