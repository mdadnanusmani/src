<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTthemesModel {

    function storeTheme($data) {
        $filepath = jssupportticket::$_path . 'includes/css/style.php';
        $filestring = file_get_contents($filepath);
        $this->replaceString($filestring, 1, $data);
        $this->replaceString($filestring, 2, $data);
        $this->replaceString($filestring, 3, $data);
        $this->replaceString($filestring, 4, $data);
        $this->replaceString($filestring, 5, $data);
        $this->replaceString($filestring, 6, $data);
        $this->replaceString($filestring, 7, $data);
        if (file_put_contents($filepath, $filestring)) {
            JSSTmessage::setMessage(__('New theme has been applied', 'js-support-ticket'), 'updated');
        } else {
            JSSTmessage::setMessage(__('Error applying new theme', 'js-support-ticket'), 'error');
        }
        return;
    }

    function replaceString(&$filestring, $colorNo, $data) {
        if (strstr($filestring, '$color' . $colorNo)) {
            $path1 = strpos($filestring, '$color' . $colorNo);
            $path2 = strpos($filestring, ';', $path1);
            $filestring = substr_replace($filestring, '$color' . $colorNo . ' = "' . $data['color' . $colorNo] . '";', $path1, $path2 - $path1 + 1);
        }
    }

    function getColorCode($filestring, $colorNo) {
        if (strstr($filestring, '$color' . $colorNo)) {
            $path1 = strpos($filestring, '$color' . $colorNo);
            $path1 = strpos($filestring, '#', $path1);
            $path2 = strpos($filestring, ';', $path1);
            $colorcode = substr($filestring, $path1, $path2 - $path1 - 1);
            return $colorcode;
        }
    }

    function getCurrentTheme() {
        $filepath = jssupportticket::$_path . 'includes/css/style.php';
        $filestring = file_get_contents($filepath);
        $theme['color1'] = $this->getColorCode($filestring, 1);
        $theme['color2'] = $this->getColorCode($filestring, 2);
        $theme['color3'] = $this->getColorCode($filestring, 3);
        $theme['color4'] = $this->getColorCode($filestring, 4);
        $theme['color5'] = $this->getColorCode($filestring, 5);
        $theme['color6'] = $this->getColorCode($filestring, 6);
        $theme['color7'] = $this->getColorCode($filestring, 7);
        $theme = apply_filters('cm_theme_colors', $theme, 'js-support-ticket');
        jssupportticket::$_data[0] = $theme;
        return;
    }
}
?>