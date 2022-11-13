<?php
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action('wp_enqueue_scripts' , 'axiom_scripts');
function axiom_scripts() {
	wp_enqueue_style('my-style', get_stylesheet_uri());
	wp_enqueue_script('jquery');	
	wp_enqueue_script( 'may_scripts' , get_template_directory_uri() . '/js/app.js', array(), null, true);
}


	add_theme_support( 'menus' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );


