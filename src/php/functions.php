<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup() {
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
add_theme_support( 'woocommerce' );
global $content_width;
if ( !isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'blankslate' ) ) );
}
add_action( 'admin_notices', 'blankslate_notice' );
function blankslate_notice() {
$user_id = get_current_user_id();
$admin_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$param = ( count( $_GET ) ) ? '&' : '?';
if ( !get_user_meta( $user_id, 'blankslate_notice_dismissed_9' ) && current_user_can( 'manage_options' ) )
echo '<div class="notice notice-info"><p><a href="' . esc_url( $admin_url ), esc_html( $param ) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__( 'Ⓧ', 'blankslate' ) . '</big></a>' . wp_kses_post( __( '<big><strong>🏆 Thank you for using BlankSlate!</strong></big>', 'blankslate' ) ) . '<p>' . esc_html__( 'Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate' ) . '</p><a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__( 'Donate', 'blankslate' ) . '</strong> ' . esc_html__( '(New Open Collective)', 'blankslate' ) . '</a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__( 'Review', 'blankslate' ) . '</strong></a> <a href="https://github.com/tidythemes/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__( 'Support', 'blankslate' ) . '</strong></a></p></div>';
}
add_action( 'admin_init', 'blankslate_notice_dismissed' );
function blankslate_notice_dismissed() {
$user_id = get_current_user_id();
if ( isset( $_GET['dismiss'] ) )
add_user_meta( $user_id, 'blankslate_notice_dismissed_9', 'true', true );
}
add_action( 'wp_enqueue_scripts', 'blankslate_enqueue' );
function blankslate_enqueue() {
wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
wp_enqueue_script( 'jquery' );
}
add_action( 'wp_footer', 'blankslate_footer' );
function blankslate_footer() {
?>
<script>
jQuery(document).ready(function($) {
var deviceAgent = navigator.userAgent.toLowerCase();
if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
$("html").addClass("ios");
$("html").addClass("mobile");
}
if (deviceAgent.match(/(Android)/)) {
$("html").addClass("android");
$("html").addClass("mobile");
}
if (navigator.userAgent.search("MSIE") >= 0) {
$("html").addClass("ie");
}
else if (navigator.userAgent.search("Chrome") >= 0) {
$("html").addClass("chrome");
}
else if (navigator.userAgent.search("Firefox") >= 0) {
$("html").addClass("firefox");
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
$("html").addClass("safari");
}
else if (navigator.userAgent.search("Opera") >= 0) {
$("html").addClass("opera");
}
});
</script>
<?php
}
add_filter( 'document_title_separator', 'blankslate_document_title_separator' );
function blankslate_document_title_separator( $sep ) {
$sep = esc_html( '|' );
return $sep;
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return esc_html( '...' );
} else {
return wp_kses_post( $title );
}
}
function blankslate_schema_type() {
$schema = 'https://schema.org/';
if ( is_single() ) {
$type = "Article";
} elseif ( is_author() ) {
$type = 'ProfilePage';
} elseif ( is_search() ) {
$type = 'SearchResultsPage';
} else {
$type = 'WebPage';
}
echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
}
add_filter( 'nav_menu_link_attributes', 'blankslate_schema_url', 10 );
function blankslate_schema_url( $atts ) {
$atts['itemprop'] = 'url';
return $atts;
}
if ( !function_exists( 'blankslate_wp_body_open' ) ) {
function blankslate_wp_body_open() {
do_action( 'wp_body_open' );
}
}
add_action( 'wp_body_open', 'blankslate_skip_link', 5 );
function blankslate_skip_link() {
echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'blankslate' ) . '</a>';
}
add_filter( 'the_content_more_link', 'blankslate_read_more_link' );
function blankslate_read_more_link() {
if ( !is_admin() ) {
return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'blankslate' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'excerpt_more', 'blankslate_excerpt_read_more_link' );
function blankslate_excerpt_read_more_link( $more ) {
if ( !is_admin() ) {
global $post;
return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'blankslate' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'blankslate_image_insert_override' );
function blankslate_image_insert_override( $sizes ) {
unset( $sizes['medium_large'] );
unset( $sizes['1536x1536'] );
unset( $sizes['2048x2048'] );
return $sizes;
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init() {
register_sidebar( array(
'name' => esc_html__( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'wp_head', 'blankslate_pingback_header' );
function blankslate_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script() {
if ( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}
function blankslate_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
<?php
}
add_filter( 'get_comments_number', 'blankslate_comment_count', 0 );
function blankslate_comment_count( $count ) {
if ( !is_admin() ) {
global $id;
$get_comments = get_comments( 'status=approve&post_id=' . $id );
$comments_by_type = separate_comments( $get_comments );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}


//Wordpress sucks ass
// Prevent WordPress from modifying HTML structure in pages
function prevent_wpautop_custom_html( $content ) {
    global $post;

    // Check if the content is from a page
    if ( is_page() && isset($post->post_content) ) {
        // Check if the content is manually written HTML (not generated by WordPress)
        if ( strpos( $post->post_content, '<html>' ) === 0 ) { // Assuming you wrap your custom HTML content in <html> tags
            // Remove filters only once
            remove_filter( 'the_content', 'wpautop' );
            remove_filter( 'the_content', 'wptexturize' );
            remove_filter( 'the_content', 'convert_smilies' );
            remove_filter( 'the_content', 'convert_chars' );
            remove_filter( 'the_content', 'shortcode_unautop' );
            remove_filter( 'the_content', 'prepend_attachment' );

            return $post->post_content;
        }
    }

    return $content;
}
add_filter( 'the_content', 'prevent_wpautop_custom_html', 1 );




function add_custom_stylesheet_to_header() {
    // Output the custom stylesheet link tag
    echo '<link href="https://static-cdn.e2ma.net/signups/css/signup-refresh.lrg.css" rel="stylesheet" type="text/css">';
}
add_action('wp_head', 'add_custom_stylesheet_to_header');








function custom_blog_posts_shortcode($atts) {
   ob_start(); // Start output buffering
   ?>
   <div class="blog_section">
       <div class="blog_section_inner_blogs">
           <?php
           $args = array(
               'post_type' => 'post',
               'posts_per_page' => 3, 
               'order' => 'DESC', 
           );

           $query = new WP_Query($args);

           if ($query->have_posts()) :
               while ($query->have_posts()) :
                   $query->the_post();
                   ?>
                   <div class="blog_block">
                       <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                       <a href="<?php the_permalink(); ?>">
                           <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>"/>
                       </a>
                       <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
					   <div class='home_page_blog_date'>
						  <span><?php echo get_the_date('F jS, Y'); ?></span>
					   </div>
                   </div>
                   <?php
               endwhile;
               wp_reset_postdata(); 
           else :
               echo 'No posts found';
           endif;
           ?>
       </div>
       <div class="blog_history_shell">
           <div class="blog_history">
               <h2>Our History</h2>
               <p>Click the button below to learn about the History of the Center for RelationaLearning</p>
               <div class='learn_more_history_container'>
                   <a href='https://dev.relationalearning.com/history/'>
                       <button class='learn_more_history'>Learn More</button>
                   </a>
               </div>
           </div>
       </div>
   </div>
   <?php
   return ob_get_clean(); // Return the buffered content
}
add_shortcode('custom_blog_posts', 'custom_blog_posts_shortcode');



function remove_category_menu_links( $items, $menu, $args ) {
    foreach ( $items as $key => $item ) {
        if ( 'taxonomy' === $item->type && 'category' === $item->object ) {
            $items[$key]->url = '#';
            $items[$key]->target = '';
        }
    }
    return $items;
}
add_filter( 'wp_get_nav_menu_items', 'remove_category_menu_links', 10, 3 );


//FACULTY BIO ONE
function faculty_bio_shortcode() {
    // Enqueue JavaScript
    wp_enqueue_script('jquery');

   $js_code = "
    <script>
    jQuery(document).ready(function($) {
        $('.faculty-bio-h2b').click(function() {
            var bioId = $(this).find('.toggle-bio').attr('data-bio-id');
            var bioInner = $('#' + bioId);
            bioInner.toggleClass('visible');
            // Toggle the button text or icon
            var toggleBtn = $(this).find('.toggle-bio');
            if (bioInner.hasClass('visible')) {
                toggleBtn.html('-'); // Change to a minus sign
            } else {
                toggleBtn.html('+'); // Change back to a plus sign
            }
        });
    });
    </script>";

    $css_code = "
    <style>
    .faculty-bio-inner {
        overflow: hidden;
        max-height: 0;
		transition: 0.5s;
    }
    .faculty-bio-inner.visible {
        height: auto;
        max-height: 500px;
    }
    .toggle-bio {
        font-size: 24px; /* Adjust size as needed */
        cursor: pointer;
        /* You might want to adjust the styling if the whole div is clickable */
    }
    /* Style to indicate the whole div is clickable */
    .faculty-bio-h2b {
        cursor: pointer;
    }
    </style>";

    // Shortcode content
    $shortcode_content = "
    <div class='faculty-bio'>
	<div class='faculty-bio-h2b'>
	  <button class='toggle-bio' data-bio-id='bio1'>+</button>
        <h2>Sofia Martinez</h2>
      
	</div>	
        <div class='faculty-bio-inner' id='bio1'>
            <p>Bio for Sofia Martinez...</p>
        
        </div>
		<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio2'>+</button>
        <h2>John Doe</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio2'>
            <p>Bio for John Doe...</p>
          
        </div>
		<div class='faculty-bio-h2b'>
		 <button class='toggle-bio' data-bio-id='bio3'>+</button>
        <h2>Jane Smith</h2>
     
		</div>
        <div class='faculty-bio-inner' id='bio3'>
            <p>Bio for Jane Smith...</p>
    
        </div>
		<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio4'>+</button>
        <h2>Alex Johnson</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio4'>
            <p>Bio for Alex Johnson...</p>
            
        </div>
    </div>";

    // Combine CSS, JavaScript, and Shortcode content
    $shortcode_output = $css_code . $js_code . $shortcode_content;

    return $shortcode_output;
}
add_shortcode('faculty_bio', 'faculty_bio_shortcode');





// Shortcode for desktop version content
function desktop_content_shortcode($atts, $content = null) {
    return '<div class="desktop-content">' . do_shortcode($content) . '</div>';
}
add_shortcode('desktop_content', 'desktop_content_shortcode');

// Shortcode for mobile version content
function mobile_content_shortcode($atts, $content = null) {
    return '<div class="mobile-content">' . do_shortcode($content) . '</div>';
}
add_shortcode('mobile_content', 'mobile_content_shortcode');

