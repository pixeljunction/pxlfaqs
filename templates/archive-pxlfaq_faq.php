<?php

/*
* This is the main index template of this theme. The fallback
* template used when others are not included. This is needed
* for the theme to work.

* lets start by getting the header template file
*/

get_header();

?>

	<div class="page-title-wrapper">
	
		<div class="container">
		
			<h1 class="page-title">Antiques</h1>
		
		</div>
	
	</div>
	
	<div class="container page-wrapper">
	
		<?php
			
			/* get the sidebar template for this content */
			get_sidebar( 'antique' );
		
		?>
		
		<div class="col col-threequarter col-last content">

		<?php
		
			/* check whether the breadcrumb is available */
			if( function_exists('yoast_breadcrumb') ) {
				
				/* output the breadcrumb */
				yoast_breadcrumb( '<p class="breadcrumb">', '</p>' );
			
			}
			
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
	
	</div><!-- // page-wrapper -->

<?php

/* get the footer template file */
get_footer();

?>