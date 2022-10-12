<?php

class App{

    private $maintenance = false;

    function __construct(){

        if (isset($_GET['url']) && $_GET['url'] != null) {
            $url0 = $_GET['url'];
            $url = rtrim($url0, '/');
            $url = explode('/', $url0);
        }
    
        if(empty($url[0])){
            //error_log('APP::construct-> no language specified');
            $lenguage = "es";
            header('Location: ' . constant('URL') . $lenguage);
        }else{
            $dir = 'views/'.$url[0];
            if (!is_dir($dir)) {
                //error_log('APP::construct-> no view of the specified language');
                header('Location: ' . constant('URL') . 'es/' . $url0);
                return false;
            }else{
                $lenguage = $url[0];
            }
        }

        if ($this->maintenance) {
            $archivoController = 'controllers/maintenance.php';
            require_once $archivoController;
            $controller = new Maintenance();
            $controller->loadModel('maintenance');
            $controller->setData($lenguage, 'maintenance');
            $controller->render();
            return false;
        }

        if(empty($url[1])){
            //error_log('APP::construct-> there is not a specific controller');
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            $controller = new Main();
            $controller->loadModel('main');
            $controller->setData($lenguage, 'main');
            $controller->render();
            return false;
        }else{
            $archivoController = 'controllers/' . $url[1] . '.php';
        }

        if(file_exists($archivoController)){

            require_once $archivoController;

            $controller = new $url[1];
            $controller->loadModel($url[1]);
            $controller->setData($lenguage, $url[1]);

            $nparam = sizeof($url);

            if($nparam > 2){
                if($nparam > 3){

                    $param = [];
                    for($i = 3; $i<$nparam; $i++){
                        array_push($param, $url[$i]);
                    }

                    if (method_exists($controller, $url[2])) {
                        $controller->{$url[2]}($param);
                    }else{
                        return $this->error($lenguage);
                    }
                }else{

                    if (method_exists($controller, $url[2])) {
                        $controller->{$url[2]}();
                    }else{
                        return $this->error($lenguage);
                    }
                    
                }
            }else{
                $controller->render();
            }
        }else{
            return $this->error($lenguage);
        }
    }

    function error($lenguage){
        $archivoController = 'controllers/errors.php';
        require_once $archivoController;
        $controller = new Errors();
        $controller->loadModel('errors');
        $controller->setData($lenguage, 'errors');
        $controller->render();
        return false;
    }

}
?>