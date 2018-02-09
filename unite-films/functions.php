<?php

// register post type film and taxonomy genre, country, year
add_action( 'init', 'slx_reg_film_post_type' );
function slx_reg_film_post_type() {
	// register taxonomies genre
	$labels_genre = array(
		'name' => _x( 'Genres', 'taxonomy general name' ),
		'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Genres' ),
		'all_items' => __( 'All Genres' ),
		'parent_item' => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item' => __( 'Edit Genre' ),
		'update_item' => __( 'Update Genre' ),
		'add_new_item' => __( 'Add New Genre' ),
		'new_item_name' => __( 'New Genre Name' ),
		'menu_name' => __( 'Genre' ),
	);

	register_taxonomy( 'genre', array( 'film' ), array(
		'hierarchical' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'genre' ),
		'labels' => $labels_genre,
	) );

	//register taxonomies country
	$labels_country = array(
		'name' => _x( 'Countries', 'taxonomy general name' ),
		'singular_name' => _x( 'Country', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Countries' ),
		'all_items' => __( 'All Countries' ),
		'edit_item' => __( 'Edit Country' ),
		'update_item' => __( 'Update Country' ),
		'add_new_item' => __( 'Add New Country' ),
		'new_item_name' => __( 'New Country Name' ),
		'menu_name' => __( 'Country' ),
	);

	register_taxonomy( 'country', array( 'film' ), array(
		'hierarchical' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'country' ),
		'labels' => $labels_country,
	) );
	//register taxonomies year
	$labels_year = array(
		'name' => _x( 'Years', 'taxonomy general name' ),
		'singular_name' => _x( 'Year', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Years' ),
		'all_items' => __( 'All Years' ),
		'edit_item' => __( 'Edit Year' ),
		'update_item' => __( 'Update Year' ),
		'add_new_item' => __( 'Add New Year' ),
		'new_item_name' => __( 'New Year Name' ),
		'menu_name' => __( 'Year' ),
	);

	register_taxonomy( 'year', array( 'film' ), array(
		'hierarchical' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'year' ),
		'labels' => $labels_year,
	) );
	//register taxonomies actor
	$labels_actor = array(
		'name' => _x( 'Actors', 'taxonomy general name' ),
		'singular_name' => _x( 'Actor', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Actors' ),
		'all_items' => __( 'All Actors' ),
		'edit_item' => __( 'Edit Actor' ),
		'update_item' => __( 'Update Actor' ),
		'add_new_item' => __( 'Add New Actor' ),
		'new_item_name' => __( 'New Actor Name' ),
		'menu_name' => __( 'Actor' ),
	);

	register_taxonomy( 'actor', array( 'film' ), array(
		'hierarchical' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'actor' ),
		'labels' => $labels_actor,
	) );
	// register post type film
	$labels_films = array(
		'name'               => __( 'Films' ),
		'singular_name'      => __( 'Film' ),
		'add_new'            => __( 'Add New' ),
		'add_new_item'       => __( 'Add New Film' ),
		'edit_item'          => __( 'Edit Film' ),
		'new_item'           => __( 'New Film' ),
		'view_item'          => __( 'View Film' ),
		'search_items'       => __( 'Search Film' ),
		'not_found'          =>  __( 'Film not found' ),
		'not_found_in_trash' => __( 'Film not found in trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Films' ),
	);

	register_post_type( 'film', array(
		'labels' => $labels_films,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments'),
	) );
}

// add custom meta price
function slx_render_field_price( $post ) {
	wp_nonce_field( 'slx_save_post_film', '_nonce_price_film' );
	$meta_price = get_post_meta( $post->ID, 'slx_meta_price' );
	$price = ! empty( $meta_price ) ? $meta_price[0] : '';

	echo '<label><input type="text" name="slx_meta_price" id="slx_meta_price" value="' . $price . '" ></label>';
}

function slx_meta_price() {
	add_meta_box( 'slx_meta_price', __( 'Please enter ticket price' ), 'slx_render_field_price', 'film', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'slx_meta_price' );

// add custom meta
function slx_render_field_release( $post ) {
	wp_nonce_field( 'slx_save_post_film', '_nonce_release_film' );
	$meta_release = get_post_meta( $post->ID, 'slx_meta_release' );
	$release = !empty( $meta_release ) ? $meta_release[0] : '';

	echo '<label><input type="text" name="slx_meta_release" id="slx_meta_release" value="' . $release . '" ></label>';
}

function slx_meta_release() {
	add_meta_box( 'slx_meta_release', __( 'Please enter date release' ), 'slx_render_field_release', 'film', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'slx_meta_release' );

// save post film
function slx_save_post_film( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	$nonce_price = ( ! empty( $_POST['_nonce_price_film'] ) ) ? $_POST['_nonce_price_film'] : 0;
	$nonce_release = ( ! empty( $_POST['_nonce_release_film'] ) ) ? $_POST['_nonce_release_film'] : 0;

	if ( ! wp_verify_nonce( $nonce_price, 'slx_save_post_film' ) && ! wp_verify_nonce( $nonce_release, 'slx_save_post_film' ) ) {
		return $post_id;
	}

	if ( isset( $_POST['slx_meta_price'] ) && ! empty( $_POST['slx_meta_price'] ) ) {
		$price = sanitize_text_field( $_POST['slx_meta_price'] );
		update_post_meta( $post_id, 'slx_meta_price', $price );
	}

	if ( isset( $_POST['slx_meta_release'] ) && ! empty( $_POST['slx_meta_release'] ) ) {
		$release = sanitize_text_field( $_POST['slx_meta_release'] );
		update_post_meta( $post_id, 'slx_meta_release', $release );
	}
}

add_action( 'save_post_film', 'slx_save_post_film' );

add_filter( 'the_content', 'slx_film_content' );
function slx_film_content( $content ) {
	global $post;

	$post_type = get_post_type( $post->ID );

	if ( 'film' == $post_type && ! is_single() ) {
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

		$meta_film = '
		<ul class="list-unstyled">
			<li><span class="glyphicon glyphicon-film"></span> Genre - ' . $genre . '</li>
			<li><span class="glyphicon glyphicon-globe"></span> Coutry - ' . $country . '</li>
			<li><span class="glyphicon glyphicon-usd"></span> Price - ' . $meta_price . '</li>
			<li><span class="glyphicon glyphicon-calendar"></span> Data release - ' . $meta_release . '</li>
		</ul>';
	}
	if ( ! empty( $meta_film ) ) {
		return $content . $meta_film;
	} else {
		return $content;
	}
}

function slx_films_short_code( $atts ) {
	global $post;

	$args = array(
		'post_type' => 'film',
		'numberposts' => 5
	);

	$posts = get_posts( $args );
	foreach ( $posts as $post ) {
		setup_postdata( $post ); ?>
		<div class="row">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header page-header">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</header><!-- .entry-header -->
				<div class="col-md-6">
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'unite-featured', array( 'class' => 'thumbnail' )); ?></a>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12"><?php the_excerpt(); ?></div>
						<div class="col-md-12"><?php echo slx_get_all_meta(); ?></div>
					</div>
				</div>

				<!-- .entry-content -->
			</article><!-- #post-## -->



		</div>
	<?php }
	wp_reset_postdata();
}
add_shortcode( 'slx_films', 'slx_films_short_code' );

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