<article class="profile">
  <div>
    <?php
      include 'includes/'.$lenguage.'/profile_data.php';
    ?>

    <div class="center">
    <?php
      if (isset($orders)) {
        $columns = [ 'img', 'type','name', 'wt', 'price'];
        include 'includes/'.$lenguage.'/orders.php';
      }
    ?>
    </div>
  </div>
  
  <div class="center">
  <a href="<?php echo constant('URL').$lenguage; ?>/store/id/<?php echo $orders_list[0]['id_user']; ?>" title="Ir a la tienda de <?php echo $orders_list[0]['nick']; ?>">
    <svg class="svg2"><path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-15 5 5h-4v5h-2v-5H7l5-5z"></path></svg>
  </a>
  </div>

</article>