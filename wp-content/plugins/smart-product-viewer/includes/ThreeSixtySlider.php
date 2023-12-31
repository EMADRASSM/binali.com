<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('ThreeSixtySlider') ) {

	class ThreeSixtySlider {
		
		public $imagesIDs;
		public $imagesURLs;
		public $imagesCount;
		
		private $ID;
		public $postID;
		public $previewImage;
		public $widthOriginal;
		public $heightOriginal;
		public $width;
		public $navigation;
		public $drag;
		public $scrollbar;
		public $scrollbar_start;
		public $style;
		public $color;
		public $border;
		public $interval;
		public $speedMultiplier;
		public $fullscreen;
		public $moveOnScroll;

		/**
		 * Constructor function parse all shortcode attributes 
		 * and create slider instance
		 * 
		 * @param array $atts
		 */
		
		function __construct( $atts ) {
			
			extract( shortcode_atts( array(
					// Product
					'id' 			=> '',
					'name' 			=> '',
					'width' 		=> '',
					'border' 		=> 'true',
					'interval'		=> '40',
					'sensitivity'	=> '7',
					'autoplay'		=> 'false',
					'fullscreen'	=> 'false',
					'move_on_scroll'=> 'false',
					'move_on_hover' => 'false',
					// Navigation
					'nav' 			=> 'true',
					'scrollbar'		=> 'false',
					'scrollbar_start' => '0',
					'color' 		=> 'gray',
					'style' 		=> 'glow',
					// Not in generator
					'drag' 			=> 'true',
					'stop_on_hover' => 'false',
					'direction' 	=> 'ltr'
			), $atts ) );

			if ($name!=='') {
				$spv_post = get_page_by_title($name, OBJECT, 'smart-product');
				$id = ($id!=='') ? $id : $spv_post->ID;
			}

			$this->imagesIDs = get_post_meta( $id, '360_images', true );

			if ( is_array( $this->imagesIDs ) ) {

				$this->imagesCount 		= count( $this->imagesIDs );
				$this->previewImage		= wp_get_attachment_image_src( $this->imagesIDs[$this->imagesCount-1], 'full' );
				$this->postID			= $id;
				$this->ID 				= $id . '_' . $this->uniqueID();
				$this->navigation 		= $nav;
				$this->width 			= ( $width == '' ) ? $this->previewImage[1] : $width;
				$this->widthOrigianl 	= $this->previewImage[1];
				$this->heightOrigianl 	= $this->previewImage[2];
				$this->style 			= $style;
				$this->color 			= $color;
				$this->drag				= $drag;
				$this->border			= $border;
				$this->scrollbar		= $scrollbar;
				$this->scrollbar_start	= $scrollbar_start;
				$this->interval			= $interval;
				$this->autoplay			= $autoplay;
				$this->fullscreen 		= $fullscreen;
				$this->moveOnScroll 	= $move_on_scroll;
				$this->moveOnHover 		= $move_on_hover;
				$this->stopOnHover 		= $stop_on_hover;
				$this->direction 		= ($direction==="rtl") ? $direction : "ltr";
				$this->speedMultiplier	= $sensitivity;
				$this->monitorInt		= ($sensitivity<1) ? 10/$sensitivity : 10;
				
				if ( $this->useScrollbar() ) {
					$this->drag			= 'false';
					$this->navigation 	= 'false';
					$this->autoplay 	= 'false';
				}

				$this->imagesURLs 	= $this->_idsToURLs();

			}
			
		}
		
		function show() {
			
			if ( $this->imagesCount > 1 ) 
				require 'views/slider.php';
			
		}
		
		
		/**
		 * Retrive all images URls by their attachment ids
		 * 
		 * @return array
		 */
		
		private function _idsToURLs() {
			
			if ( $this->width > 640 )
				$size = 'full';
			elseif ( $this->width > 300 )
				$size = 'large';
			else
				$size = 'medium';
			
			if ( $this->fullscreen )
				$size = 'full';

			if ( $this->imagesCount > 1 )
				foreach ( $this->imagesIDs as $id ) {
					$url = wp_get_attachment_image_src( $id, $size );
					if ( $url ) $urls[] = $url[0];
				}
			
			return $urls;
		}
		
		/**
		 * Echo JS array with all images URLs
		 * 
		 */
		
		public function imagesJSArray() {
		
			echo "['" . implode( $this->imagesURLs,"','") . "']";
		}
		
		
		/**
		 * Get slider images count
		 * 
		 * @return int
		 */
		
		public function getImagesCount() {
			
			return $this->imagesCount;
			
		}
		
		
		/**
		 * Echo slider ID
		 * 
		 */
		
		public function ID() {
			
			echo $this->ID;
		}
		
		
		/**
		 * Echo slider classes, needed for styling
		 * 
		 */
		
		public function classes() {
			
			$classes[] = 'threesixty-' . $this->color;
			$classes[] = 'threesixty-' . $this->style;

			if ( $this->border == 'false' ) 	$classes[] = 'threesixty-no-border';
			if ( $this->scrollbar == 'top' ) 	$classes[] = 'threesixty-scrollbar-top';
			if ( $this->scrollbar == 'bottom' ) $classes[] = 'threesixty-scrollbar-bottom';
			if ( $this->scrollbar == 'left' ) 	$classes[] = 'threesixty-scrollbar-left';
			if ( $this->scrollbar == 'right' ) 	$classes[] = 'threesixty-scrollbar-right';
			
			echo implode($classes, " ");
		}

		/**
		 * Generate unique ID for multpile sliders on one page
		 * 
		 */
		
		private function uniqueID( $length = 6 ) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		/**
		 * Show preview image
		 * 
		 */
		
		private function previewImage() {

			echo "<img class=\"threesixty-preview-image\" src=\"".$this->imagesURLs[$this->imagesCount - 1]."\"/>";
		}

		/**
		 * Check if scrollbar enabled
		 * 
		 */

		public function useScrollbar() {
			if ( $this->scrollbar == 'top' || $this->scrollbar == 'bottom' || $this->scrollbar == 'left' || $this->scrollbar == 'right' ) return true;
			else return false;
		}

		/**
		 * Check if vertical scrollbar
		 * 
		 */

		public function verticalScrollbar() {
			if ( $this->scrollbar == 'left' || $this->scrollbar == 'right' ) return true;
			else return false;
		}
	}

}

?>