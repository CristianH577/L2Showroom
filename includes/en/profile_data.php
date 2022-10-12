<?php
if ($user != "") {
    if ($user->getRole() == "admin") {
        echo "<div class='float_rigth'>";

        $idUser = $orders_list[0]['id_user'];
        echo '<button type="button" 
        title="Delete user '.$idUser.'" 
        class="emergent_form" 
        data-id="'.$idUser.'"
        data-action="'.constant('URL').$lenguage.'/admin/deleteUser"
        data-msg="Delete user '.$idUser.'?"
        data-name="id_user">';
        echo '<svg class="delete">
            <path d="m15.71 15.71 2.29-2.3 2.29 2.3 1.42-1.42-2.3-2.29 2.3-2.29-1.42-1.42-2.29 2.3-2.29-2.3-1.42 1.42L16.58 12l-2.29 2.29zM12 8a3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4zM6 8a1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z"></path>
        </svg>';
        echo '</button>';
        echo "</div>";
    }
}
?>
<div class="row">
    <?php 
        echo '<img src="'.constant("URL").'assets/profiles/'.$orders_list[0]['img_user'].'" class="img" alt="Profile picture of '.$orders_list[0]['nick'].'" title="Profile picture of '.$orders_list[0]['nick'].'">';
    ?>

    <ul>
        <?php
        if ($user != "") {
            if ($user->getRole() == "admin") {
            echo "<li>";
            echo "<h1>ID:</h1><p>".$orders_list[0]['id_user']."</p>";
            echo "</li>";
            }
        }
        ?>
        <li>
        <h1>User:</h1>
        <p><?php echo $orders_list[0]['nick']; ?></p>
        </li>
        <li>
        <h1>Discord: </h1>
        <p><?php echo $orders_list[0]['discord']; ?></p>
        </li>
    </ul>
</div>