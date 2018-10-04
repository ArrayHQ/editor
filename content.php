<?php
/**
 * @package Editor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<!-- Grab the featured image -->
	<?php if ( '' != get_the_post_thumbnail() ) { ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
	<?php } ?>

	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-date">
			<?php editor_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php
			if ( 'link' == get_post_format() ) :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( editor_get_link_url() ) . '" rel="bookmark">', '</a></h1>' );
			else :
				if ( is_single() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
				endif;
			endif;
		?>
	</header><!-- .entry-header -->

	<?php get_template_part( 'content', 'meta' ); ?>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading &rarr;', 'editor' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'editor' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
