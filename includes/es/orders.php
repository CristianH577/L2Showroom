<?php
if (sizeof($orders_list) == 0 || !isset($orders_list[0]['id_item'])) {
echo "<h2>";
echo '</br>';
echo "No se encontraron resultados.";
echo "</h2>";
}
else{
echo '<div class="table_container">';
echo '<table>';
echo "<thead>";
echo "<tr>";

if (!isset($delete)) {
    $delete = false;
}

for ($c_orders=0; $c_orders < sizeof($columns); $c_orders++) {
    switch ($columns[$c_orders]) {
        case 'id':
            echo '<th class="id">';
            echo 'ID';
            echo '</th>';
            break;
        case 'img':
            echo '<th>';
            echo '';
            echo '</th>';
            break;
        case 'type':
            echo '<th class="type">';
            echo 'Tipo';
            echo '</th>';
            break;
        case 'name':
            echo '<th class="name">';
            echo 'Nombre';
            echo '</th>';
            break;
        case 'wt':
            echo '<th class="wt">';
            echo 'WT';
            echo '</th>';
            break;
        case 'price':
            echo '<th class="price">';
            echo '<img src="'.constant("URL").'assets/items/adena.png" alt="Adena" title="Adena" class="icon">';
            echo '</th>';
            break;
        case 'quantity':
            echo '<th class="quantity">';
            echo 'Cantidad';
            echo '</th>';
            break;
        case 'user':
            echo '<th class="user">';
            echo '';
            echo '</th>';
            break;
        case 'date':
            echo '<th class="date">';
            echo 'Registro';
            echo '</th>';
            break;
        case 'description':
            echo '<th class="date">';
            echo 'Descripcion';
            echo '</th>';
            break;
        
        default:
            # code...
            break;
    }
}

if ($user != "") {
    if ($delete || $user->getRole() == "admin") {
        echo '<th></th>';
    }
}

echo "</tr>";
echo "</thead>";
echo '<tbody>';

for ($t_orders=0; $t_orders < sizeof($orders_list); $t_orders++) {

    $type = explode('_', $orders_list[$t_orders]['type']);
    if (isset($orders_list[$t_orders]['char_data'])) {
        $char_data = explode('_', $orders_list[$t_orders]['char_data']);
    }

    if ($type[0] == "Character" && isset($char)) {
        $add = 'class="char" data-id="'.$orders_list[$t_orders]['id_order'].'"';
    }else{
        $add = '';
    }

    echo '<tr '.$add.'>';

    for ($c_orders=0; $c_orders < sizeof($columns); $c_orders++) {
        switch ($columns[$c_orders]) {
            case 'id':
                echo '<td class="id">';
                echo $orders_list[$t_orders]['id_order'];
                echo "</td>";
                break;
            case 'img':
                echo '<td>';
                echo '<img src="'.constant("URL").'assets/items/'.$orders_list[$t_orders]['img_item'].'" 
                class="icon" 
                alt="'.$orders_list[$t_orders]['name_item'].'" 
                title="'.$orders_list[$t_orders]['name_item'].'">';
                echo "</td>";
                break;
            case 'type':
                echo '<td class="type">';
                echo $type[0];
                echo "</td>";
                break;
            case 'name':
                echo "<td>";
                if ($type[0] == "Character") {
                    if (isset($orders_list[$t_orders]['char_data'])) {
                        echo $char_data[2]." lv.".$char_data[3];
                    }
                }else{
                    echo $orders_list[$t_orders]['name_item'];
                }
                echo "</td>";
                break;
            case 'wt':
                echo '<td class="wt">';
                echo $orders_list[$t_orders]['wt'];
                echo "</td>";
                break;
            case 'price':
                echo '<td class="price number">';
                echo number_format($orders_list[$t_orders]['price']);
                echo "</td>";
                break;
            case 'quantity':
                echo '<td class="quantity number">';
                echo number_format($orders_list[$t_orders]['quantity']);
                echo "</td>";
                break;
            case 'user':
                echo "<td>";
                echo '<a href="'.constant("URL").'store/id/'.$orders_list[$t_orders]['id_user'].'" title="Ir a la tienda de '.$orders_list[$t_orders]['nick'].'">'.$orders_list[$t_orders]['nick'].'</a>';
                echo "</td>";
                echo "</td>";
                break;
            case 'date':
                echo '<td class="date">';
                echo $orders_list[$t_orders]['register'];
                echo "</td>";
                break;
            case 'description':
                echo '<td class="description">';
                echo $orders_list[$t_orders]['description'];
                echo "</td>";
                break;
            
            default:
                # code...
                break;
        }
    }
    
    if ($user != "") {
        if (($delete || $user->getRole() == "admin") && isset($orders_list[$t_orders]['id_order'])) {
            if ($delete) {
                $action = "/mystore/deleteOrder";
            }else{
                $action = "/admin/deleteOrder";
            }
            $idOrder = $orders_list[$t_orders]['id_order'];

            echo "<td>";

            echo '<button type="button" 
            title="Eliminar orden '.$idOrder.'" 
            class="emergent_form" 
            data-id="'.$idOrder.'"
            data-action="'.constant('URL').$lenguage.$action.'"
            data-msg="Eliminar orden '.$idOrder.'?"
            data-name="id_order">';
            echo '<svg class="delete">
                <path d="M16 2H8C4.691 2 2 4.691 2 8v13a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 14c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v8z"></path><path d="M15.292 7.295 12 10.587 8.708 7.295 7.294 8.709l3.292 3.292-3.292 3.292 1.414 1.414L12 13.415l3.292 3.292 1.414-1.414-3.292-3.292 3.292-3.292z"></path>
            </svg>';
            echo '</button>';
            
            echo "</td>";
        }
        if ($user->getRole() == "admin") {
            $action = "/admin/deleteItem";
            $idItem = $orders_list[$t_orders]['id_item'];
            $nameItem = $orders_list[$t_orders]['name_item'];

            echo "<td>";

            echo '<button type="button" 
            title="Eliminar objeto '.$idItem.'" 
            class="emergent_form" 
            data-id="'.$idItem.'"
            data-action="'.constant('URL').$lenguage.$action.'"
            data-msg="Eliminar objeto '.$nameItem.'?"
            data-name="id_item">';
            echo '<svg class="delete">
                <path d="M8.586 18 12 21.414 15.414 18H19c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h3.586zM5 4h14v12h-4.414L12 18.586 9.414 16H5V4z"></path><path d="M9.707 13.707 12 11.414l2.293 2.293 1.414-1.414L13.414 10l2.293-2.293-1.414-1.414L12 8.586 9.707 6.293 8.293 7.707 10.586 10l-2.293 2.293z"></path>
            </svg>';
            echo '</button>';
            
            echo "</td>";
        }
    }

    echo "</tr>";

    if (isset($char) && $type[0] == "Character" && $orders_list[$t_orders]['char_imgs'] != "") {
        $char_imgs = explode(',', $orders_list[$t_orders]['char_imgs']);

        $text = $char_data[2]." lv.".$char_data[3];

        echo '<tr class="char_imgs" id="imgs-'.$orders_list[$t_orders]['id_order'].'">';
        echo '<td colspan="9">';
        echo '<div class="center">';

        for ($i=0; $i < sizeof($char_imgs); $i++) {
            echo '<figure class="zoom">
            <img src="'.constant("URL").'assets/chars/'.$char_imgs[$i].'" class="img" alt="'.$text.'" title="'.$text.'">
            </figure>';
        }

        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
}
echo "</tbody>";
echo "</table>";
echo '</div>';

}
?>

