<?php
/**
 * template for post type film
 */
function slx_get_all_meta() {
	global $post;

	$meta_film = '';

	if ( $post ) {
		$meta_price = get_post_meta( $post->ID, 'slx_meta_price', true );
		$meta_release = get_post_meta( $post->ID, 'slx_meta_release', true );

		$country = '';
		$tax_countrys = get_the_terms( $post->ID, 'country' );
		if ( ! empty( $tax_countrys ) && is_array( $tax_countrys )  ) {
			foreach ( $tax_countrys as $tax_country ) {
				$country .= '<a href="' . get_term_link( (int) $tax_country->term_id, $tax_country->taxonomy ) . '">' . $tax_country->name . '</a> ';
			}
		}
		$genre = '';
		$tax_genres = get_the_terms( $post->ID, 'genre' );
		if ( ! empty( $tax_genres ) && is_array( $tax_genres ) ) {
			foreach ( $tax_genres as $tax_genre ) {
				$genre .= '<a href="' . get_term_link( (int) $tax_genre->term_id, $tax_genre->taxonomy ) . '">' . $tax_genre->name . '</a> ';
			}
		}

		$actor = '';
		$tax_actors = get_the_terms( $post->ID, 'actor' );
		if ( ! empty( $tax_actors ) && is_array( $tax_actors )  ) {
			foreach ( $tax_actors as $tax_actor ) {
				$actor .= '<a href="' . get_term_link( (int) $tax_actor->term_id, $tax_actor->taxonomy ) . '">' . $tax_actor->name . '</a> ';
			}
		}

		$meta_film = '
		<ul class="list-unstyled">
			<li><span class="glyphicon glyphicon-film"></span> Genre - ' . $genre . '</li>
			<li><span class="glyphicon glyphicon-globe"></span> Coutry - ' . $country . '</li>
			<li><span class="glyphicon glyphicon-user"></span> Actors - ' . $actor . '</li>
			<li><span class="glyphicon glyphicon-usd"></span> Price - ' . $meta_price . '</li>
			<li><span class="glyphicon glyphicon-calendar"></span> Data release - ' . $meta_release . '</li>
		</ul>';
	}
	return $meta_film;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header page-header">

		<?php
		if ( of_get_option( 'single_post_image', 1 ) == 1 ) :
			the_post_thumbnail( 'unite-featured', array( 'class' => 'thumbnail' ));
		endif;
		?>

		<h1 class="entry-title "><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php unite_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php echo slx_get_all_meta(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'unite' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'unite' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', 'unite' ) );

		if ( ! unite_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = '<i class="fa fa-folder-open-o"></i> %2$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
			} else {
				$meta_text = '<i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
			}

		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = '<i class="fa fa-folder-open-o"></i> %1$s <i class="fa fa-tags"></i> %2$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
			} else {
				$meta_text = '<i class="fa fa-folder-open-o"></i> %1$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
			}

		} // end check for categories on this blog

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink()
		);
		?>

		<?php edit_post_link( __( 'Edit', 'unite' ), '<i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span>' ); ?>
		<?php unite_setPostViews(get_the_ID()); ?>
		<hr class="section-divider">
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->