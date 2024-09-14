<?php
class Template {

    public static function render($obj = [], $file) {
        $templatePath = "views/templates/$file.phtml";
        
        if (!file_exists($templatePath)) {
            throw new Exception("O template '$file' não foi encontrado.");
        }

        // Verifica se $obj é um array e extrai as variáveis
        if (is_array($obj) && !empty($obj)) {
            extract($obj);
        }

        ob_start();
        include($templatePath);
        return ob_get_clean();
    }
}
