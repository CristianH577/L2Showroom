<?php 
  $users_list = $this->d['users_list'];  
  $actualPage = $this->d['actualPage'];
  $totalPages = $this->d['totalPages'];
  $searchText = $this->d['searchText'];
  $page = $this->d['page'];
  $count = $this->d['count'];
  $title = "Usuarios";
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
      $filters = ['id', 'email', 'results', 'orderBy'];
      $orderBy = ['id_user', 'email', 'nick'];
      include_once 'includes/'.$lenguage.'/search.php';
      ?>
    </section>

    <section id="users">
    <?php
    if (sizeof($users_list) == 0) {
    echo "<h2>";
    echo '</br>';
    echo "No se encontraron resultados.";
    echo "</h2>";
    }else{
    echo "<table>";
    echo "<thead>";
    echo "<tr>";

      echo '<th></th>';
      echo '<th>ID</th>';
      echo '<th>Email</th>';
      echo '<th>Usuario</th>';
      echo '<th>Registro</th>';
      echo '<th></th>';

    echo "</tr>";
    echo "</thead>";

        echo '<tbody>';

    for ($i=0; $i < sizeof($users_list); $i++) {

      if ($users_list[$i]['active'] == 1) {
        $active = "user-active";
      }else{
        $active = "user-inactive";
      }

        echo '<tr class="'.$active.'">';

        echo "<td>";
        echo '<img src="'.constant("URL").'assets/profiles/'.$users_list[$i]['img_user'].'" class="img" alt="Imagen de perfil de " title="">';
        echo "</td>";

        echo "<td>";
        echo $users_list[$i]['id_user'];
        echo "</td>";

        echo "<td>";
        echo $users_list[$i]['email'];
        echo "</td>";

        echo "<td>";
        echo $users_list[$i]['nick'];
        echo "</td>";

        echo "<td>";
        echo $users_list[$i]['register'];
        echo "</td>";

        echo "<td>";

        $idUser = $users_list[$i]['id_user'];
        echo '<button type="button" 
        title="Eliminar usuario '.$idUser.'" 
        class="emergent_form" 
        data-id="'.$idUser.'"
        data-action="'.constant('URL').$lenguage.'/admin/deleteUser"
        data-msg="Eliminar usuario '.$idUser.'?"
        data-name="id_user">';
        echo '<svg class="delete">
            <path d="m15.71 15.71 2.29-2.3 2.29 2.3 1.42-1.42-2.3-2.29 2.3-2.29-1.42-1.42-2.29 2.3-2.29-2.3-1.42 1.42L16.58 12l-2.29 2.29zM12 8a3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4zM6 8a1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z"></path>
        </svg>';
        echo '</button>';
        
        echo "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

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

<script src="<?php echo constant("URL"); ?>public/js/users.js" type="module"></script>
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