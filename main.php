<?php
   /*
      Plugin Name: WP Simple Carousel
      Plugin URI: http://milardovich.com.ar/
      Description: Just another plugin for creating javascript carousels, based on jcarousel jquery plugin.
      Version: 0.2
      Author: Sergio Milardovich
      Author URI: http://kleophatra.org/playground/wp-simple-carousel/docs/
   */

	// Defines a lo milardo(klemode = true)
	define("MILARDO_PATH", dirname(__FILE__).'/', true);

	add_action('activate_wp-simple-carousel/main.php','install_carousel');
	add_action('deactivate_wp-simple-carousel/main.php', 'uninstall_carousel');
	add_action('wp_head', 'carousel_gallery_jquery_header');


		if (!function_exists('plugin_url')){
			function plugin_url(){
				return get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));	
			}
		}
	function carousel_gallery_jquery_header() {
		$plugin_url = plugin_url();
		echo '<link href="'.$plugin_url .'/js/jcarousel/style.css" rel="stylesheet" type="text/css" />' . "\n";
		echo '<link href="'.$plugin_url .'/js/jcarousel/lib/jquery.jcarousel.css" rel="stylesheet" type="text/css" />' . "\n";
		echo '<script type="text/javascript" src="' .$plugin_url.'/js/jcarousel/lib/jquery-1.2.3.pack.js"></script>' . "\n";
		echo '<script type="text/javascript" src="' .$plugin_url.'/js/jcarousel/lib/jquery.jcarousel.pack.js"></script>' . "\n";
	}

	function set_skin($skin){
		if(get_option('carousel_skin') !== $skin){
			update_option('carousel_skin', $skin);
		} else {
			add_option('carousel_skin', $skin);
		}
		echo route_carousel_skin();
	}
	function set_init($init){
		if(get_option('carousel_init') !== $init){
			update_option('carousel_init', $init);
		} else {
			add_option('carousel_init', $init);
		}
		route_carousel_init();
	}
	function set_options($args){
		if(null !== $args){
			$i=0;
			foreach($args as $arg => $value){
				$options[] = $arg.': '.$value;
				$i++;
			}
			$options = implode($options,",");
			if(get_option('carousel_options') !== $options){
				update_option('carousel_options', $options);
			} else {
				add_option('carousel_options', $options);
			}
		}
	}
	function route_carousel_init(){
		$init = get_option('carousel_init');
		echo '<script type="text/javascript">
			jQuery(document).ready(function() {
    			jQuery(\'#'.$init.'\').jcarousel({
				'.get_option('carousel_options').'
			    });
			});
		</script>';
	}
	function route_carousel_skin(){
		$skin = get_option('carousel_skin');
		echo '<link href="'.plugin_url() .'/js/jcarousel/skins/'.$skin.'/skin.css" rel="stylesheet" type="text/css" />' . "\n";
	}
	function carousel($div,$args,$skin='tango'){
		set_skin($skin);
		set_options($args);
		set_init($div);
	}
	

	function install_carousel(){
		return true;
	}
	function uninstall_carousel(){
		return true;
	}


	function show_wp_carousel($atts){
		$skin = 'tango';
		foreach($atts as $arg => $value){
			if($arg == 'div'){
				$div = $value;
			} else if($arg == 'skin'){
				$skin = $value;
			} else {
				$args[$arg] = $value;
			}
		}
		return carousel($div,$args);
	}
	add_shortcode( 'wp-simple-carousel', 'show_wp_carousel' );

?>
