<div class="entry-content" itemprop="mainEntityOfPage">
    <div class='single_blog_outer_shell'>

        <div class='single_blog_top'>
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'full', array( 'class' => 'single_blog_featured_image' ) ); ?>
            <?php endif; ?>
            <h2><?php the_title(); ?></h2>
            <span><?php echo get_the_date( 'F jS, Y' ); ?></span>
        </div>

        <div class='single_blog_entry'>
            <?php the_content(); ?>
        </div>

    </div>
    <div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
