<?php
/**
 * Custom Scripts Handler
 *
 */

class EcranNoirTwentyOne_Scripts 
{
    public static function toEnqueueScript($scriptName, $customHandleScriptName = '') {

        $script_asset_path = get_template_directory() . '/assets/js/' . $scriptName . '.asset.php';
        $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
        
        $handleFileName = $customHandleScriptName !== '' ? $customHandleScriptName : 'ecrannoirtwentyone-' . $styleName . '-scripts';
        // Enqueue Scripts
        wp_enqueue_script($handleFileName, get_template_directory_uri() . '/assets/js/' . $scriptName . '.js', $script_asset['dependencies'], $script_asset['version'], true);
    }

    public static function toEnqueueStyle($styleName, $customHandleStyleName = '') {

        $script_asset_path = get_template_directory() . '/assets/js/theme.asset.php';
        $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
        
        $handleFileName = $customHandleStyleName !== '' ? $customHandleStyleName : 'ecrannoirtwentyone-' . $styleName . '-styles';
        // Enqueue Style
        wp_enqueue_style($handleFileName, get_template_directory_uri() . '/assets/css/' . $styleName . '.css', array(), $script_asset['version'], 'all');
    }
    
    public static function toRegisterScript($scriptName, $customHandleScriptName) {

        $script_asset_path = get_template_directory() . '/assets/js/' . $scriptName . '.asset.php';
        $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
        
        wp_register_script($customHandleScriptName, get_template_directory_uri() . '/assets/js/' . $scriptName . '.js', $script_asset['dependencies'], $script_asset['version']);
    }
}
