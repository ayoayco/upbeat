<?php global $woo_options; ?>

	<?php
		$total = $woo_options[ 'woo_footer_sidebars' ]; if (!isset($total)) $total = 4;
		if ( ( woo_active_sidebar( 'footer-1') ||
			   woo_active_sidebar( 'footer-2') ||
			   woo_active_sidebar( 'footer-3') ||
			   woo_active_sidebar( 'footer-4') ) && $total > 0 ) :

  	?>
	<div id="footer-widgets" class="col-full col-<?php echo $total; ?>">

		<?php $i = 0; while ( $i < $total ) : $i++; ?>
			<?php if ( woo_active_sidebar( 'footer-'.$i) ) { ?>

		<div class="block footer-widget-<?php echo $i; ?>">
        	<?php woo_sidebar( 'footer-'.$i); ?>
		</div>

	        <?php } ?>
		<?php endwhile; ?>

		<div class="fix"></div>

	</div><!-- /#footer-widgets  -->
    <?php endif; ?>
    
    <?php woo_content_after(); ?>
    
  </div><!--/#container-->
  	<div id="outer-footer">
  		<div id="footer" class="col-full">
			<div id="top">
				<div class="col-full">
					<?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'top-nav', 'menu_class' => 'nav fl', 'theme_location' => 'top-menu' ) ); ?>
				</div>

				<!-- simple social icons -->
				<!--div style="margin-top: -37px; margin-bottom: -12px; padding-left: 300px;" id="simple-social-icons-2" class="widget simple-social-icons"><ul class="alignleft"><li class="social-facebook"><a href="http://facebook.com/upbeatmerchandise" >&#xe802;</a></li><li class="social-instagram"><a href="http://instagram.com/ayoayco" >&#xe809;</a></li><li class="social-twitter"><a href="http://twitter.com/theabsorbingman" >&#xe80d;</a></li></ul></div-->
			
			</div><!-- /#top -->
			<div id="copyright" class="col-left" style="margin-left: 50px;">
				<?php if( $woo_options[ 'woo_footer_left' ] == 'true' ) {

						echo stripslashes( $woo_options['woo_footer_left_text'] );

				} else { ?>
					<p><?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.<br />', 'woothemes' ); ?><img height="80px" src="<?php echo home_url('/')."wp-content/uploads/2014/06/logo-clear.png" ; ?>" style="border: none;" alt="Upbeat Merchandise" /></a>
				<?php } ?></p>
			</div>
				
			<div id="contact-info" class="col-left">
				<?php if( $woo_options[ 'woo_footer_left' ] == 'true' ) {

						echo stripslashes( $woo_options['woo_footer_left_text'] );

				} else { ?>
					<p style="width:100%; border: 1 solid black;">
						CONTACT US<br />
						For Inquiries or updates on your order status:
						<ul style="font-size: small; color: #ccc; margin-top: -15px;">
						<li>Call or text us:  09178449126 </li>
						<li>You could also email us: mail@upbeat.ph</li> 
						</ul>
					</p>
				<?php } ?>
			</div>

			<div id="credit" class="col-right" style="margin-right: 50px; float: right;">
		        <?php if( $woo_options[ 'woo_footer_right' ] == 'true' ){

		        	echo stripslashes( $woo_options['woo_footer_right_text'] );

				} else { ?>
					<p><?php _e( 'Development and Design by<br />', 'woothemes' ); ?> <a title="AbsorbingDesign Studio" style="color: #ff8402; font-weight:bold;" href="http://absorbingdesign.com"><img id="footerlogo" src="<?php echo home_url('/')."wp-content/uploads/2014/06/logo-small.png" ; ?>" style="border: none;" alt="AbsorbingDesign" /></a></p>
				<?php } ?>
			</div>

		</div><!-- /#footer  -->
	</div><!-- /#outer-footer -->

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<?php woo_foot(); ?>
</body>
</html>