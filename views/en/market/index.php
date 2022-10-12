<?php 
  $orders_list = $this->d['orders_list'];
  $actualPage = $this->d['actualPage'];
  $totalPages = $this->d['totalPages'];
  $searchText = $this->d['searchText'];
  $page = $this->d['page'];
  $count = $this->d['count'];
  $title = "Market";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <main>
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>

    <h1>Results: <?php echo $count; ?></h1>
    <section id="search">
      <?php
      $search = 'name';
      $filters = ['id_order', 'type', 'wt', 'trade', 'results', 'orderBy'];
      $orderBy = ['id_order', 'type', 'name', 'wt', 'price', 'quantity', 'nick'];
      $char = true;
      include_once 'includes/'.$lenguage.'/search.php';
      ?>
    </section>

    <section id="orders">
      <?php
      $columns = ['img', 'type', 'name', 'wt', 'price', 'quantity', 'user'];
      include_once 'includes/'.$lenguage.'/orders.php';
      ?>
    </section>

    <section class="pagination">
      <?php
      include_once 'includes/'.$lenguage.'/pagination.php';
      ?>
    </section>

  </main>

  <?php require_once 'views/'.$lenguage.'/footer.php'; ?>

  <script src="<?php echo constant("URL"); ?>public/js/market.js" type="module"></script>
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