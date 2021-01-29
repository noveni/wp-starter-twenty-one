<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly



class EcrannoirTwentyOne
{

    /**
     * the theme settings
     */
    private $theme_settings = null;

    /**
     * The Location Menu 
     */
    private $locations_menu = array();

    /**
     * The Side bar config
     */
    private $sidebars = array();

    /**
     * Get Theme Variables Config from json file
     */
    private $theme_config_vars = null;

    /**
     * Determines whether a class has already been instanciated.
     *
     * @access private
     */
	private static $instance = null;
	
	/**
     * Constructor. This allows the class to be only initialized once.
     */
    private function __construct()
    {
        $this->init();
    }

    public static function instance()
	{
		$class = get_called_class();
        if ( ! isset(self::$instance[$class]) ) {
            self::$instance[$class] = new $class();
        }

        return self::$instance[$class];
    }
    
    public function init() {

        // Retrieve Theme Settings From Database
        $this->theme_settings = get_option( 'ecrannoirtwentyone-settings-option' );
        $this->theme_config_vars = (array) json_decode(utf8_encode(file_get_contents(get_template_directory() . '/themeConfig.json')), true);
        
        /**
         * Loads our translations before loading anything else
         */
        if( is_dir( get_stylesheet_directory() . '/languages' ) ) {
            $path = get_stylesheet_directory() . '/languages';
        } else {
            $path = get_template_directory() . '/languages'; 
        }

        add_action('after_setup_theme', function () use ($path){
            load_theme_textdomain('ecrannoirtwentyone', $path);
        });
    }

    public function clean()
    {  
        add_action('after_setup_theme', [ $this, 'cleanAction' ]);
    }

    public function setupAdmin()
    {
        show_admin_bar(false);

        add_action('wp_dashboard_setup', [ $this, 'adminDashboard' ]);

        add_filter('admin_footer_text', function() {
            return "<span id=\"footer-thankyou\">Propulsé par <a href=\"https://fr.wordpress.org\">WordPress</a> - Avec  <a href=\"https://ecrannoir.be\">Ecran Noir</a>.</span>";
        });

        add_filter('login_errors', [ $this, 'customLoginErrorMsg' ]);

        if (is_admin()) {
			$theme_setting = new EcranNoirTwentyOne_Options();
		}

    }

    /**
     * Remove the dashboard box on the Admin Dashboard
     */
    public function adminDashboard()
    {
        // Remove Welcome panel
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
        // Remove the rest of the dashboard widgets
        // Remove Meta Box
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'health_check_status', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
        remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal');
    }

    // Handler Method for setup theme
    public function themeSetup()
    {
        add_action( 'after_setup_theme', [ $this, 'themeSetupAction'] );
    }

    // Handler Method for setup theme
    public function widgetSetup()
    {
        add_action( 'widgets_init', [ $this, 'widgetSetupAction'] );
    }

    public function setMenu($locations)
    {
        $this->locations_menu = $locations;
    }

    public function setSidebar($sidebars)
    {
        $this->sidebars = $sidebars;
    }

    public function getConfigValue($key = false)
    {
        $configData = $this->theme_config_vars;
        $return_value = $configData['variables'];

        if ($key) {
            if (key_exists($key, $configData['variables'])) {
                $return_value = $configData['variables'][$key];
            }
        }

        return $return_value;
    }

    /**
     * Remove Script, style feed rss etc
     */
    public function cleanAction()
    {
        remove_action('wp_head', 'feed_links_extra', 3);
        add_action('wp_head', 'ob_start', 1, 0);
        add_action('wp_head', function () {
            $pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
            echo preg_replace($pattern, '', ob_get_clean());
        }, 3, 0);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        // Emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }

    /**
     * Setup the theme default and register support
     * 
     * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
     * 
     */
    public function themeSetupAction()
    {
        /*
        * Let WordPress manage the document title.
        * This theme does not use a hard-coded <title> tag in the document head,
        * WordPress will provide it for us.
        */
        add_theme_support( 'title-tag' );

        /**
         * Add post-formats support.
         */
        add_theme_support(
            'post-formats',
            array(
                'link',
                'aside',
                'gallery',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat',
            )
        );

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1568, 9999 );

        register_nav_menus( $this->locations_menu );

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
                'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
        );
        
        // Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
        add_theme_support( 'align-wide' );
        
        // Add support for editor styles.
        add_theme_support( 'editor-styles' );
        
        $editor_stylesheet_path = './assets/css/editor.css';

        // Enqueue editor styles.
        add_editor_style( $editor_stylesheet_path );
        
        $configFontSizes = $this->getConfigValue('fontsize');
        $editorFontSizes = [];
        foreach ($configFontSizes as $fontSizeName => $fontSizeValue) {
            $editorFontSizes[] = array(
                'name' => $fontSizeName,
                'shortName' => $fontSizeName,
                'size' => $fontSizeValue,
                'slug' => $fontSizeName,
            );
        }
        add_theme_support( 'editor-font-sizes', $editorFontSizes );

        $editorColor = $this->getConfigValue('color');
        $editorColorPalette = [];
        foreach ($editorColor as $colorName => $colorHex) {
            $editorColorPalette[] = array(
                'name' => $colorName,
                'slug' => $colorName,
                'color' => $colorHex,
            );
        }
        add_theme_support( 'editor-color-palette', $editorColorPalette );

        add_theme_support( 'disable-custom-colors' );

        // Add support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );
        
        // Add support for custom line height controls.
        add_theme_support( 'custom-line-height' );
        
        // Add support for experimental link color control.
        add_theme_support( 'experimental-link-color' );
        
        // Add support for experimental cover block spacing.
        add_theme_support( 'custom-spacing' );
        
        remove_theme_support( 'core-block-patterns' );


    }

    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     *
     * @return void
     */
    public function widgetSetupAction()
    {
        $config = [
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
        ];

        if (!empty($this->sidebars)) {
            foreach ($this->sidebars as $sidebar) {
                register_sidebar(
                    array_merge(
                        $config,
                        $sidebar,
                    )
                );
            }
        }
    }

    /**
     * Set the content width in pixels, based on the theme's design and stylesheet.
     *
     * Priority 0 to make it available to lower priority callbacks.
     */
    public function themeContentWidth($width)
    {
        add_action( 'after_setup_theme', function() use ($width) {
            $GLOBALS['content_width'] = $width;
        }, 0 );
    }

    /**
     * Enqueue scripts and styles.
     * 
     */
    public function enqueueScripts()
    {
        /**
		 * Enqueue front-end assets.
		 */
		add_action('wp_enqueue_scripts', function ($hook) {
			EcranNoirTwentyOne_Scripts::toEnqueueScript('theme', 'ecrannoirtwentyone-theme-scripts');
			wp_script_add_data('ecrannoirtwentyone-theme-scripts', 'async', true );
			EcranNoirTwentyOne_Scripts::toEnqueueStyle('style');
		});

		/**
		 * Enqueue admin assets.
		 */
		// add_action('admin_enqueue_scripts', function($hook) {
		// 	EcranNoirTwentyOne_Scripts::toEnqueueScript('admin');
		// 	EcranNoirTwentyOne_Scripts::toEnqueueStyle('admin');
        // });
        
        /**
		 * Enqueue editor assets.
		 */
		add_action('enqueue_block_editor_assets', function($hook) {
            EcranNoirTwentyOne_Scripts::toEnqueueScript( 'editor' );
        });

        /**
		 * Enqueue Login Assets
		 */
		add_action( 'login_enqueue_scripts', function() {
			// EcranNoirTwentyOne_Scripts::toEnqueueScript('login');
			// EcranNoirTwentyOne_Scripts::toEnqueueStyle('login');

			$style = function() {
				?>
				<style type="text/css">
				#login h1 a, .login h1 a {
					background-image: url(<?php echo get_template_directory_uri() . '/assets/img/logo.svg'; ?>);
					background-size: 80%;
					height: 100px;
					width: 100%;
				}
				</style>
				<?php
			};
			$style();
				
		});

    }

    /**
     * Add global Filter
     */
    public function globalFilter()
    {
        add_filter( 'wp_revisions_to_keep', function( $num, $post ) {

			if (defined('ECRANNOIR_POST_REVISIONS')) {
				$num = ECRANNOIR_POST_REVISIONS;// Limit revisions otherwise
			}
			
			return $num;
		}, 10, 2 );
    }

    /*
    * Replace WP default login error messages
    */
    public function customLoginErrorMsg( $error )
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

}
