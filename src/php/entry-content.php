<div class="entry-content" itemprop="mainEntityOfPage">
    <div class='single_blog_outer_shell'>

		<div class='back_to_blogs'>
		<a href='https://dev.relationalearning.com/blogs/'>
			<button class='back_to_blogs_button'>
				<img src='https://dev.relationalearning.com/wp-content/uploads/2024/04/google-arrow-left.png' /> <p>Back to Blogs </p>
			</button>
		</a>		
		</div>
        <div class='single_blog_top'>
            <span><?php echo get_the_date( 'F jS, Y' ); ?></span>
            <h2><?php the_title(); ?></h2>
			      
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'full', array( 'class' => 'single_blog_featured_image' ) ); ?>
            <?php endif; ?>
        </div>

        <div class='single_blog_entry'>
            <?php the_content(); ?>
        </div>

    </div>
</div>
