<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * 
 */
$has_credits = true;
$separator = '<span class="separator"> | </span>';
?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<div class="site-name">
				<a class="footer-logo" href="<?php echo esc_url( get_home_url( null, '/' ) ) ?>">
					<?php ecrannoir_twenty_one_the_logo(); ?>
				</a>
			</div>
			<?php if (is_active_sidebar('site-description')): ?>
			<div class="site-description">
				<?php dynamic_sidebar( 'site-description' ); ?>
			</div>
			<?php endif; ?>
		</div>
	
	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<h3><?php esc_html_e( 'Menu', 'ecrannoirtwentyone' ); ?></h3>
		<nav aria-label="<?php esc_attr_e( 'Secondary menu', 'ecrannoirtwentyone' ); ?>" class="footer-navigation">
			
			<ul class="footer-navigation-wrapper">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'items_wrap'     => '%3$s',
						'container'      => false,
						'depth'          => 1,
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'fallback_cb'    => false,
					)
				);
				?>
			</ul><!-- .footer-navigation-wrapper -->
		</nav><!-- .footer-navigation -->
	<?php endif; ?>

	<?php if ( is_active_sidebar('sidebar-1') ) : ?>
		<div>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar('sidebar-2') ) : ?>
		<div>
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
	<?php endif; ?>

	<?php if (has_nav_menu( 'social' )) : ?>
		<h3><?php esc_html_e( 'Suivez-nous', 'ecrannoirtwentyone' ); ?></h3>
		<nav aria-label="<?php esc_attr_e( 'Social links', 'ecrannoirtwentyone' ); ?>" class="footer-social-wrapper">
			<ul class="footer-social-menu">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'social',
						'container'       => '',
						'container_class' => '',
						'items_wrap'      => '%3$s',
						'menu_id'         => '',
						'menu_class'      => '',
						'depth'           => 1,
						'link_before'     => '<span class="screen-reader-text">',
						'link_after'      => '</span>',
						'fallback_cb'     => '',
					)
				);
				?>
			</ul>
		</nav>
	<?php endif; ?>

	<?php if ($has_credits) : ?>
		<div class="footer-credits">
			<p>
				<span>
				<?php
				printf(
					esc_html__( '&copy; %1$s - %2$s %3$s', 'ecrannoirtwentyone' ),
					date_i18n(_x( 'Y', 'copyright date format', 'ecrannoirtwentyone' )),
					_x('Copyright', 'credits', 'ecrannoirtwentyone'),
					'<a href="' . esc_url( home_url( '/' )  ) . '">' . get_bloginfo( 'name' ) . '</a>',
				);
				?>
				</span>
				<?php echo $separator; ?>
				<span>
					<?php _e('Tous droits réservés', 'ecrannoirtwentyone' ); ?>
				</span>
				<?php echo $separator; ?>
				<span>
				<?php
				printf(
					esc_html__( 'Site créé par %1$s & %2$s.', 'ecrannoirtwentyone' ),
					'<a href="' . esc_url( __( 'https://tampala.be/', 'ecrannoirtwentyone' ) ) . '">Tampala Studio</a>',
					'<a href="' . esc_url( __( 'https://ecrannoir.be/', 'ecrannoirtwentyone' ) ) . '">Ecran Noir</a>'
				);
				?>
				</span>
			</p>
		</div>
	<?php endif; ?>

	<?php if ( has_nav_menu( 'legals' ) ) : ?>
		<p>
		<?php
		$menu_args = array(
				'theme_location' => 'legals',
				'items_wrap'     => '%3$s',
				'container'      => false,
				'echo' 			 => false,
				'depth'          => 0,
				'before'    => '<span>',
				'after'     => "</span> $separator ",
				'fallback_cb'    => false,
		);
		echo strip_tags(wp_nav_menu( $menu_args ), '<span><a>' );
		?>
		</p>
	<?php endif; ?>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
