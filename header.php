<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Editor
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site container">

	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'editor' ); ?></a>

	<!-- Get sidebar color option (Appearance -> Customize -> Theme Options) -->
	<?php
		$editor_sidebar_color = get_option( 'editor_customizer_sidebar_color' );
		$editor_featured_cat = get_theme_mod( 'editor_featured_cat' );
	?>
	<header id="masthead" class="site-header <?php echo $editor_sidebar_color; ?>" role="banner">
		<!-- Tab navigation -->
		<ul class="toggle-bar" role="tablist">
			<!-- Main navigation -->
			<li id="panel-1" class="current" role="presentation">
				<a href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true" class="current nav-toggle" data-tab="tab-1"><i class="fa fa-bars"></i><span class="screen-reader-text"><?php _e( 'View menu', 'editor' ); ?></span></a>
			</li>

			<!-- Featured Posts navigation -->
			<?php if( $editor_featured_cat && $editor_featured_cat !== '0' ) { ?>
				<li id="panel-2" role="presentation">
					<a href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false" data-tab="tab-2"><i class="fa fa-thumb-tack"></i><span class="screen-reader-text"><?php _e( 'View featured posts', 'editor' ); ?></span></a>
				</li>
			<?php } ?>

			<!-- Sidebar widgets navigation -->
			<li id="panel-3" role="presentation">
				<a href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false" class="folder-toggle" data-tab="tab-3"><i class="fa fa-folder"></i><i class="fa fa-folder-open"></i><span class="screen-reader-text"><?php _e( 'View sidebar', 'editor' ); ?></span></a>
			</li>
		</ul>

		<div id="tabs" class="toggle-tabs">
			<div class="site-header-inside">
				<!-- Logo, description and main navigation -->
				<div id="tab-1" class="tab-content current fadeIn">
					<div class="site-branding">
						<!-- Get the site branding -->
						<?php
							$logo = get_theme_mod( 'editor_customizer_logo' );
							if ( ! empty( $logo ) ) {
						?>
							<h1 class="site-logo">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="site-logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
							</h1>
						<?php } else { ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php } ?>
					</div>

					<nav id="site-navigation" class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav><!-- #site-navigation -->

					<?php if ( has_nav_menu ( 'social' ) ) : ?>
						<?php wp_nav_menu( array( 'theme_location' => 'social', 'depth' => 1, 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'container_class' => 'social-links', ) ); ?>
					<?php endif; ?>
				</div><!-- #tab-1 -->

				<!-- Featured Posts template (template-featured-posts.php) -->
				<?php get_template_part( 'template-featured-posts' ); ?>

				<!-- Sidebar widgets -->
				<div id="tab-3" class="tab-content animated fadeIn" role="tabpanel" aria-labelledby="panel-3" aria-hidden="true">
					<?php get_sidebar(); ?>
				</div><!-- #tab-3 -->
			</div><!-- .site-header-inside -->
		</div><!-- #tabs -->
	</header><!-- #masthead -->

	<div id="content" class="site-content fadeInFast">
