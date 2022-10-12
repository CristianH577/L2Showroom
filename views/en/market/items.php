<?php 
$items_list = $this->d['items_list'];
$actualPage = $this->d['actualPage'];
$totalPages = $this->d['totalPages'];
$searchText = $this->d['searchText'];
$page = $this->d['page'];
$count = $this->d['count'];
$title = "Items";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <main>
    <section id="messages">
      <?php $this->showMessages();?>
    </section>

    <?php
      if ($user != "") {
        if ($user->getRole() == "admin") {
          include_once 'includes/'.$lenguage.'/add_item.php';
        }
      }
    ?>

    <h1>Results: <?php echo $count; ?></h1>
    <section id="search">
      <?php
      $search = 'name';
      $filters = ['type', 'description', 'results', 'orderBy'];
      $orderBy = ['id_item', 'type', 'name', 'description'];
      include_once 'includes/'.$lenguage.'/search.php';
      ?>
    </section>

    <section id="items">
      <?php
      $orders_list = $items_list;
      $columns = ['img', 'type', 'name', 'description'];
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

  <script src="<?php echo constant("URL"); ?>public/js/items.js" type="module"></script>
  <script src="<?php echo constant("URL"); ?>public/js/form_add.js"></script>
  <script src="<?php echo constant("URL"); ?>public/js/search_filter.js"></script>
	
</script>

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