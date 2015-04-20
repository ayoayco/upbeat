<?php
/**
 * Header Template
 *
 * Here we setup all logic and HTML that is required for the header section of all screens.
 *
 */
 global $woo_options, $woocommerce;
?><?php global $woocommerce; ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">

<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>

<!-- CSS  -->
	
<!-- The main stylesheet -->
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

<!-- /CSS -->

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php $GLOBALS['feedurl'] = get_option('woo_feed_url'); if ( !empty($feedurl) ) { echo $feedurl; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
      
<?php wp_head(); ?>
<?php woo_head(); ?>

</head>

<body <?php body_class(get_option('woo_site_layout')); ?>>
<?php woo_top(); ?>

<div id="wrapper">

	<?php if ( function_exists( 'has_nav_menu') && has_nav_menu( 'top-menu' ) ) { ?>
    <?php } ?>
    <div id="outer-header" style="background: #8c1010;">
	    <div class="header" style=" background: transparent;">
			
			<!-- logo -->			
				<div id="logo" class="float-left">
		
				<?php 
					if ($woo_options['woo_texttitle'] != 'true' ) : 
					$logo = $woo_options['woo_logo']; 
					if ( is_ssl() ) { $logo = preg_replace("/^http:/", "https:", $woo_options['woo_logo']); }
				?>
					<h1>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'description' ); ?>">
							<img src="<?php if ($logo) echo $logo; else { echo get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo( 'name' ); ?>" />
						</a>
					</h1>
		        <?php endif; ?>
		
		        <?php if( is_singular() && !is_front_page() ) : ?>
					<span class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></span>
		        <?php else : ?>
					<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		        <?php endif; ?>
					<span class="site-description"><?php bloginfo( 'description' ); ?></span>
		
				</div><!-- /#logo -->
				
			<!-- searchbar -->
				
			<!-- nav menu -->
				<div id="navigation" class="col-full" style="background: transparent; border:0px; width: 350px; margin: 0px; margin-left: 220px; margin-top: 30px; padding-top: 20px;" class="float-left">

					<?php
					if ( function_exists( 'has_nav_menu') && has_nav_menu( 'primary-menu') ) {
						wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
					} else {
					?>
			        <ul id="main-nav" class="nav fl">
						<?php
			        	if ( isset($woo_options[ 'woo_custom_nav_menu' ]) AND $woo_options[ 'woo_custom_nav_menu' ] == 'true' ) {
			        		if ( function_exists( 'woo_custom_navigation_output') )
								woo_custom_navigation_output();
						} else { ?>
				            <?php if ( is_page() ) $highlight = "page_item"; else $highlight = "page_item current_page_item"; ?>
				            <li class="<?php echo $highlight; ?>"><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'woothemes' ) ?></a></li>

				            <?php
				    			wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' );
						}
						?>
			        </ul><!-- /#nav -->
			        <?php } ?>
			        
			    <!-- cart link -->
			        <!--?php woo_nav_after(); ?-->
				</div><!-- /#navigation -->				<?php woo_nav_before(); ?>
				<?php if($woocommerce->cart->cart_contents_count > 0) echo '<span id="cartcount">'.sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count).'</span>';?>


				
		</div><!-- /#header -->
	</div>
	<div id="container" class="col-full">


<!-- META SLIDER GOES HERE -->
<div id="metacontainer" style="margin:0; width:720px; float:left; margin-right: 10px;">
	<div id="metaslider">
	<?php 
	if (is_front_page() || is_home()) echo do_shortcode("[metaslider id=109]");
	?>
	</div>
</div>

<!-- META SLIDER ENDS Here -->
	
<?php woo_content_before(); ?>