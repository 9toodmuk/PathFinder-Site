<?php
namespace App\Controller\View;

use App\Controller\User\Profile;

class View{
    public static function render($file, $variables = []) {
        ob_start();
        include $file;
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}
