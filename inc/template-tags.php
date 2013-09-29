<?php
/***************************************************************
* Function pxlfaq_taxonomy_dropdown()
* Create dropdown custom taxonomy term list
***************************************************************/
function pxlfaq_taxonomy_dropdown( $pxlfaq_taxonomy, $pxlfaq_default_option_name ) {
	
	/* set the args for get_terms */
	$pxlfaq_terms_args = array();
	
	/* get the terms for our taxonomy */
	$pxlfaq_terms = get_terms( $pxlfaq_taxonomy, $pxlfaq_terms_args );
	
	/* setup a select input type */
	echo '<select name="' . $pxlfaq_taxonomy .'" id="' . $pxlfaq_taxonomy .'">';
	
	/* create a default option */
    echo '<option value= "" >' . $pxlfaq_default_option_name . '</option>';
    
    /* loop through each term */
    foreach( $pxlfaq_terms as $pxlfaq_term ) {
	    
	    echo '<option value="', $pxlfaq_term->slug, '">' . $pxlfaq_term->name . '</option>';
	    
    }
    
    /* close out our select input */
    echo '</select>';
	
}

/***************************************************************
* Function pxlfaq_faq_cat_dropdopwn()
* Generate a dropdown list of faq categories.
***************************************************************/
function pxlfaq_faq_cat_dropdopwn() {

	?>
	
	<form class="pxlfaq-filter-choice pxlfaq-faq-cat-dropdown" action="<?php echo home_url(); ?>" method="get">
							
		<?php pxlfaq_taxonomy_dropdown( 'pxlfaq_faq_cat', '-- Select a Category --' ); ?>
	
		<input type="submit" name="submit" value="view" />
	
	</form>
	
	<?php
	
}

/***************************************************************
* Function pxlfaq_faq_tag_dropdopwn()
* Generate a dropdown list of faq categories.
***************************************************************/
function pxlfaq_faq_tag_dropdopwn() {
	
	?>

	<form class="pxlfaq-filter-choice pxlfaq-tag-dropdown" action="<?php echo home_url(); ?>" method="get">
							
		<?php pxlfaq_taxonomy_dropdown( 'pxlfaq_faq_tag', '-- Select a Keyword --' ); ?>
	
		<input type="submit" name="submit" value="view" />
	
	</form>
	
	<?php

}