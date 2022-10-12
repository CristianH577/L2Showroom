<?php
  $title = "Register";
?>

<?php require_once 'views/'.$lenguage.'/head.php';?>

<body>

<?php require_once 'views/'.$lenguage.'/nav.php'; ?>

<header><p>Register</p></header>

<main id="signup">
<section id="messages">
    <?php $this->showMessages(); ?>
    <div id="charge">
        <img src="../assets/svg/charge.svg" alt="">
        <p></p>
    </div>
</section>

<div class="center">
<form action="<?php echo constant('URL').$lenguage; ?>/signup/newUser" method="POST" name="signup" id="signup" enctype="multipart/form-data" class="form1">
    <ol>
        <li>
            <ul>
                <li>
                    <input type="email" name="email" id="email" placeholder="E-mail*" title="Email">
                </li>
                <li>
                    <div class="password">
                    <input type="password" name="password" id="password" placeholder="Password*" autocomplete="off" title="Password">
                    <svg class="svg_password" onclick="seePassword('password')"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
                    </div>
                </li>
                <li>
                    <div class="password">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password*" autocomplete="off" title="Confirm password">
                    <svg class="svg_password" onclick="seePassword('confirm_password')"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
                    </div>
                </li>
                <li>
                    <input type="text" name="nick" id="nick" placeholder="Nick*" title="Nick">
                </li>
                <li>
                    <input type="text" name="discord" id="discord" placeholder="Discord" title="Discord">
                </li>
                <li>
                    <input type="file" name="new_profile_img" id="new_profile_img" hidden>
                </li>
                <li class="preview">
                <?php 
                    $previewID = "new_profile_img";
                    $previewALT = "Profile picture preview";
                    $previewSRC = constant('URL').'assets/profiles/default.jpg';
                    $previewCLASS = "img";
                    include 'includes/preview.php';
                ?>
                </li>
            </ul>
        </li>
        <li id="console">
            <div class="center">
            <button type="button" title="Register">
                <svg class="svg1" id="register"><path d="M20.29 8.29 16 12.58l-1.3-1.29-1.41 1.42 2.7 2.7 5.72-5.7zM4 8a3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4zm6 0a1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z"></path></svg>
            </button>
            <button type="button" title="Reset form">
                <svg class="svg1 svg-reset" id="clean"><path d="M19.89 10.105a8.696 8.696 0 0 0-.789-1.456l-1.658 1.119a6.606 6.606 0 0 1 .987 2.345 6.659 6.659 0 0 1 0 2.648 6.495 6.495 0 0 1-.384 1.231 6.404 6.404 0 0 1-.603 1.112 6.654 6.654 0 0 1-1.776 1.775 6.606 6.606 0 0 1-2.343.987 6.734 6.734 0 0 1-2.646 0 6.55 6.55 0 0 1-3.317-1.788 6.605 6.605 0 0 1-1.408-2.088 6.613 6.613 0 0 1-.382-1.23 6.627 6.627 0 0 1 .382-3.877A6.551 6.551 0 0 1 7.36 8.797 6.628 6.628 0 0 1 9.446 7.39c.395-.167.81-.296 1.23-.382.107-.022.216-.032.324-.049V10l5-4-5-4v2.938a8.805 8.805 0 0 0-.725.111 8.512 8.512 0 0 0-3.063 1.29A8.566 8.566 0 0 0 4.11 16.77a8.535 8.535 0 0 0 1.835 2.724 8.614 8.614 0 0 0 2.721 1.833 8.55 8.55 0 0 0 5.061.499 8.576 8.576 0 0 0 6.162-5.056c.22-.52.389-1.061.5-1.608a8.643 8.643 0 0 0 0-3.45 8.684 8.684 0 0 0-.499-1.607z"></path></svg>
            </button>
            </div>
        </li>
        <li><p>You have an account? <a href="<?php echo constant('URL').$lenguage. '/login'; ?>" title="Log in">Log in</a></p></li>
    </ol>
</form>
</div>

</main>

<?php require_once 'views/'.$lenguage.'/footer.php'; ?>
  
<script src="<?php echo constant("URL"); ?>public/js/signup.js" type="module"></script>

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