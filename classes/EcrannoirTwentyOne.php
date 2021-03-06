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
     * The theme configuration
     */
    protected $theme_configuration = array();

    /**
     * Is the theme need to be clean
     */
    private $clean_wordpress = false;


    /**
     * Is the theme need to disable comment
     */
    private $disable_comment = false;

    /**
     * Get Theme Variables Config from json file
     */
    private $theme_shared_config = null;

    /**
     * Determines whether a class has already been instanciated.
     *
     * @access private
     */
	private static $instance = null;
	
	/**
     * Constructor. This allows the class to be only initialized once.
     */
    public function __construct( array $theme_configuration = array())
    {
        $defaults = array(
            'theme_content_width' => 780,
            'disable_comment' => false,
            'clean' => false,
            'menus' => array(
                'primary'   => __( 'Header Menu', 'ecrannoirtwentyone' ),
                'mobile'    => __( 'Mobile Menu', 'ecrannoirtwentyone' ),
            ),
            'widgets' => array(),
            'theme_json_config' => array()
        );

        $this->theme_configuration = wp_parse_args( $theme_configuration, $defaults );
        $this->clean_wordpress = $this->theme_configuration['clean'];
        $this->disable_comment = $this->theme_configuration['disable_comment'];
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

        add_action('template_redirect', 'ecrannoir_twenty_one_redirect' );

        // Retrieve Theme Settings From Database
        $this->theme_settings = get_option( 'ecrannoirtwentyone-settings-option' );
        $this->theme_shared_config = $this->theme_configuration['theme_json_config'];

        // Clean All Useless Stuff
        if ($this->clean_wordpress === true) {
            add_action('after_setup_theme', [ $this, 'cleanWordpressAction' ]);
        }

        $maintenance_mode = boolval( $this->theme_settings['maintenance_mode'] ?? false);
		if ($maintenance_mode === true) {
			add_action('get_header', 'ecrannoir_twenty_one_maintenance_mode');
		}

        // Setup Admin
        $this->setupAdmin();
        // Setup theme
        add_action( 'after_setup_theme', [ $this, 'themeSetupAction'] );
        // Setup Widget
        add_action( 'widgets_init', [ $this, 'widgetSetupAction'] );

        /**
         * Set the content width in pixels, based on the theme's design and stylesheet.
         *
         * Priority 0 to make it available to lower priority callbacks.
         */
        $theme_content_width = $this->theme_configuration['theme_content_width'];
        add_action( 'after_setup_theme', function() use ($theme_content_width) {
            $GLOBALS['content_width'] = $theme_content_width;
        }, 0 );

        // Enqueue scripts and styles.
        $this->enqueueScripts();
        

        $this->globalFilter();

        // Clean All Useless Stuff
        if ($this->disable_comment === true) {
            $this->disableComment();
        }

        $this->addMeta();

    }

    private function setupAdmin()
    {
        show_admin_bar(false);

        add_action('wp_dashboard_setup', [ $this, 'adminDashboard' ]);

        add_filter('admin_footer_text', function() {
            return "<span id=\"footer-thankyou\">Propulsé par <a href=\"https://fr.wordpress.org\">WordPress</a> - Avec  <a href=\"https://ecrannoir.be\">Ecran Noir</a>.</span>";
        });

        add_filter('login_errors', 'ecrannoir_twenty_one_custom_login_error_msg');

        if (is_admin()) {
			new EcranNoirTwentyOne_Options();
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

    /**
     * Remove Script, style feed rss etc
     */
    public function cleanWordpressAction()
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
        /**
         * Loads our translations before loading anything else
         */
        if( is_dir( get_stylesheet_directory() . '/languages' ) ) {
            $path = get_stylesheet_directory() . '/languages';
        } else {
            $path = get_template_directory() . '/languages'; 
        }
        load_theme_textdomain('ecrannoirtwentyone', $path);

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

        register_nav_menus( $this->theme_configuration['menus'] );

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
        
        $editor_stylesheet_path = './assets/editor.css';

        // Enqueue editor styles.
        add_editor_style( $editor_stylesheet_path );
        
        $configFontSizes = ecrannoir_twenty_one_get_config_value('theme-font-size', $this->theme_shared_config);
        $editorFontSizes = array();
        foreach ($configFontSizes as $fontSizeKeyName => $fontSizeContent) {
            if (is_array($fontSizeContent)) {
                $fontSizeName = isset($fontSizeContent['name']) ? $fontSizeContent['name'] : $fontSizeKeyName;
                $fontSizeShortName = isset($fontSizeContent['shortname']) ? $fontSizeContent['shortname'] : $fontSizeName;
                $fontSizeValue = $fontSizeContent['size'];
                $fontSizeSlug = isset($fontSizeContent['slug']) ? $fontSizeContent['slug'] : $fontSizeKeyName;
            } else {
                $fontSizeName = $fontSizeKeyName;
                $fontSizeShortName = $fontSizeName;
                $fontSizeValue = $fontSizeContent;
                $fontSizeSlug = $fontSizeName;
            }
            $editorFontSizes[] = array(
                'name' => $fontSizeName,
                'shortName' => $fontSizeShortName,
                'size' => $fontSizeValue,
                'slug' => $fontSizeSlug,
            );
        }
        add_theme_support( 'editor-font-sizes', $editorFontSizes );

        $editorColor = ecrannoir_twenty_one_get_config_value('theme-color', $this->theme_shared_config);
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
        $sidebars = $this->theme_configuration['widgets'];

        if (!empty($sidebars)) {
            foreach ($sidebars as $sidebar) {
                register_sidebar(
                    array_merge(
                        $config,
                        $sidebar,
                    )
                );
            }
        }

        register_widget( 'EcrannoirTwentyOne_Widget_LinkPage' );
    }

    /**
     * Enqueue scripts and styles.
     * 
     */
    private function enqueueScripts()
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
		add_action('admin_enqueue_scripts', function($hook) {
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
			EcranNoirTwentyOne_Scripts::toEnqueueScript('admin');
			// EcranNoirTwentyOne_Scripts::toEnqueueStyle('admin');
        });
        
        /**
		 * Enqueue editor assets.
		 */
		add_action('enqueue_block_editor_assets', function($hook) {
            EcranNoirTwentyOne_Scripts::toEnqueueScript( 'editor' );
            EcranNoirTwentyOne_Scripts::toEnqueueStyle( 'admin-editor' );
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
					background-image: url(<?php echo get_template_directory_uri() . '/assets/img/logo-theme-author.svg'; ?>);
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
    private function globalFilter()
    {
        add_filter( 'wp_revisions_to_keep', function( $num, $post ) {

			if (defined('ECRANNOIR_POST_REVISIONS')) {
				$num = ECRANNOIR_POST_REVISIONS;// Limit revisions otherwise
			}
			
			return $num;
		}, 10, 2 );
    }

    /**
     * Disable Comment
     */
    private function disableComment()
    {
        add_action( 'widgets_init', function() {

            unregister_widget( 'WP_Widget_Recent_Comments' );
            /**
             * The widget has added a style action when it was constructed - which will
             * still fire even if we now unregister the widget... so filter that out
             */
            add_filter( 'show_recent_comments_widget_style', '__return_false' );
        } );

        add_filter( 'wp_headers', function( $headers ) {
            unset( $headers['X-Pingback'] );
            return $headers;
        } );

        add_action( 'template_redirect', function() {
            if ( is_comment_feed() ) {
                wp_die( __( 'Comments are closed.', 'disable-comments' ), '', array( 'response' => 403 ) );
            }
        }, 9 );   // before redirect_canonical.

        function comment_disable_admin_bar()
        {
            if ( is_admin_bar_showing() ) {
                // Remove comments links from admin bar.
                remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
                if ( is_multisite() ) {
                    add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
                        // We have no way to know whether the plugin is active on other sites, so only remove this one.
                        $wp_admin_bar->remove_menu( 'blog-' . get_current_blog_id() . '-c' );
                    }, 500);
                }
            }
        }
        // Admin bar filtering has to happen here since WP 3.6.
        add_action( 'template_redirect', 'comment_disable_admin_bar' );
        add_action( 'admin_init', 'comment_disable_admin_bar' );

        // Disable Comments REST API Endpoint
        add_filter( 'rest_endpoints', function( $endpoints ) {
            unset( $endpoints['comments'] );
            return $endpoints;
        } );

        // Remove Comments Menu if it's disabled
        add_action('wp_before_admin_bar_render', function() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_node('comment');
        }); 

        function filter_admin_menu() {
            global $pagenow;
            if ( $pagenow == 'comment.php' || $pagenow == 'edit-comments.php' )
                wp_die( __( 'Comments are closed.' ), '', array( 'response' => 403 ) );

            remove_menu_page( 'edit-comments.php' );
        }

        function admin_css(){
            echo '<style>
                #dashboard_right_now .comment-count,
                #dashboard_right_now .comment-mod-count,
                #latest-comments,
                #welcome-panel .welcome-comments,
                .user-comment-shortcuts-wrap {
                    display: none !important;
                }
            </style>';
        }
    

        if( is_admin() ) {
            add_action( 'admin_menu', 'filter_admin_menu', 9999 );	// do this as late as possible
            add_action( 'admin_print_styles-index.php', 'admin_css' );
            add_action( 'admin_print_styles-profile.php', 'admin_css' );
            add_action( 'wp_dashboard_setup', function() {
                remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
            } );
            add_filter( 'pre_option_default_pingback_flag', '__return_zero' );
        }
    }

    /**
     * Add Meta to Theme
     */
    public function addMeta()
    {
        add_action( 'wp_head', [EcranNoirTwentyOne_Meta::class, 'print_meta'], 5);
		add_action( 'wp_head', [EcranNoirTwentyOne_Meta::class, 'printFavicon'], 101);

		if (isset($this->theme_settings['ga_measurement_id'])) {
			add_action( 'wp_head', function() {
				EcranNoirTwentyOne_Meta::addAnalytics($this->theme_settings['ga_measurement_id']);
			}, 102);
		}
    }
}
