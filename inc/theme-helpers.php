<?php
/**
 * Functions which enhance the theme settings
 *
 */

/**
 * Debug nice output
 */
function ec_dump($var, $die = false)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if ($die === true)
        wp_die();
}

/**
 * Get Config Data
 * There is a base config json file at theme base dir, 
 * It's shared with js, css and here in the theme
 */
function ecrannoir_twenty_one_get_config_data() {
    $filename = 'themeConfig.json';
    if (!file_exists(get_template_directory() . '/' . $filename)) {
        return array();
    }
    return (array) json_decode(utf8_encode(file_get_contents(get_template_directory() . '/' . $filename)), true);
}


/**
 * Get a particular data from file config
 */
function ecrannoir_twenty_one_get_config_value($key = false, $data = false) {
    $configData = is_array($data) ? $data : ecrannoir_twenty_one_get_config_data();

    if (empty($configData)) {
        return false;
    }

    $return_value = $configData['variables'];

    if ($key) {
        if (key_exists($key, $configData['variables'])) {
            $return_value = $configData['variables'][$key];
        }
    }

    return $return_value;
}


/*
 * Replace WP default login error messages
 */
function ecrannoir_twenty_one_custom_login_error_msg( $error )
{

    // we will override only the above errors and not anything else
    if ( is_int( strpos( $error, 'le mot de passe que vous avez saisi pour') ) || 
        is_int( strpos( $error, 'Adresse e-mail inconnue' ) ) || 
        is_int( strpos( $error, 'Identifiant inconnu' ) ) 
    ) {
        $error = '<strong>Erreur:</strong> Oops. Informations de connexion incorrectes.<br /><a href="' . wp_lostpassword_url() . '">Mot de passe perdu ?</a>';
    }

    return $error;
}
