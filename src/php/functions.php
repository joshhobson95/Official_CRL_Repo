<?php
function blankslate_child_enqueue_styles() {
    wp_enqueue_style('blankslate-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('blankslate-child-style', get_stylesheet_directory_uri() . '/style.css', array('blankslate-parent-style'));
}
add_action('wp_enqueue_scripts', 'blankslate_child_enqueue_styles');

add_action( 'after_setup_theme', 'blankslate_child_setup' );
function blankslate_child_setup() {
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

add_action( 'admin_notices', 'blankslate_child_notice' );
function blankslate_child_notice() {
    $user_id = get_current_user_id();
    $admin_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = ( count( $_GET ) ) ? '&' : '?';
    if ( !get_user_meta( $user_id, 'blankslate_child_notice_dismissed_9' ) && current_user_can( 'manage_options' ) )
        echo '<div class="notice notice-info"><p><a href="' . esc_url( $admin_url ), esc_html( $param ) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__( 'Ⓧ', 'blankslate' ) . '</big></a>' . wp_kses_post( __( '<big><strong>🏆 Thank you for using BlankSlate!</strong></big>', 'blankslate' ) ) . '<p>' . esc_html__( 'Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate' ) . '</p><a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__( 'Donate', 'blankslate' ) . '</strong> ' . esc_html__( '(New Open Collective)', 'blankslate' ) . '</a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__( 'Review', 'blankslate' ) . '</strong></a> <a href="https://github.com/tidythemes/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__( 'Support', 'blankslate' ) . '</strong></a></p></div>';
}
add_action( 'admin_init', 'blankslate_child_notice_dismissed' );
function blankslate_child_notice_dismissed() {
    $user_id = get_current_user_id();
    if ( isset( $_GET['dismiss'] ) )
        add_user_meta( $user_id, 'blankslate_child_notice_dismissed_9', 'true', true );
}

add_action( 'wp_enqueue_scripts', 'blankslate_child_enqueue' );
function blankslate_child_enqueue() {
    wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
    wp_enqueue_script( 'jquery' );
}

add_action( 'wp_footer', 'blankslate_child_footer' );
function blankslate_child_footer() {
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

add_filter( 'document_title_separator', 'blankslate_child_document_title_separator' );
function blankslate_child_document_title_separator( $sep ) {
    $sep = esc_html( '|' );
    return $sep;
}

add_filter( 'the_title', 'blankslate_child_title' );
function blankslate_child_title( $title ) {
    if ( $title == '' ) {
        return esc_html( '...' );
    } else {
        return wp_kses_post( $title );
    }
}

function blankslate_child_schema_type() {
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

add_filter( 'nav_menu_link_attributes', 'blankslate_child_schema_url', 10 );
function blankslate_child_schema_url( $atts ) {
    $atts['itemprop'] = 'url';
    return $atts;
}

if ( !function_exists( 'blankslate_child_wp_body_open' ) ) {
    function blankslate_child_wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

add_action( 'wp_body_open', 'blankslate_child_skip_link', 5 );
function blankslate_child_skip_link() {
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'blankslate' ) . '</a>';
}

add_filter( 'the_content_more_link', 'blankslate_child_read_more_link' );
function blankslate_child_read_more_link() {
    if ( !is_admin() ) {
        return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'blankslate' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
    }
}

add_filter( 'excerpt_more', 'blankslate_child_excerpt_read_more_link' );
function blankslate_child_excerpt_read_more_link( $more ) {
    if ( !is_admin() ) {
        global $post;
        return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'blankslate' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
    }
}

add_filter( 'big_image_size_threshold', '__return_false' );

add_filter( 'intermediate_image_sizes_advanced', 'blankslate_child_image_insert_override' );
function blankslate_child_image_insert_override( $sizes ) {
    unset( $sizes['medium_large'] );
    unset( $sizes['1536x1536'] );
    unset( $sizes['2048x2048'] );
    return $sizes;
}

add_action( 'widgets_init', 'blankslate_child_widgets_init' );
function blankslate_child_widgets_init() {
    register_sidebar( array(
        'name' => esc_html__( 'Sidebar Widget Area', 'blankslate' ),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}

add_action( 'wp_head', 'blankslate_child_pingback_header' );
function blankslate_child_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}

add_action( 'comment_form_before', 'blankslate_child_enqueue_comment_reply_script' );
function blankslate_child_enqueue_comment_reply_script() {
    if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function blankslate_child_custom_pings( $comment ) {
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
    <?php
}

add_filter( 'get_comments_number', 'blankslate_child_comment_count', 0 );
function blankslate_child_comment_count( $count ) {
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
                   <a href='https://relationalearning.com/history/'>
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
        var linkOpened = false;

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

        // Handle clicks on links
        $('.faculty-bio-inner a').click(function(event) {
            // Check if link has already been opened
            if (!linkOpened) {
                // Link has not been opened yet
                // Set flag to true
                linkOpened = true;
            } else {
                // Link has already been opened
                // Prevent default behavior
                event.preventDefault();
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
        <h2>Bob Sparks</h2>
      
	</div>	
        <div class='faculty-bio-inner' id='bio1'>
            <p>Bob is a seasoned entrepreneur, developer, educator, and community advocate with a passion for fostering personal well-being. Currently, he serves as a leadership coach and business advisor, championing RelationaLeadership to enhance both organizational performance and personal satisfaction. Bob advocates for leadership courage, creativity, and authenticity as pathways to joy and happiness. With a diverse background spanning roles such as founder, partner, therapist, professor, and superintendent, including founding and managing various ventures, he offers a broad perspective on leadership and personal growth. His expertise in building businesses, training leaders, and mentoring individuals towards joyful leadership lives has made him a sought-after development expert. Notably, he finds fulfillment in his role as an advisor and RelationaLearning Coach at Sparks Financial, a leading wealth management firm.</p>
        
        </div>
		<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio2'>+</button>
        <h2>Lisa Otero</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio2'>
            <p>Lisa Otero is the Principal of Many Nations Academy in Portland, Oregon, the sole culturally specific, Native American-focused high school in the city. With three decades of experience in education, she champions a philosophy centered on Relationships First, culturally responsive pedagogies, and healing-centered engagement. Lisa's career has seen her serve as a classroom teacher, Dean of Students, Athletic Director, and Principal across California, New Mexico, and Oregon. She has led professional development sessions, workshops, and study tours for educators in the United States and Australia, co-authoring the book 'RelationaLearning: A Guide to Using Notebooks in the Classroom.' Committed to community-centered schooling, Lisa advocates for institutions that prioritize cultural expression, authenticity, and equity, aiming to dismantle oppressive systems and foster environments that are just, loving, and healing for all stakeholders. She envisions a shift towards human-centered schooling that celebrates and serves communities and individuals authentically.</p>
          
        </div>
		<div class='faculty-bio-h2b'>
		 <button class='toggle-bio' data-bio-id='bio3'>+</button>
        <h2>Sofia Martinez</h2>
     
		</div>
        <div class='faculty-bio-inner' id='bio3'>
            <p>Sofia Martinez is a Marketing Coordinator and Program Specialist at the Center for RelationaLearning, where she has been instrumental in expanding the organization's online presence and facilitating access to its content during times of isolation. Since joining in 2020, Sofia has dedicated herself to supporting marketing initiatives and developing programs, notably contributing to the growth of the <a href='https://dev.relationalearning.com/courses/'>Online RelationaLiteracy Academy </a> launched in 2023. Her recent role as publisher for the latest edition of <a href='https://dev.relationalearning.com/publications/'>'Dialogue for Democracy'</a> underscores her commitment to advancing educational resources. With a proven track record in marketing and program development, Sofia plays a vital role in driving the Center's mission forward. Connect with Sofia on LinkedIn at <a href='https://www.linkedin.com/in/sofia-martinez-91363b231/'>www.linkedin.com/in/sofia-martinez-91363b231.</a></p>
    
        </div>
		<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio4'>+</button>
        <h2>Professor John Halsey</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio4'>
            <p>John is an Emeritus Professor at Flinders University, recognized for his substantial contributions to education, particularly in rural contexts. With a background spanning teaching, school leadership, and high-level educational administration, he brings a wealth of experience to his research and advocacy. His doctoral research, focusing on the role construction of rural school principals, sheds light on the intricate dynamics of rural education. John passionately advocates for accessible, high-quality education and care in rural areas, emphasizing their pivotal role in sustaining vibrant communities. He underscores the importance of nurturing rural educational leaders and ensuring governmental support to address the unique challenges and opportunities of rural education.</p>
            
        </div>
		
		
		
				<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio5'>+</button>
        <h2>Robert Csoti</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio5'>
            <p>Robert is an educational consultant specializing in cultivating dynamic school cultures and effective leadership teams through Professional Learning days and coaching, with a focus on Relational Leadership. As a leadership coach and Principal mentor, he aids leaders in enhancing their capacity for community-building, team management, and innovation. Robert emphasizes the development of Emotional Intelligence to empower leaders to excel. Formerly, he served as the Principal of Elwood Primary School, known for its strong community involvement and innovative approach to learning. Collaborating with George, David Rothstadt, and Monash University, Robert contributed to the development of community-focused schools, advocating for personalized curricula and enhanced learning relationships. He believes in challenging traditional compliance paradigms and fostering leadership courage to enact meaningful change within educational communities.</p>
            
        </div>
		
		
			<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio6'>+</button>
        <h2>Maggie Farrar</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio6'>
            <p>Maggie brings a wealth of experience from senior leadership roles in schools and Local Authorities in London and Birmingham, including serving as Director for Leadership Development, Research, and Succession Planning at the National College for School Leadership in England. Instrumental in shaping school-led self-improvement systems, she has designed leadership programs to foster system leadership and cluster-based school improvement approaches. Maggie's international work extends to supporting the development of educational leadership frameworks in Wales and collaborating on networked, self-improving school systems globally. Recently, she has focused on nurturing the 'inner life' of school leaders, leveraging mindfulness practices to enhance leadership presence and well-being. You can experience some of her life-changing mindfulness work through her current offering through the Center, <a href='https://dev.relationalearning.com/programs/'>“RelationaLeadership and the Power of Presence”. </a>
As a Trustee of 'The Story Museum' in Oxford, she contributes to their mission of transforming lives through storytelling. Visit her website at <a href='https://www.empoweringleadership.co.uk/'>https://www.empoweringleadership.co.uk/</a> for leadership resources and more information about Maggie's work.</p>
            
        </div>
		
		
		
			<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio7'>+</button>
        <h2>Zoe Otero-Martinez</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio7'>
            <p>Zoé Otero-Martinez brings over two decades of impactful service in New Mexico's non-profit sector, excelling in connecting communities and driving effective strategies. Her expertise encompasses consortium building, program management, fundraising, and comprehensive outreach efforts. Driven by a steadfast commitment to social justice, Zoé thrives on collaborating with like-minded organizations. Through the application of human-centered design principles, she pioneers innovative solutions to societal challenges. Zoé holds a Bachelor of Science in Family Studies from the University of New Mexico, grounding her belief in the vital role of family wellness in community health and positive transformation. Currently serving as the Civic Engagement Manager for the City of Albuquerque, Zoé focuses on volunteer engagement, education partnerships, community conversations, and non-profit and philanthropic initiatives. Her approach recognizes the intrinsic link between civic engagement and family well-being, advocating for robust community involvement to nurture thriving, resilient families and communities.
</p>
            
        </div>
		
		
					<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio8'>+</button>
        <h2>David Rothstadt</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio8'>
            <p>David Rothstadt, residing in Victoria, Australia, has dedicated much of his career to collaborating with diverse communities, notably during his tenure as Principal of Noble Park Primary School. His partnership with George Otero facilitated a focus on community-building to enhance student learning, resulting in the collaborative publication 'Creating Powerful Learning Relationships: A Whole School Community Approach,' co-authored with Robert Csoti and George, subsequently expanded in a second edition to emphasize leadership. David advocates for partnerships between school communities and local/global organizations to mutually benefit and support youth, stressing the importance of schools evolving beyond mere educational institutions to become integral community organizations. He actively promotes this agenda through local conferences and engagement in New Mexico. Interested in social enterprises and policy development, David currently volunteers in the Disability Sector with the Office of the Public Advocate, exemplifying his commitment to practical community involvement and advancement.


</p>
            
        </div>
		
		
						<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio9'>+</button>
        <h2>Josh Hobson</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio9'>
            <p>Josh Hobson, a proficient web developer hailing from Albuquerque, New Mexico, has been crafting digital landscapes since 2022. A graduate of Sandia Preparatory School and Seattle Central College, Josh's journey into the realms of coding began early, fueling his passion for website development. With a keen eye for design and a knack for coding wizardry, he seamlessly blends functionality with aesthetics. Josh's dedication shines through in every line of code, evident in the website you're currently exploring. For more of his work, visit his website at <a href='https://joshhobson95.github.io/'>joshhobson95.github.io.</a>


</p>
            
        </div>
		
		
				<div class='faculty-bio-h2b'>
		<button class='toggle-bio' data-bio-id='bio10'>+</button>
        <h2>Lois Vermilya, M.A.</h2>
        
		</div>
        <div class='faculty-bio-inner' id='bio10'>
            <p>Lois retired the summer of 2023 after 45 years of service as an educator and non-profit executive leading organizations dedicated to the well being of children and their families. Her lifetime of work was devoted to sustaining trusted partnerships for community-led change, collaborating with tribes, communities and organizations throughout the southwest United States; consulting with programs in California and with sister organizations in Latin America; and facilitating learning sessions with other national partners. Lois has been a colleague and friend with George Otero for over 25 years who cherished hosting study tours at her former Wemagination Learning Center to creatively explore how children and adults learn through play. She also traveled in partnership with the Center for Relational Learning  to Melbourne Australia to provide collaborative leadership training and Wemagination learning opportunities with George’s colleagues there. Lois earned a Masters in Symbolic Anthropology from the University of New Mexico, is a national Zero To Three Leadership Academy Fellow, and has authored publications on dialogue, family and community engagement, collaborative leadership, and early childhood systems change. She believes that no civic decision should be made without first asking the question: what impact will this have on our children?


</p>
            
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






function fetch_podcast_access_token() {
    $client_id = 'f943423a105d9b7227eb2';
    $client_secret = '2ccba26d9eaae14fae192';
    $token_url = 'https://api.podbean.com/v1/oauth/token';

    // Request access token
    $response = wp_remote_post($token_url, array(
        'body' => array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ),
    ));

    if (is_wp_error($response)) {
        error_log('Token request failed: ' . $response->get_error_message()); // Log error message
        return null;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['access_token'])) {
        error_log('Access token not found in response'); // Log error message
        return null;
    }

    $access_token = $data['access_token'];

    // Log access token (optional)
    error_log('Access token retrieved successfully: ' . $access_token);

    return $access_token;
}



function fetch_podcast_episodes() {
    $client_id = 'f943423a105d9b7227eb2';
    $client_secret = '2ccba26d9eaae14fae192';
    $token_url = 'https://api.podbean.com/v1/oauth/token';
    $episodes_url = 'https://api.podbean.com/v1/episodes';

    // Request access token
    $access_token = fetch_podcast_access_token();

    if (!$access_token) {
        return []; // Return empty array if access token retrieval failed
    }

    // Get episodes using access token
    $response = wp_remote_get($episodes_url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $access_token,
        ),
    ));

    if (is_wp_error($response)) {
        error_log('Episodes request failed: ' . $response->get_error_message()); // Log error message
        return [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Log the entire data structure from Podbean
    error_log('Podbean Episodes Data: ' . print_r($data, true));

    if (!isset($data['episodes'])) {
        error_log('Episodes not found in response'); // Log error message
        return [];
    }

    $episodes = $data['episodes'];

    // Log episodes data (optional)
    error_log('Episodes data retrieved successfully: ' . print_r($episodes, true));

    return $episodes;
}



function display_podcast_episodes() {
    $episodes = fetch_podcast_episodes();

    if (empty($episodes)) {
        return '<p>No episodes found or unable to fetch episodes.</p>';
    }

    ob_start();
    echo '<div class="podcast-container">';
    foreach ($episodes as $episode) {
        // Ensure $episode is an array before accessing its keys
        if (!is_array($episode)) {
            continue; // Skip if $episode is not an array
        }

        echo '<div class="podcast-episode">';

        // Output the podcast title if it exists
        if (isset($episode['title'])) {
            echo '<h3>' . esc_html($episode['title']) . '</h3>';
        }

        // Output the podcast description if it exists
        if (isset($episode['content'])) {
            echo '<div class="podcast-description">' . wpautop($episode['content']) . '</div>';
        }

        // Output the audio player using media_url if it exists
        if (isset($episode['media_url'])) {
            echo '<iframe src="' . esc_url($episode['media_url']) . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        } else {
            echo '<p>No audio available for this episode.</p>';
        }

        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('podcast_episodes', 'display_podcast_episodes');



function display_podcast_episodes_debug() {
    ob_start();
    $episodes = fetch_podcast_episodes();
    echo '<pre>';
    print_r($episodes);
    echo '</pre>';
    return ob_get_clean();
}
add_shortcode('podcast_episodes_debug', 'display_podcast_episodes_debug');





