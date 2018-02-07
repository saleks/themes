<?php

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