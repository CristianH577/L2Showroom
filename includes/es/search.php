<?php if (isset($page)) {
  $url = constant("URL").$lenguage.'/'.$page;
}else{
  $url = "";
} 

echo '<form action="'.$url.'" method="GET" name="search">';
echo '<div class="center">';

  echo '<ul>';
    echo '<li id="search_input_container">';
    switch ($search) {
      case 'name':
        if(isset($_GET['name'])){ 
          $name = str_replace(' ','&nbsp;',$_GET['name']);
        }else{
          $name = "";
        }
        echo '<input type="search" name="name" placeholder="Buscar objeto" autocomplete="off" value="'.$name.'" title="Buscar objeto">';
        break;

      case 'user':
        if(isset($_GET['nick'])){ 
          $nick = str_replace(' ','&nbsp;',$_GET['nick']);
        }else{
          $nick = "";
        }
        echo '<input type="search" name="nick" placeholder="Buscar usuario" autocomplete="off" value="'.$nick.'" title="Buscar usuario">';
        break;
    }

    echo '</li>';

  echo '<li>';
    echo '<button title="Buscar">
      <svg class="svg2"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path></svg>
    </button>';
  
    if ($filters) {
      echo '<input type="checkbox" name="filter_check" id="filter_check" hidden>';
      echo '<label for="filter_check" title="Mostrar/ocultar filtros">';
      echo '<svg class="svg2"><path d="M13 5h9v2h-9zM2 7h7v2h2V3H9v2H2zm7 10h13v2H9zm10-6h3v2h-3zm-2 4V9.012h-2V11H2v2h13v2zM7 21v-6H5v2H2v2h3v2z"></path></svg>';
      echo '</label>';

      echo '<button type="button" title="Reiniciar formulario" id="resetSearch">
        <svg class="svg2"><path d="M19.89 10.105a8.696 8.696 0 0 0-.789-1.456l-1.658 1.119a6.606 6.606 0 0 1 .987 2.345 6.659 6.659 0 0 1 0 2.648 6.495 6.495 0 0 1-.384 1.231 6.404 6.404 0 0 1-.603 1.112 6.654 6.654 0 0 1-1.776 1.775 6.606 6.606 0 0 1-2.343.987 6.734 6.734 0 0 1-2.646 0 6.55 6.55 0 0 1-3.317-1.788 6.605 6.605 0 0 1-1.408-2.088 6.613 6.613 0 0 1-.382-1.23 6.627 6.627 0 0 1 .382-3.877A6.551 6.551 0 0 1 7.36 8.797 6.628 6.628 0 0 1 9.446 7.39c.395-.167.81-.296 1.23-.382.107-.022.216-.032.324-.049V10l5-4-5-4v2.938a8.805 8.805 0 0 0-.725.111 8.512 8.512 0 0 0-3.063 1.29A8.566 8.566 0 0 0 4.11 16.77a8.535 8.535 0 0 0 1.835 2.724 8.614 8.614 0 0 0 2.721 1.833 8.55 8.55 0 0 0 5.061.499 8.576 8.576 0 0 0 6.162-5.056c.22-.52.389-1.061.5-1.608a8.643 8.643 0 0 0 0-3.45 8.684 8.684 0 0 0-.499-1.607z"></path></svg>
      </button>';
    }
  
  echo '</li>';

  echo '</ul>';

  echo '<ul id="filter_list">';
  for ($f_orders=0; $f_orders < sizeof($filters); $f_orders++) {
    switch ($filters[$f_orders]) {
      case 'wt':
        echo '<li>';
        echo '<select name="wt" title="Filtro: WT">';
          echo '<option value="" title="Sin definir">WT</option>
          <option value="S" title="Vender">Vender</option>
          <option value="B" title="Comprar">Comprar</option>
          <option value="S/T" title="Vender/Cambiar">Vender/Cambiar</option>
          <option value="B/T" title="Comprar/Cambiar">Comprar/Cambiar</option>';
        echo '</select>';
        echo '</li>';
        break;

      case 'type':
        echo '<li>';
        echo '<select name="type" title="Filtro: tipo">';
        echo '<option value="" title="Sin definir">Tipo</option>';
        include 'includes/'.$lenguage.'/type_options.php';
        echo '</select>';
        echo '</li>';
        break;

      case 'description':
        if(isset($_GET['description'])){ 
          $description = str_replace(' ','&nbsp;',$_GET['description']);
        }else{
          $description = "";
        }

        echo '<li>';
        echo '<input type="text" name="description" placeholder="Descripcion" value="'.$description.'" title="Filtro: desctripcion">';
        echo '</li>';
        break;

      case 'id':
        if(isset($_GET['id'])){ 
          $id = str_replace(' ','&nbsp;',$_GET['id']);
        }else{
          $id = "";
        }
        echo '<li>';
        echo '<input type="number" name="id" id="id" placeholder="ID" value="'.$id.'" title="Filtro: ID">';
        echo '</li>';
        break;

      case 'email':
        if(isset($_GET['email'])){ 
          $email = str_replace(' ','&nbsp;',$_GET['email']);
        }else{
          $email = "";
        }
        echo '<li>';
        echo '<input type="text" name="email" placeholder="Email" value="'.$email.'" title="Filtro: email">';
        echo '</li>';
        break;

      case 'discord':
        if(isset($_GET['discord'])){ 
          $discord = str_replace(' ','&nbsp;',$_GET['discord']);
        }else{
          $discord = "";
        }
        echo '<li>';
        echo '<input type="text" name="discord" placeholder="Discord" value="'.$discord.'" title="Filtro: discord">';
        echo '</li>';
        break;

      case 'results':
        echo '<li>';
        echo '
        <select name="results" id="results" title="Filtro: resultados a mostrar">
          <option value="">Resultados</option>
          <option value="12">12</option>
          <option value="24">24</option>
          <option value="36">36</option>
          <option value="48">48</option>
          <option value="60">60</option>
        </select>';
        echo '</li>';
        break;

        case 'orderBy':
          echo '<li>';
          echo '<select name="orderBy" id="orderBy" title="Filtro: ordenar por">';
          echo '<option value="">Mas Antiguas</option>';
          echo '<option value="'.$orderBy[0].' DESC">Mas Recientes</option>';
          for ($i_by=1; $i_by < sizeof($orderBy); $i_by++) { 
            switch ($orderBy[$i_by]) {
              case 'type':
                echo '<option value="type">Tipo ↓</option>
                <option value="type DESC">Tipo ↑</option>';
                break;
              case 'name':
                echo '<option value="name_item">Nombre ↓</option>
                <option value="name_item DESC">Nombre ↑</option>';
                break;
              case 'wt':
                echo '<option value="wt">WT ↓</option>
                <option value="wt DESC">WT ↑</option>';
                break;
              case 'price':
                echo '<option value="price">Precio ↓</option>
                <option value="price DESC">Precio ↑</option>';
                break;
              case 'quantity':
                echo '<option value="quantity">Cantidad ↓</option>
                <option value="quantity DESC">Cantidad ↑</option>';
                break;
              case 'nick':
                echo '<option value="nick">Alias ↓</option>
                <option value="nick DESC">Alias ↑</option>';
                break;
              case 'description':
                echo '<option value="description">Descripcion ↓</option>
                <option value="description DESC">Descripcion ↑</option>';
                break;
              case 'email':
                echo '<option value="email">Email ↓</option>
                <option value="email DESC">Email ↑</option>';
                break;
              case 'discord':
                echo '<option value="discord">Discord ↓</option>
                <option value="discord DESC">Discord ↑</option>';
                break;
              
              default:
                break;
            }
          }
          echo '</select>';
          echo '</li>';
          break;
      
      default:
        break;

    }
  }
  echo '</ul>';

echo '</div>';
echo '</form>';

?>
