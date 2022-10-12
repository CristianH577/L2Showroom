<?php 
  $orders_list = $this->d['orders_list'];
  $users_list = $this->d['users_list'];  
  $actualPage = $this->d['actualPage'];
  $totalPages = $this->d['totalPages'];
  $searchText = $this->d['searchText'];
  $page = $this->d['page'];
  $count = $this->d['count'];
  $title = "Tiendas";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <main>
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>

    <h1>Resultados: <?php echo $count; ?></h1>
    <section id="search">
    <?php
      $search = 'user';
      $filters = ['discord', 'results', 'orderBy'];
      $orderBy = ['id_user', 'nick', 'discord'];
      include_once 'includes/'.$lenguage.'/search.php';
      ?>
    </section>

    <section id="stores">
      <?php
      if (sizeof($orders_list) == 0) {
        echo "<h2>";
        echo '</br>';
        echo "No se encontraron resultados.";
        echo "</h2>";
      }else{
        $orders_list_all = $orders_list;

        for ($i=0; $i < sizeof($users_list); $i++) {
          $orders_list = $orders_list_all[$users_list[$i]];

          $orders = true;
          include 'includes/'.$lenguage.'/profile.php';
          
        }
      }
      ?>
    </section>

    <section class="pagination">
      <?php
      include_once 'includes/'.$lenguage.'/pagination.php';
      ?>
    </section>
  </main>

  <?php require_once 'views/'.$lenguage.'/footer.php'; ?>

  
  <script src="<?php echo constant("URL"); ?>public/js/search_filter.js"></script>

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