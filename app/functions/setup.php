<?php

add_action( 'after_setup_theme', function() {
    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'title-tag' );

    add_theme_support( 'post-thumbnails' );

    register_nav_menus( array(
        'menu-header' => esc_html__( 'Menu Principal', 'pandoramarketing' ),
        'menu-footer' => esc_html__( 'Menu Pie de pagina', 'pandoramarketing' ),
        'menu-social' => esc_html__( 'Menu Redes sociales', 'pandoramarketing' ),
    ) );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    add_theme_support( 'wp-block-styles' );

    add_theme_support( 'align-wide' );

    add_theme_support( 'editor-styles' );
});

add_action( 'pre_get_posts', function ( $query ) {
    if ( is_post_type_archive() ) {
        set_query_var('posts_per_page', 4);
    }
});

add_action( 'widgets_init', function () {
    if ( WP_DEBUG ) {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar', 'demo' ),
            'id'            => 'sidebar-demo',
            'description'   => esc_html__( 'Add widgets here.', 'demo' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }
});

add_action('template_redirect', function () {
   if ( is_author() ) {
       wp_redirect(site_url(), 301);
   }
});
