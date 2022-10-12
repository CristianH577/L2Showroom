
<?php 
  $new_orders_list = $this->d['new_orders_list'];
  $new_users_list = $this->d['new_users_list'];
  $new_users_orders_list = $this->d['new_users_orders_list'];
  $page = $this->d['page'];
  $title = "Inicio";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

<?php require_once 'views/'.$lenguage.'/nav.php'; ?>

<main id="home">
  <section id="messages">
    <?php $this->showMessages(); ?>
  </section>

  <section id="slider-container">
    <?php
    if (sizeof($new_users_list) == 0) {
    }else{
      $orders = true;
      for ($i=0; $i < sizeof($new_users_list); $i++) {
        $orders_list = $new_users_orders_list[$new_users_list[$i]];
        echo '<div class="slider-item center">';
        include 'includes/'.$lenguage.'/profile.php';
        echo '</div>';
      }
    }
    ?>
  </section>
  
  <div id="slider-console">
    <?php
    if (sizeof($new_users_list) != 0) {
      echo '<button class="active" title="Deslizador posicion 1">-</button>';
      if (sizeof($new_users_list) != 0) {
        for ($i=1; $i < sizeof($new_users_list); $i++) {
          echo '<button title="Deslizador posicion '.($i+1).'">-</button>';
        }
      }
    }
    ?>
  </div>

  <section id="orders">
    <div class="title"><p>Ultimas ordenes</p></div>

    <div>
      <?php
      $columns = ['img', 'type', 'name', 'wt', 'price', 'quantity', 'user'];
      $orders_list = $new_orders_list;
      include 'includes/'.$lenguage.'/orders.php';
      ?>
    </div>
  </section>

</main>

<?php require_once 'views/'.$lenguage.'/footer.php'; ?>

<script src="<?php echo constant("URL"); ?>public/js/main.js"></script>
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
