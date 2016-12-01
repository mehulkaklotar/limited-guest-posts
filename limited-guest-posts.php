<?php
/**
 * Plugin Name: Limited Guest Posts
 * Plugin URI: https://github.com/mehulkaklotar/limited-guest-posts
 * Description: Limit the posts for guests to view
 * Version: 1.0
 * Author: mehulkaklotar
 * Author URI: http://kaklo.me
 * Requires at least: 4.1
 * Tested up to: 4.5
 *
 * Text Domain: limited-guest-posts
 *
 * @package Limited_Guest_Posts
 * @category Core
 * @author mehulkaklotar
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Limited_Guest_Posts' ) ) {

	/**
	 * Main Limited_Guest_Posts Class
	 *
	 * @class Limited_Guest_Posts
	 * @version	1.0.0
	 */
	final class Limited_Guest_Posts {

		/**
		 * @var string
		 */
		public $version = '1.0.0';
		/**
		 * @var Limited_Guest_Posts The single instance of the class
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main Limited_Guest_Posts Instance
		 *
		 * Ensures only one instance of Limited_Guest_Posts is loaded or can be loaded.
		 *
		 * @since 0.1
		 * @static
		 * @see limited_guest_posts()
		 * @return Limited_Guest_Posts - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Limited_Guest_Posts Constructor.
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters
		 * @since  1.0.0
		 */
		private function init_hooks() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
		}

		/**
		 * Init when WordPress Initialises.
		 */
		public function enqueue_script() {
			wp_enqueue_script( 'mandarin-limited-posts-js', plugins_url('script.js', __FILE__), array( 'jquery' ) );
			$params = array();
			if ( ! is_user_logged_in() ) {
				$params['is_user_logged_in'] = false;

				if( is_single() ) {
					$params['is_single'] = true;
					$params['post_id'] = get_the_ID();
					$params['registration_url'] = wp_registration_url();
				} else {
					$params['is_single'] = false;
				}

			} else {
				$params['is_user_logged_in'] = true;
			}

			wp_localize_script( 'mandarin-limited-posts-js', 'params', $params );
		}

	}

	/**
	 * Returns the main instance of limited_guest_posts to prevent the need to use globals.
	 *
	 * @since  1.0.0
	 * @return Limited_Guest_Posts
	 */
	function limited_guest_posts() {
		return Limited_Guest_Posts::instance();
	}

	limited_guest_posts();

}