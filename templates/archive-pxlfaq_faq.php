<?php

/*
* FAQ archive template

* lets start by getting the header template file
* Important that the post title is wrapped with .accordion-header
* and that the post content is wrapped with .accordion-content
* classes.
*/

get_header();
		
	/* get the sidebar template for this content */
	get_sidebar( 'faq' );
	
	?>
	
	<div class="content">

	<?php
		
		/* check we have posts to display */
		if( have_posts() ) {
			
			/* begin to loop through each post */
			while( have_posts() ) : the_post();
			
				?>
				
				<article id="<?php echo get_post_type( $post->ID ); ?>-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h2 class="post-title accordion-header"><?php the_title(); ?></h2>
					
					<div class="entry-content accordion-content">
					
						<?php the_content(); ?>
					
					</div><!-- // entry-content -->
				
				</article><!-- // post-class -->
				
				<?php
			
			/* end the loop through each post */
			endwhile;
			
			/* output post navigation */
			echo pxlcore_content_nav();
			
		} // end if have posts
	
	?>

	</div><!-- // content -->
	
	<div class="clearfix"></div>

<?php

/* get the footer template file */
get_footer();

?>