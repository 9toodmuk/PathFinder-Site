<?php
namespace Controller\View;

use Controller\User\Profile;

class View{
    public static function render($file, $variables = []) {
        ob_start();
        include $file;
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}
