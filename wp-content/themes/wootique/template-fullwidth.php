<?php
/*
Template Name: Full Width
*/

get_header();

?>

	<?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
		<?php woo_breadcrumbs(); ?> 
	<?php } ?>
       
    <div id="content" class="page col-full">
    	
		<div id="main" class="fullwidth">  

            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div <?php post_class(); ?>>

				    <h1 class="title"><?php the_title(); ?></h1>
                 
<?php
if(is_page("store-locations-2")) echo "<iframe src='".home_url('/')."map/index.html' style='margin-top: -70px; margin-left: -50px;' width='980px' height='470px' alt='Locations'></iframe>";
?>
                    <div class="entry">
	                	<?php the_content(); ?>  	
	               	</div><!-- /.entry -->

					<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>

                </div><!-- /.post -->
                                                    
			<?php endwhile; else: ?>
				<div <?php post_class(); ?>>
                	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ) ?></p>
                </div><!-- /.post -->
            <?php endif; ?>  
        
		</div><!-- /#main -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>