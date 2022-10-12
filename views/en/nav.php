<?php
  include_once 'includes/'.$lenguage.'/nav_session.php';
?>

<nav id="menu">
  <div class="nav_container">
    <input type="checkbox" id="menu_check" class="nav_input">
    <label for="menu_check" class="nav_label">
      <svg id="abrir"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path></svg>
      <svg id="cerrar"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
    </label>

    <ul class="nav_menu">
      <li id="nav_home">
        <a href="<?php echo constant('URL').$lenguage.'/main'; ?>" class="nav_item" title="Home">Home</a>
      </li>

      <li id="nav_market">
        <div>
          <a href="<?php echo constant("URL").$lenguage; ?>/market" class="nav_item" title="Market">Market<svg><path d="m12 15.586-4.293-4.293-1.414 1.414L12 18.414l5.707-5.707-1.414-1.414z"></path><path d="m17.707 7.707-1.414-1.414L12 10.586 7.707 6.293 6.293 7.707 12 13.414z"></path></svg></a>
          <svg class="svg-movil"><path d="m12 15.586-4.293-4.293-1.414 1.414L12 18.414l5.707-5.707-1.414-1.414z"></path><path d="m17.707 7.707-1.414-1.414L12 10.586 7.707 6.293 6.293 7.707 12 13.414z"></path></svg>
        </div>
        <ul class="submenu">
          <li><a href="<?php echo constant("URL").$lenguage; ?>/items" title="Items">Items</a></li>
        </ul>
      </li>

      <li class="submenu" id="submenu_nav_market">
        <a href="<?php echo constant("URL").$lenguage; ?>/items" title="Items" class="nav_item">Items</a>
      </li>

      <li id="nav_stores">
        <a href="<?php echo constant("URL").$lenguage; ?>/stores" class="nav_item" title="Stores">Stores</a>
      </li>

      <li id="nav_contact">
        <a href="<?php echo constant("URL").$lenguage; ?>/contact" class="nav_item" title="Contact">Contact</a>
      </li>
    </ul>
  </div>
</nav>