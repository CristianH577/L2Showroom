<?php 
  $orders_list = $this->d['orders_list']; 
  $actualPage = $this->d['actualPage'];
  $totalPages = $this->d['totalPages'];
  $searchText = $this->d['searchText'];
  $page = $this->d['page'];
  $count = $this->d['count'];
  $title = "My store";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

  <?php require_once 'views/'.$lenguage.'/nav.php'; ?>

  <header><p>My store</p></header>

  <main>
    <section id="messages">
      <?php $this->showMessages(); ?>
    </section>

    <section class="profile">
      <div class="row">
        <img src="<?php echo constant("URL").'assets/profiles/'.$user->getImg(); ?>" alt="Profile picture preview" title="Profile picture preview" class="img">
  
        <ul id="data">
          <li>
            <h1>User:</h1>
            <p><?php echo $user->getNick(); ?></p>
          </li>
          <li>
            <h1>Discord: </h1>
            <p><?php echo $user->getDiscord(); ?></p>
          </li>
        </ul>
      </div>
    </section>

    <?php
      include_once 'includes/'.$lenguage.'/add_order.php';
    ?>
  
    <h1>Results: <?php echo $count; ?></h1>
    <section id="search">
      <?php
      $search = 'name';
      $filters = ['type', 'wt', 'trade', 'results', 'orderBy'];
      $orderBy = ['id_order', 'type', 'name', 'wt', 'price', 'quantity'];
      include_once 'includes/'.$lenguage.'/search.php';
      ?>
    </section>

    <section id="orders">
      <?php
      $delete = true;
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

<script src="<?php echo constant("URL"); ?>public/js/mystore.js" type="module"></script>
<script src="<?php echo constant("URL"); ?>public/js/search_filter.js"></script>
<script src="<?php echo constant("URL"); ?>public/js/form_add.js"></script>

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