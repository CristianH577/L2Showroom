<?php 
  $orders_list = $this->d['orders_list'];
  $actualPage = $this->d['actualPage'];
  $totalPages = $this->d['totalPages'];
  $searchText = $this->d['searchText'];
  $page = $this->d['page'];
  $count = $this->d['count'];
  $title = "Store";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <header><p>Store of <?php echo $orders_list[0]['nick']; ?></p></header>
  
  <main id="store">
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>

    <section class="profile">
      <div>
        <?php
        $i=0;
        include 'includes/'.$lenguage.'/profile_data.php';
        ?>
      </div>
    </section>

    <h1>Results: <?php echo $count; ?></h1>
    <section id="search">
      <?php
      $search = 'name';
      $filters = ['type', 'wt', 'results', 'orderBy'];
      $orderBy = ['id_order', 'type', 'name', 'wt', 'price', 'quantity'];
      include_once 'includes/'.$lenguage.'/search.php';
      ?>
    </section>

    <section id="orders">
      <?php
      $columns = ['img', 'type', 'name', 'wt', 'price', 'quantity'];
      $char = true;
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

  <script src="<?php echo constant("URL"); ?>public/js/store.js" type="module"></script>
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