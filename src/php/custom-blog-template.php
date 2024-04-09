<?php
/*
 * Template Name: Custom Blog Page
 * Description: A custom template for displaying blog posts.
 */

get_header(); // Include the header template

?>

<div class='blog_outer_shell'>

    <div class='blog_top_background'>
        <div class='blog_top'>       
            <h2>Our Blogs</h2>
            <div class='blog_top_inner'>
                <p>
                 Welcome to the Center for RelationaLearning, your vibrant corner of the internet dedicated to strengthening relationships. Explore our enriching content, designed to empower you with insights and strategies that elevate relationships to the forefront.
                </p>
            </div>
        </div>
    </div>

    <div class='blog_mid_page'>

        <?php
        // Custom query to fetch blog posts with pagination
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => 'post', // Assuming your posts are of type 'post'
            'posts_per_page' => 4,     // Number of posts per page
            'paged'          => $paged, // Current page
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>

                <div class='single_blog_container'>
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        // Output featured image
                        if (has_post_thumbnail()) {
                            the_post_thumbnail();
                        }
                        ?>
                        <div class='single_blog_inner_text'>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo wp_strip_all_tags(wp_trim_words(get_the_content(), 55, '...')); ?></p>
                            <span><?php echo get_the_date('F jS, Y'); ?></span>
                        </div>
                    </a>
                </div>

            <?php endwhile;
            wp_reset_postdata(); // Reset the post data
        else :
            echo 'No posts found.';
        endif;
        ?>

        <div class='pagination-wrapper'>
            <?php
            // Pagination
            $big = 999999999; // need an unlikely integer
            echo paginate_links(array(
                'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'  => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total'   => $query->max_num_pages,
            ));
            ?>
        </div>

    </div>

</div>

<?php
get_footer(); // Include the footer template
?>
