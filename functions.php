<?php
/**
 * GlobalSpex Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GlobalSpex
 * @since 1.2
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_GLOBALSPEX_VERSION', '1.2' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'globalspex-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_GLOBALSPEX_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function astra_post_title() { 
	  $post_types = array('page','post'); 
	 
	  // bail early if the current post type if not the one we want to customize. 
	  if ( ! in_array( get_post_type(), $post_types ) ) { return; } 
	 
	  // Disable title. 
	  add_filter( 'astra_the_title_enabled', '__return_false' ); 
}
add_action( 'wp', 'astra_post_title' );


function gx_login_logo() {?>
    <style type="text/css">
      #login h1 a, .login h1 a {
				background-image: url(<?php echo get_home_url();?>/wp-content/uploads/2023/12/Logo-Left-Transparent-Background-1024x301-2.png);
				height: 65px;
				width: 320px;
				background-size: 320px 94px;
				background-repeat: no-repeat;
				padding-bottom: 30px;
      }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'gx_login_logo' );

//Add favicons to the <head> on the back and front-end of the site
add_action( 'wp_head', 'add_favicons' );
add_action( 'login_head', 'add_favicons' );
add_action( 'admin_head', 'add_favicons' );
function add_favicons() {
		// Replace the code below with the <head> code provided on realfavicongenerator.net 
  ?>
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#ffffff">
		<link rel="shortcut icon" href="/favicon.ico">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-config" content="/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">
	<?php
}

function add_type_kit() {
	?>
	<link rel="stylesheet" href="https://use.typekit.net/xqf1gnf.css">
	<?php
}
add_action( 'wp_head', 'add_type_kit' );

function shortcode_links_with_group() {
    global $post;

    if( have_rows('links', $post->ID) ) {
        ob_start();

        while( have_rows('links', $post->ID) ) {
            the_row();

            // Get the group inside the repeater
            $group = get_sub_field('links');

            if ( $group ) {
                $url = esc_url( $group['link'] );
                $text = esc_html( $group['link_name'] );

                echo '<a href="' . $url . '">' . $text . '</a><br>';
            }
        }

        return ob_get_clean();
    }

    return '';
}
add_shortcode('incentive_links', 'shortcode_links_with_group');

function shortcode_download_links_with_group() {
    global $post;

    if( have_rows('downloads', $post->ID) ) {
        ob_start();

        while( have_rows('downloads', $post->ID) ) {
            the_row();

            // Get the group inside the repeater
            $group = get_sub_field('downloads');

            if ( $group ) {
                $url = esc_url( $group['download_link'] );
                $text = esc_html( $group['download_link_name'] );

                echo '<a href="' . $url . '">' . $text . '</a><br>';
            }
        }

        return ob_get_clean();
    }

    return '';
}
add_shortcode('incentive_downloads', 'shortcode_download_links_with_group');

function bb_clickable_row_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const row = document.getElementById('clickable-row');
        if (row) {
            row.addEventListener('click', function(e) {
                // Prevent if a link or button inside is clicked
                if (e.target.closest('a, button')) return;
                window.location.href = 'https://fortbendcounty.com/why-fort-bend/our-cities/';
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'bb_clickable_row_script');

function google_tag_manager() { ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TP9WHVG2');</script>
<!-- End Google Tag Manager -->
<?php }

add_action( 'wp_head', 'google_tag_manager' );
function google_tag_manager_body() { ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TP9WHVG2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php }
add_action('astra_body_top', 'google_tag_manager_body');