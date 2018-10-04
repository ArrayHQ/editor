<?php
/**
 * Theme updater admin page and functions.
 *
 * @package Editor
 */

/**
 * Redirect to Getting Started page on theme activation
 */
function editor_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "themes.php?page=editor-getting-started" ) );

	}
}
add_action( 'admin_init', 'editor_redirect_on_activation' );

/**
 * Load Getting Started styles in the admin
 *
 * since 1.0.0
 */
function editor_start_load_admin_scripts() {

	// Load styles only on our page
	global $pagenow;
	if( 'themes.php' != $pagenow )
		return;

	/**
	 * Getting Started scripts and styles
	 *
	 * @since 1.0
	 */

	// Getting Started javascript
	wp_enqueue_script( 'editor-getting-started', get_template_directory_uri() . '/inc/admin/getting-started/getting-started.js', array( 'jquery' ), '1.0.0', true );

	// Getting Started styles
	wp_register_style( 'editor-getting-started', get_template_directory_uri() . '/inc/admin/getting-started/getting-started.css', false, '1.0.0' );
	wp_enqueue_style( 'editor-getting-started' );

	// Thickbox
	add_thickbox();
}
add_action( 'admin_enqueue_scripts', 'editor_start_load_admin_scripts' );

/**
 * Adds a menu item for the Getting Started page
 *
 * since 1.0.0
 */
function license_menu() {
	add_theme_page(
		__( 'Getting Started', 'editor' ),
		__( 'Getting Started', 'editor' ),
		'manage_options',
		'editor-getting-started',
		'editor_getting_started'
	);
}
add_action( 'admin_menu', 'license_menu' );

/**
 * Outputs the markup used on the theme license page.
 *
 * since 1.0.0
 */
function editor_getting_started() {

	/**
	 * Retrieve help file and theme update changelog
	 *
	 * since 1.0.0
	 */

	// Theme info
	$theme = wp_get_theme( 'editor' );
?>

		<div class="wrap getting-started">
			<h2 class="notices"></h2>
			<div class="intro-wrap">
				<div class="intro">
					<h3><?php esc_html_e( 'Getting started with Editor', 'editor' ); ?></h3>
					<h4><?php esc_html_e( 'You will find everything you need to get started with Editor below', 'editor' ); ?></h4>
				</div>
			</div>

			<div class="panels">
				<ul class="inline-list">
					<li class="current"><a id="help-tab" href="#"><?php esc_html_e( 'Help File', 'editor' ); ?></a></li>
					<li><a id="themes-tab" href="#"><?php esc_html_e( 'More Themes & Discounts', 'editor' ); ?></a></li>
				</ul>

				<div id="panel" class="panel">

					<!-- Help file panel -->
					<div id="help-panel" class="panel-left visible">

						<!-- Grab feed of help file -->
						<?php
							include_once( ABSPATH . WPINC . '/feed.php' );

							$rss = fetch_feed( 'https://arraythemes.com/articles/editor/feed/?withoutcomments=1' );

							if ( ! is_wp_error( $rss ) ) :
							    $maxitems = $rss->get_item_quantity( 1 );
							    $rss_items = $rss->get_items( 0, $maxitems );
							endif;

							if ( ! is_wp_error( $rss ) ) :
								$rss_items_check = array_filter( $rss_items );
							endif;
						?>

						<!-- Output the feed -->
						<?php if ( is_wp_error( $rss ) || empty( $rss_items_check ) ) : ?>
							<p><?php esc_html_e( 'This help file feed seems to be temporarily down. You can always view the help file on Array in the meantime.', 'editor' ); ?> <a href="https://arraythemes.com/articles/editor" title="View help file"><?php esc_html_e( 'Editor Help File &rarr;', 'editor' ); ?></a></p>
						<?php else : ?>
						    <?php foreach ( $rss_items as $item ) : ?>
								<?php echo $item->get_content(); ?>
						    <?php endforeach; ?>
						<?php endif; ?>
					</div>

					<!-- More themes -->
					<div id="themes-panel" class="panel-left">
						<div class="theme-intro">
							<div class="theme-intro-left">
								<p><?php _e( 'Join the Theme Club to download all the themes you see below and new releases for one year for <strong>only <strike>$89</strike> <span>$71.20</span></strong> with the code <strong>THEMEPACK20</strong>!', 'editor' ); ?></p>
							</div>
							<div class="theme-intro-right">
								<a class="button-primary club-button" href="<?php echo esc_url('https://arraythemes.com/wordpress-themes/?theme_pack'); ?>"><?php esc_html_e( 'Shop Themes Now', 'editor' ); ?> &rarr;</a>
							</div>
						</div>

						<div class="theme-list">
						<?php
						// @todo cache this after all the dust has settled
						$themes_list = wp_remote_get( 'https://arraythemes.com/feed/themes' );

						if ( ! is_wp_error( $themes_list ) && 200 === wp_remote_retrieve_response_code( $themes_list ) ) {

							echo wp_remote_retrieve_body( $themes_list );
						} else {
							$themes_link = 'https://arraythemes.com/wordpress-themes';
							printf( __( 'This theme feed seems to be temporarily down. Please check back later, or visit our <a href="%s">Themes page on Array</a>.', 'editor' ), esc_url( $themes_link ) );
						} ?>

						</div><!-- .theme-list -->
						<div class="theme-intro">
							<div class="theme-intro-left">
								<p><?php _e( 'Join the Theme Club to download all the themes you see below and new releases for one year for <strong>only <strike>$89</strike> <span>$71.20</span></strong> with the code <strong>THEMEPACK20</strong>!', 'editor' ); ?></p>
							</div>
							<div class="theme-intro-right">
								<a class="button-primary club-button" href="<?php echo esc_url('https://arraythemes.com/wordpress-themes/?theme_pack'); ?>"><?php esc_html_e( 'Shop Themes Now', 'editor' ); ?> &rarr;</a>
							</div>
						</div>
					</div><!-- .panel-left updates -->

					<div class="panel-right">
						<div class="panel-aside panel-club">
							<a href="<?php echo esc_url('https://arraythemes.com/wordpress-themes/?theme_pack'); ?>"><img src="<?php echo get_template_directory_uri() . '/inc/admin/getting-started/club.jpg'; ?>" alt="<?php esc_html_e( 'Join the Theme Club!', 'editor' ); ?>" /></a>

							<div class="panel-club-inside">
								<h4><?php esc_html_e( 'Instantly download 20+ pixel-perfect WordPress themes!', 'editor' ); ?></h4>

								<p><?php esc_html_e( 'Join the Theme Club and download our entire collection of responsive themes, new theme releases and get speedy, expert support &mdash; a massive value!', 'editor' ); ?></p>

								<div class="club-discount">
									<p><strong><?php esc_html_e( 'Exclusive 20% Discount!', 'editor' ); ?></strong></p>

									<p><?php
										$themes_link = '<code><strong>THEMEPACK20</strong></code>';
										printf( __( 'Use the code %s to get 20&#37; off your next WordPress theme or Theme Club membership!', 'editor' ), $themes_link );
									?></p>
								</div>

								<a class="button-primary club-button" href="<?php echo esc_url('https://arraythemes.com/wordpress-themes/?theme_pack'); ?>"><?php esc_html_e( 'Shop Themes Now', 'editor' ); ?> &rarr;</a>
							</div>
						</div>
					</div><!-- .panel-right -->
				</div><!-- .panel -->
			</div><!-- .panels -->
		</div><!-- .getting-started -->

	<?php
}
