<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;

/**
 * Product Grid widget.
 *
 * @since      4.0.11
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor/General
 */
class Product_Carousel extends \Elementor\Widget_Base {
	
	use Elementor;
	
	public static $instance = null;
	
	/**
	 * Get widget name.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'etheme_product_carousel';
	}
	
	/**
	 * Get widget title.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Products Carousel', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-products-carousel';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'product', 'category', 'categories', 'grid', 'list', 'woocommerce', 'query', 'carousel', 'slider' ];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['eight_theme_general'];
	}
	
	/**
	 * Get widget dependency.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return array Widget dependency.
	 */
	public function get_style_depends() {
	    $styles = [];
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$styles[] = 'etheme-elementor-product-grid';
		    $styles[] = 'etheme-elementor-product-list';
			$styles[] = 'etheme-elementor-countdown';
		}
		return $styles;
	}
	
	/**
	 * Get widget dependency.
	 *
	 * @since 4.0.11
	 * @access public
	 *
	 * @return array Widget dependency.
	 */
	public function get_script_depends() {
		$scripts = ['etheme_elementor_slider'];
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$scripts[] = 'etheme_post_product';
			$scripts[] = 'etheme_countdown';
		}
		return $scripts;
	}
	
	/**
	 * Help link.
	 *
	 * @since 4.1.5
	 *
	 * @return string
	 */
	public function get_custom_help_url() {
		return 'https://xstore.helpscoutdocs.com/article/122-elementor-live-copy-option/';
	}
	
	/**
	 * Register Product Grid controls.
	 *
	 * @since 4.0.11
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'type',
			[
				'label' 		=>	__( 'Type', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'grid' => esc_html__( 'Grid', 'xstore-core' ),
					'list' => esc_html__( 'List', 'xstore-core' ),
				],
				'default'	=> 'grid',
			]
		);
		
		$this->add_control(
			'query_type',
			[
				'label' 		=>	__( 'Data Source', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'all' => esc_html__( 'All Products', 'xstore-core' ),
					'featured' => esc_html__( 'Featured Products', 'xstore-core' ),
					'onsale' => esc_html__( 'On-sale Products', 'xstore-core' ),
					'product_ids' => esc_html__( 'List of IDs', 'xstore-core' ),
				],
				'default'	=> 'all'
			]
		);
		
		$this->add_control(
			'limit',
			[
				'label'      => esc_html__( 'Products Limit', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'max' => 200,
				'step' => 1,
				'default' => 6,
				'condition'  => [
					'query_type!' => [ 'product_ids' ],
				],
			]
		);
		
		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'description' => __('Number of post to displace or pass over.', 'xstore-core') .
				                 ' <a href="https://developer.wordpress.org/reference/classes/wp_query/#pagination-parameters#:~:text=offset%20(int)%20%E2%80%93%20number%20of%20post%20to%20displace%20or%20pass%20over" rel="nofollow" target="_blank">' .
				                 __('More info', 'xstore-core') .
				                 '</a>',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'condition'   => [
					'query_type!' => 'product_ids',
					'orderby!' => 'rand',
				],
			]
		);
		
		$this->add_control(
			'include_products',
			[
				'label'       => esc_html__( 'Include Only', 'xstore-core' ),
				'description' => esc_html__( 'Add products by title.', 'xstore-core' ),
				'label_block' 	=> true,
				'type' 			=> 'etheme-ajax-product',
				'multiple' 		=> true,
				'placeholder' 	=> esc_html__('Enter List of Products', 'xstore-core'),
				'data_options' 	=> [
					'post_type' => array( 'product_variation', 'product' ),
				],
				'condition'   => [
					'query_type' => 'product_ids',
				],
			]
		);
		
		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'xstore-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => array(
					'date'  => esc_html__( 'Date', 'xstore-core' ),
					'rand'  => esc_html__( 'Random Order', 'xstore-core' ),
					'price' => esc_html__( 'Price', 'xstore-core' ),
					'menu_order' => esc_html__( 'Menu Order', 'xstore-core' ),
					'sales' => esc_html__( 'Sales', 'xstore-core' ),
				),
				'condition' => [
					'query_type!' => 'product_ids',
				],
			]
		);
		
		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Sort Order', 'xstore-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'ASC',
				'options'   => array(
					'DESC' => esc_html__( 'Descending', 'xstore-core' ),
					'ASC'  => esc_html__( 'Ascending', 'xstore-core' ),
				),
				'condition' => [
					'query_type!' => 'product_ids',
				],
			]
		);
		
		$product_taxonomies = self::product_taxonomies_to_filter();
		
		$this->add_control(
			'taxonomy_type',
			[
				'label' 		=>	__( 'Taxonomy Type', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	$product_taxonomies,
				'default'		=> array_key_exists('product_cat', $product_taxonomies) ? 'product_cat' : array_key_first($product_taxonomies),
				'condition'   => [
					'query_type!' => 'product_ids',
				],
			]
		);
		
		foreach ($product_taxonomies as $product_taxonomy_key => $product_taxonomy_label) {
			$this->add_control(
				$product_taxonomy_key == 'product_cat' ? 'ids' : $product_taxonomy_key.'s', // make is multiple
				[
					'label' 		=>	$product_taxonomy_label,
					'type' 			=>	\Elementor\Controls_Manager::SELECT2,
//					'description'   =>  esc_html__( 'Enter categories.', 'xstore-core' ),
					'label_block'	=> 'true',
					'multiple' 	=>	true,
					'options' 		=> Elementor::get_terms($product_taxonomy_key, false, false),
					'condition'   => [
						'query_type!' => 'product_ids',
						'taxonomy_type' => $product_taxonomy_key
					],
				]
			);
		}
		
		$this->add_control(
			'hide_free',
			[
				'label'        => esc_html__( 'Hide Free Products', 'xstore-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
                'separator' => 'before'
			]
		);
		
		$this->add_control(
			'hide_out_of_stock',
			[
				'label'        => esc_html__( 'Hide Out Of Stock', 'xstore-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		
		$this->add_control(
			'show_hidden',
			[
				'label'        => esc_html__( 'Show Hidden Products', 'xstore-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		
		$this->end_controls_section();
		
		// slider global settings
		Elementor::get_slider_general_settings($this);
		
		$this->update_control( 'section_slider', [
			'label' => esc_html__('Carousel', 'xstore-core'),
		] );
		
		$this->update_control( 'slides_per_view', [
			'default' => 4,
			'tablet_default' => 3,
			'mobile_default' => 2,
		] );
		
		$this->start_controls_section(
			'section_product_settings',
			[
				'label' => esc_html__( 'Product', 'xstore-core' ),
			]
		);
		
		$product_elements = self::get_product_elements();
		
		foreach ($product_elements as $key => $value) {
			
			if ( $key == 'countdown' ) continue; // moved in separate tab
   
			$this->add_control(
				'product_'.$key,
				[
					'label'        => $value,
					'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'default' => in_array($key, array('image', 'title', 'rating', 'price', 'categories')) ? 'yes' : ''
				]
			);
			
			// injection of some options for specific keys
			switch ($key) {
                case 'image':
                    // make as filter for image
                    $this->add_group_control(
                        \Elementor\Group_Control_Image_Size::get_type(),
                        [
                            'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                            'default' => 'woocommerce_thumbnail',
                            'separator' => 'none',
                            'condition' => [
                                'product_image!' => ''
                            ]
                        ]
                    );
	
	                $this->add_control(
		                'product_sale_label',
		                [
			                'label'        => esc_html__('Show Sale Label', 'xstore-core'),
			                'type'         => \Elementor\Controls_Manager::SWITCHER,
			                'condition' => [
				                'product_image!' => ''
			                ]
		                ]
	                );
    
                    $this->add_control(
                        'img_size_custom',
                        [
                            'label'       => esc_html__( 'Image Dimension', 'xstore-core' ),
                            'type'        => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                            'description' => esc_html__( 'You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'xstore-core' ),
                            'condition'   => [
                                'product_image!' => '',
                                'images_size' => 'custom',
                            ],
                        ]
                    );
    
                    $this->add_control(
                        'img_size_divider',
                        [
                            'type' => \Elementor\Controls_Manager::DIVIDER,
                            'condition' => [
                                'product_image!' => ''
                            ]
                        ]
                    );
                    break;
                case 'title':
                case 'excerpt':
	                $this->add_control(
		                'product_'.$key.'_limit_type',
		                [
			                'label'       => esc_html__( 'Limit By', 'xstore-core' ),
			                'type' => \Elementor\Controls_Manager::SELECT,
			                'options' => [
				                'chars' => esc_html__('Chars', 'xstore-core'),
				                'words' => esc_html__('Words', 'xstore-core'),
                                'lines' => esc_html__('Lines', 'xstore-core'),
                                'none' => esc_html__('None', 'xstore-core'),
			                ],
			                'default' => 'none',
			                'condition' => [
				                'product_'.$key.'!' => ''
			                ]
		                ]
	                );
	
	                $this->add_control(
		                'product_'.$key.'_limit',
		                [
			                'label'      => esc_html__( 'Limit', 'xstore-core' ),
			                'type'       => \Elementor\Controls_Manager::NUMBER,
			                'min' => 0,
			                'max' => 200,
			                'step' => 1,
			                'condition' => [
				                'product_'.$key.'!' => '',
                                'product_'.$key.'_limit_type' => ['chars', 'words']
			                ]
		                ]
	                );
	                
	                $selector = '{{WRAPPER}} .etheme-product-grid-content .etheme-product-grid-title a';
	                if ( $key == 'excerpt' )
		                $selector = '{{WRAPPER}} .etheme-product-grid-content .woocommerce-product-details__short-description';
	
	                $this->add_control(
		                'product_'.$key.'_lines_limit',
		                [
			                'label'      => esc_html__( 'Lines Limit', 'xstore-core' ),
			                'description' => esc_html__( 'Line-height will not work with this option. Don\'t set it up in typography settings.', 'xstore-core' ),
			                'type'       => \Elementor\Controls_Manager::NUMBER,
			                'min' => 1,
			                'max' => 20,
			                'step' => 1,
			                'default' => 2,
			                'condition' => [
				                'product_'.$key.'!' => '',
				                'product_'.$key.'_limit_type' => 'lines'
			                ],
                            'selectors' => [
				                '{{WRAPPER}}' => '--product-'.$key.'-lines: {{VALUE}};',
				                $selector => 'height: calc(var(--product-'.$key.'-lines) * 3ex); line-height: 3ex; overflow: hidden;',
			                ],
		                ]
	                );
	
	                $this->add_control(
		                'product_'.$key.'_divider',
		                [
			                'type' => \Elementor\Controls_Manager::DIVIDER,
			                'condition' => [
				                'product_'.$key.'!' => '',
			                ]
		                ]
	                );
                    break;
				case 'button':
					
					$this->add_control(
						'product_'.$key.'_quantity',
						[
							'label'        => esc_html__('Show Quantity', 'xstore-core'),
							'type'         => \Elementor\Controls_Manager::SWITCHER,
							'condition' => [
								'product_'.$key.'!' => '',
							]
						]
					);
					$this->add_control(
						'product_'.$key.'_icon',
						[
							'label' 		=>	__( 'Icon', 'xstore-core' ),
							'type' 			=>	\Elementor\Controls_Manager::SELECT,
							'options' 		=>	[
								'bag' => esc_html__( 'Shopping Bag', 'xstore-core' ),
								'cart' => esc_html__( 'Shopping Cart', 'xstore-core' ),
								'cart2' => esc_html__( 'Shopping Cart 2', 'xstore-core' ),
								'custom' => esc_html__( 'Custom', 'xstore-core' ),
								'none' => esc_html__( 'None', 'xstore-core' ),
							],
							'default'	=> 'cart',
							'condition' => [
								'product_'.$key.'!' => '',
							]
						]
					);
					
					$this->add_control(
						'product_'.$key.'_icon_align',
						[
							'label' => __( 'Icon Position', 'xstore-core' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'default' => 'left',
							'options' => [
								'left' => __( 'Before', 'xstore-core' ),
								'right' => __( 'After', 'xstore-core' ),
							],
							'condition' => [
								'product_'.$key.'!' => '',
								'product_'.$key.'_quantity' => ''
							],
						]
					);
					
					$this->add_control(
						'product_'.$key.'_custom_selected_icon',
						[
							'label' => __( 'Button Icon', 'xstore-core' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'fa4compatibility' => 'product_'.$key.'_custom_icon',
							'skin' => 'inline',
							'label_block' => false,
							'condition' => [
								'product_'.$key.'!' => '',
								'product_'.$key.'_icon' => 'custom',
							]
						]
					);
					
					$this->add_control(
						'product_'.$key.'_custom_icon_indent',
						[
							'label' => __( 'Icon Spacing', 'xstore-core' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'max' => 50,
								],
							],
							'default' => [
								'size' => 7
							],
							'selectors' => [
								'{{WRAPPER}} .etheme-product-grid-button .button-text:last-child' => 'margin-left: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .etheme-product-grid-button .button-text:first-child' => 'margin-right: {{SIZE}}{{UNIT}};',
							],
							'condition' => [
								'product_'.$key.'!' => '',
								'product_'.$key.'_icon!' => 'none',
								'product_'.$key.'_quantity' => ''
							],
						]
					);
					break;
            }
        }
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_product_hover_settings',
			[
				'label' => esc_html__( 'Hover Effects', 'xstore-core' ),
				'condition'  => [
					'type' => 'grid',
					'product_image!' => ''
				],
			]
		);
		
		$this->add_control(
			'image_hover_effect',
			[
				'label' => __( 'Image Effect', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'separator' => 'after',
				'options' => [
					'none'	=>	esc_html__('None', 'xstore-core'),
					'slider'		=>	esc_html__('Slider', 'xstore-core'),
					'swap'		=>	esc_html__('Swap', 'xstore-core'),
				],
				'default' => 'none',
			]
		);
		
		$this->add_control(
			'hover_effect',
			[
				'label' => __( 'Hover Effect', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default'	=>	esc_html__('Default', 'xstore-core'),
					'mask3'		=>	esc_html__('Buttons on hover middle', 'xstore-core'),
					'mask'		=>	esc_html__('Buttons on hover bottom', 'xstore-core'),
					'mask2'		=>	esc_html__('Buttons on hover right', 'xstore-core'),
					'info'		=>	esc_html__('Information mask', 'xstore-core'),
//					'booking'	=>	esc_html__('Booking', 'xstore-core'),
//					'light'		=>	esc_html__('Light', 'xstore-core'),
					'overlay'   =>  esc_html__('Overlay content on image', 'xstore-core'),
					'disable'	=>	esc_html__('Disable', 'xstore-core'),
				],
				'default' => 'mask3',
			]
		);
		
		$this->add_control(
			'hover_effect_mode',
			[
				'label' => __( 'Hover Effect Mode', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'dark'		=>	esc_html__('Dark', 'xstore-core'),
					'white'		=>	esc_html__('White', 'xstore-core'),
				],
				'default' => 'white',
				'condition' => [
					'hover_effect!' => 'disable'
				]
			]
		);
		
		$this->add_control(
			'product_hover_effect_top_area_heading',
			[
				'label' => esc_html__( 'Top Hover Area', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'hover_effect' => 'info'
				]
			]
		);
		
		
		foreach (self::get_product_hover_elements() as $key => $value) {
			if ( in_array($key, array( 'categories', 'title', 'rating', 'price', 'excerpt', 'sku' ) ) ) {
				$this->add_control(
					'product_hover_' . $key,
					[
						'label'   => $value,
						'type'    => \Elementor\Controls_Manager::SWITCHER,
						'default' => in_array( $key, array( 'title', 'price' ) ) ? 'yes' : '',
						'condition' => [
							'hover_effect' => ['info', 'overlay'],
						]
					]
				);
			}
			else {
				if ( $key == 'button' ) {
					$this->add_control(
						'product_hover_effect_top_area_divider',
						[
							'type' => \Elementor\Controls_Manager::DIVIDER,
							'condition' => [
								'hover_effect' => ['info', 'overlay'],
							]
						]
					);
				}
				$this->add_control(
					'product_hover_' . $key,
					[
						'label'   => $value,
						'type'    => \Elementor\Controls_Manager::SWITCHER,
						'default' => in_array( $key, array( 'button', 'quick_view', 'wishlist_button' ) ) ? 'yes' : ''
					]
				);
			}
			switch ( $key ) {
				case 'button':
					$this->add_control(
						'product_hover_' . $key . '_icon',
						[
							'label'     => __( 'Icon', 'xstore-core' ),
							'type'      => \Elementor\Controls_Manager::SELECT,
							'options'   => [
								'bag'    => esc_html__( 'Shopping Bag', 'xstore-core' ),
								'cart'   => esc_html__( 'Shopping Cart', 'xstore-core' ),
								'cart2'  => esc_html__( 'Shopping Cart 2', 'xstore-core' ),
								'custom' => esc_html__( 'Custom', 'xstore-core' ),
							],
							'default'   => 'cart',
							'condition' => [
								'hover_effect!' => 'disable',
								'product_hover_' . $key . '!' => '',
							]
						]
					);
					
					$this->add_control(
						'product_hover_' . $key . '_custom_selected_icon',
						[
							'label'            => __( 'Button Icon', 'xstore-core' ),
							'type'             => \Elementor\Controls_Manager::ICONS,
							'fa4compatibility' => 'product_hover_'.$key.'_custom_icon',
							'skin'             => 'inline',
							'label_block'      => false,
							'condition'        => [
								'hover_effect!' => 'disable',
								'product_hover_' . $key . '!'     => '',
								'product_hover_' . $key . '_icon' => 'custom',
							]
						]
					);
					break;
				case 'title':
				case 'excerpt':
					$this->add_control(
						'product_hover_'.$key.'_limit_type',
						[
							'label'       => esc_html__( 'Limit By', 'xstore-core' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => [
								'chars' => esc_html__('Chars', 'xstore-core'),
								'words' => esc_html__('Words', 'xstore-core'),
								'lines' => esc_html__('Lines', 'xstore-core'),
								'none' => esc_html__('None', 'xstore-core'),
							],
							'default' => 'lines',
							'condition' => [
								'product_hover_'.$key.'!' => '',
								'hover_effect' => ['info', 'overlay'],
							]
						]
					);
					
					$this->add_control(
						'product_hover_'.$key.'_limit',
						[
							'label'      => esc_html__( 'Limit', 'xstore-core' ),
							'type'       => \Elementor\Controls_Manager::NUMBER,
							'min' => 0,
							'max' => 200,
							'step' => 1,
							'default' => $key == 'title' ? '' : 12,
							'condition' => [
								'product_hover_'.$key.'!' => '',
								'hover_effect' => ['info', 'overlay'],
								'product_hover_'.$key.'_limit_type' => ['chars', 'words']
							]
						]
					);
					
					$selector = '{{WRAPPER}} footer .etheme-product-grid-title a';
					if ( $key == 'excerpt' )
						$selector = '{{WRAPPER}} footer .woocommerce-product-details__short-description';
					
					$this->add_control(
						'product_hover_'.$key.'_lines_limit',
						[
							'label'      => esc_html__( 'Lines Limit', 'xstore-core' ),
							'description' => esc_html__( 'Line-height will not work with this option. Don\'t set it up in typography settings.', 'xstore-core' ),
							'type'       => \Elementor\Controls_Manager::NUMBER,
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 2,
							'condition' => [
								'product_hover_'.$key.'!' => '',
								'hover_effect' => ['info', 'overlay'],
								'product_hover_'.$key.'_limit_type' => 'lines'
							],
							'selectors' => [
								'{{WRAPPER}}' => '--product-'.$key.'-lines: {{VALUE}};',
								$selector => 'height: calc(var(--product-'.$key.'-lines) * 3ex); line-height: 3ex; overflow: hidden;',
							],
						]
					);
					
					break;
			}
		}
		
		$this->end_controls_section();
		
		// slider style settings
		Elementor::get_slider_style_settings($this);
		
		$this->update_control( 'section_style_slider', [
			'label' => esc_html__('Carousel', 'xstore-core'),
		] );
		
		$this->remove_control('slider_vertical_align');
		
		$this->start_controls_section(
			'section_product_style',
			[
				'label' => __( 'Product', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'alignment',
			[
				'label' 		=>	__( 'Alignment', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-item' => 'text-align: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'image_column_width',
			[
				'label' => __( 'Columns Proportion', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
                    'unit' => '%'
                ],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 70,
						'step' => 1,
					],
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition' => [
                    'type' => 'list',
                    'product_image!' => ''
                ],
				'selectors' => [
					'{{WRAPPER}}' => '--image-width-proportion: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .etheme-product-grid-item'
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__('Border', 'xstore-core'),
				'selector' => '{{WRAPPER}} .etheme-product-grid-item',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .etheme-product-grid-item',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);
		
		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__('Padding', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_categories_style',
			[
				'label' => __( 'Categories', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_categories!' => ''
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'categories_typography',
				'selector' => '{{WRAPPER}} .etheme-product-grid-categories',
			]
		);
		
		$this->start_controls_tabs('tabs_categories_colors');
		
		$this->start_controls_tab( 'tabs_categories_color_normal',
			[
				'label' => esc_html__('Normal', 'xstore-core')
			]
		);
		
		$this->add_control(
			'categories_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-categories' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'tabs_categories_color_hover',
			[
				'label' => esc_html__('Hover', 'xstore-core')
			]
		);
		
		$this->add_control(
			'categories_color_hover',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-categories a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'categories_space',
			[
				'label' => __( 'Bottom Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-categories' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// title
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_title!' => ''
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .etheme-product-grid-title',
			]
		);
		
		$this->start_controls_tabs('tabs_title_colors');
		
		$this->start_controls_tab( 'tabs_title_color_normal',
			[
				'label' => esc_html__('Normal', 'xstore-core')
			]
		);
		
		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-title a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'tabs_title_color_hover',
			[
				'label' => esc_html__('Hover', 'xstore-core')
			]
		);
		
		$this->add_control(
			'title_color_hover',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'title_space',
			[
				'label' => __( 'Bottom Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// image
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => __( 'Image', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_image!' => ''
				],
			]
		);
		
		$this->add_control(
			'image_stretch',
			[
				'label' => __('Stretch Images', 'xstore-core'),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
//				'condition' => [
//					'type' => 'grid',
//				],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-image img' => 'width: 100%;',
				],
			]
		);
		
		$this->add_control(
			'image_scale',
			[
				'label' => __( 'Image Scale', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => .1
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--image-scale: {{SIZE}};',
				],
			]
		);
		
		$this->add_control(
			'image_object_position_x',
			[
				'label' => __( 'Image Position X', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px'
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--image-position-x: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'image_object_position_y',
			[
				'label' => __( 'Image Position Y', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px'
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--image-position-y: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} .etheme-product-grid-image img',
			]
		);
		
		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'image_space',
			[
				'label' => __( 'Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 70,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-image img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// rating
		$this->start_controls_section(
			'section_rating_style',
			[
				'label' => __( 'Rating', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_rating!' => ''
				],
			]
		);
		
		$this->add_control(
			'rating_space',
			[
				'label' => __( 'Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 70,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .star-rating-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// sku
		$this->start_controls_section(
			'section_sku_style',
			[
				'label' => __( 'SKU', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_sku!' => ''
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'sku_typography',
				'selector' => '{{WRAPPER}} .sku_wrapper',
			]
		);
		
		$this->start_controls_tabs('tabs_sku_colors');
		
		$this->start_controls_tab( 'tabs_sku_color_normal',
			[
				'label' => esc_html__('Regular', 'xstore-core')
			]
		);
		
		$this->add_control(
			'sku_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sku_wrapper' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'tabs_categories_color_number',
			[
				'label' => esc_html__('Number', 'xstore-core')
			]
		);
		
		$this->add_control(
			'sku_color_number',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sku' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'sku_space',
			[
				'label' => __( 'Bottom Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sku_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// excerpt
		$this->start_controls_section(
			'section_excerpt_style',
			[
				'label' => __( 'Excerpt', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_excerpt!' => ''
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .woocommerce-product-details__short-description',
			]
		);
		
		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'excerpt_space',
			[
				'label' => __( 'Bottom Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-details__short-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// price
		$this->start_controls_section(
			'section_price_style',
			[
				'label' => __( 'Price', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_price!' => ''
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .price',
			]
		);
		
		$this->start_controls_tabs('tabs_price_colors');
		
		$this->start_controls_tab( 'tabs_price_color_normal',
			[
				'label' => esc_html__('Normal', 'xstore-core')
			]
		);
		
		$this->add_control(
			'price_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'tabs_sale_price_color',
			[
				'label' => esc_html__('Sale', 'xstore-core')
			]
		);
		
		$this->add_control(
			'sale_price_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ins .amount' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'price_space',
			[
				'label' => __( 'Space', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 70,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		// button
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'xstore-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'product_button!' => ''
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .etheme-product-grid-button',
			]
		);
		
		$this->start_controls_tabs( 'tabs_button_style' );
		
		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'label' => esc_html__( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-product-grid-button',
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-button:hover, {{WRAPPER}} .etheme-product-grid-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .etheme-product-grid-button:hover svg, {{WRAPPER}} .etheme-product-grid-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'label' => esc_html__( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-product-grid-button:hover, {{WRAPPER}} .etheme-product-grid-button:focus',
			]
		);
		
		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-button:hover, {{WRAPPER}} .etheme-product-grid-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .etheme-product-grid-button',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .etheme-product-grid-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->end_controls_section();
		
		if (array_key_exists('countdown', $product_elements) ) {
			// countdown
			Elementor::get_countdown_settings($this, [
				'product_countdown!' => ''
			]);
			
			$this->start_injection( [
				'type' => 'control',
				'at'   => 'before',
				'of'   => 'countdown_stretch_items',
			] );
			
			$this->add_control(
				'product_countdown',
				[
					'label' => $product_elements['countdown'],
					'type'  => \Elementor\Controls_Manager::SWITCHER,
					'separator' => 'after'
				]
			);
			
			$this->end_injection();
			
			$this->remove_control('countdown_label_position');
			
			$this->update_control( 'countdown_border_border', [
				'default' => 'solid',
			] );
			
			$this->update_control( 'countdown_border_width', [
				'default' => [
					'top'    => 1,
					'left'   => 1,
					'right'  => 1,
					'bottom' => 1
				]
			] );
			
			$this->update_control( 'countdown_border_color', [
				'default' => '#e1e1e1',
			] );
			
			$this->update_control( 'countdown_border_radius', [
				'default' => [
					'top'    => 5,
					'right'  => 5,
					'bottom' => 5,
					'left'   => 5,
				]
			] );
			
			$this->update_control( 'countdown_background_background', [
				'default' => 'classic'
			] );
			
			$this->update_control( 'countdown_background_color', [
				'default' => '#ffffff'
			] );
			
			$this->update_control( 'digits_color', [
				'default' => '#222222'
			] );
			
			$this->update_control( 'label_color', [
				'default' => '#222222'
			] );
			
			$this->update_control( 'delimiter_color', [
				'default' => '#222222'
			] );
			
		}
		
	}
	
	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 4.0.11
	 * @access protected
	 */
	protected function render() {
	    
	    if ( !class_exists('WooCommerce') ) {
	        echo esc_html__('Install WooCommerce Plugin to use this widget', 'xstore-core');
	        return;
        }
		
		$settings = $this->get_settings_for_display();
		$offset = $settings['offset'] && $settings['offset'] > 0 ? $settings['offset'] : 0;
		
		$edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
		
		$this->add_render_attribute( 'wrapper', [
			'class' => [
				'etheme-elementor-swiper-entry',
				'swiper-entry',
				$settings['arrows_position'],
				$settings['arrows_position_style']
			]
		]);
		
		$this->add_render_attribute( 'wrapper-inner',
			[
				'class' =>
					[
						'swiper-container',
						'etheme-elementor-slider',
					]
			]
		);
		
		$this->add_render_attribute( 'testimonials-wrapper', 'class', 'swiper-wrapper');
		
		if ( $settings['image_hover_effect'] == 'slider' )
			wp_enqueue_script( 'etheme_post_product' );
		
        // loop start classes, html tag filter
        add_filter('woocommerce_product_loop_start', array($this, 'product_loop_start_filter'), 10, 1);
        
            $products = self::get_query( $settings );
//            wc_set_loop_prop( 'columns', $settings['cols'] );
//            wc_set_loop_prop( 'etheme_elementor_product_widget', true );
//            wc_set_loop_prop( 'is_shortcode', true );
            global $local_settings;
            $local_settings = $settings;
            if ( $products && $products->have_posts() ) {
                
                ?>
                <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
                    <div <?php $this->print_render_attribute_string( 'wrapper-inner' ); ?>>
                        <div <?php $this->print_render_attribute_string( 'testimonials-wrapper' ); ?>>
                            <?php
                            
//                            woocommerce_product_loop_start();
                
                            while ( $products->have_posts() ) {
                                $products->the_post();
	                            global $product;
	
	                            // Ensure visibility.
	                            if ( empty( $product ) || ! $product->is_visible() )
		                            continue;
	                            
                                echo '<div class="swiper-slide">';
                                    $this->get_content_product($local_settings);
                                echo '</div>';
                            }
                
//                            woocommerce_product_loop_end();
                            
                            ?>
                        </div>
                        
                        <?php
//                                    if ( 1 < count($products) ) {
                                if ( in_array($settings['navigation'], array('both', 'dots')) )
                                    Elementor::get_slider_pagination($this, $settings, $edit_mode);

//                                    }
                        ?>
                    </div>
                    <?php
//                                if ( $settings['type'] == 'slider' && 1 < count($settings['testimonials_tab']) ) :
    
                            if ( in_array($settings['navigation'], array('both', 'arrows')) )
                                Elementor::get_slider_navigation($settings, $edit_mode);

//                                endif;
                    ?>
                </div>
                    <?php
            }

            else {
                echo '<div class="elementor-panel-alert elementor-panel-alert-warning">'.
                     esc_html__('No products were found matching your selection.', 'xstore-core') .
                     '</div>';
            }
            
//            wc_reset_loop();
            wp_reset_postdata();
		
		remove_filter('woocommerce_product_loop_start', array($this, 'product_loop_start_filter'), 10, 1);
		
    
    }
	
	/**
	 * Get query for render products.
	 *
	 * @param $settings
	 * @return \WP_Query
	 *
	 * @since 1.0.0
	 *
	 */
    public static function get_query($settings, $extra_params = array()) {
	    $query_args = array(
		    'posts_per_page' => $settings['limit'],
		    'post_status'    => 'publish',
		    'post_type'      => 'product',
		    'paged' => 1,
		    'no_found_rows'  => 1,
		    'order'          => $settings['order'],
		    'meta_query'     => array(),
		    'tax_query'      => array(
			    'relation' => 'AND',
		    ),
	    ); // WPCS: slow query ok.
	
	    if ( $settings['query_type'] != 'product_ids') {
		    if ( $settings['offset'] && $settings['offset'] > 0 ) {
			    // it is for non-ajax pagination cases
                $query_args['offset'] = $settings['offset'];
		    }
	    }
	    
	    $query_args = wp_parse_args( $extra_params, $query_args );
	
	    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
	
	    if ( empty( $settings['show_hidden'] ) ) {
		    $query_args['tax_query'][] = array(
			    'taxonomy' => 'product_visibility',
			    'field'    => 'term_taxonomy_id',
			    'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
			    'operator' => 'NOT IN',
		    );
//		    $query_args['post_parent'] = 0;
	    }
	
	    if ( ! empty( $settings['hide_free'] ) ) {
		    $query_args['meta_query'][] = array(
			    'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL',
		    );
	    }
	
//	    if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
	    if ( $settings['hide_out_of_stock'] ) {
		    $query_args['tax_query'][] = array(
			    array(
				    'taxonomy' => 'product_visibility',
				    'field'    => 'term_taxonomy_id',
				    'terms'    => $product_visibility_term_ids['outofstock'],
				    'operator' => 'NOT IN',
			    ),
		    ); // WPCS: slow query ok.
	    }
	
	    switch ( $settings['query_type'] ) {
		    case 'featured':
			    $query_args['tax_query'][] = array(
				    'taxonomy' => 'product_visibility',
				    'field'    => 'term_taxonomy_id',
				    'terms'    => $product_visibility_term_ids['featured'],
			    );
			    break;
		    case 'onsale':
			    $product_ids_on_sale    = wc_get_product_ids_on_sale();
			    $product_ids_on_sale[]  = 0;
			    $query_args['post__in'] = $product_ids_on_sale;
			    break;
            case 'product_ids':
                // backup value for limit if not products are set
	            $query_args['posts_per_page'] = 8;
                if ( count($settings['include_products']) ) {
	                $query_args['post_type'] = array_merge((array)$query_args['post_type'], array('product_variation'));
	                $query_args['post__in']       = $settings['include_products'];
	                $query_args['orderby']        = 'post__in';
	                $query_args['posts_per_page'] = - 1;
                }
                break;
	    }
	
	    switch ( $settings['orderby'] ) {
		    case 'price':
			    $query_args['meta_key'] = '_price'; // WPCS: slow query ok.
			    $query_args['orderby']  = 'meta_value_num';
			    break;
		    case 'rand':
		    case 'menu_order':
			    $query_args['orderby'] = $settings['orderby'];
			    break;
		    case 'sales':
			    $query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
			    $query_args['orderby']  = 'meta_value_num';
			    break;
		    default:
		        if ( $settings['query_type'] != 'product_ids')
			        $query_args['orderby'] = 'date';
	    }
	
	    if ( $settings['query_type'] != 'product_ids') {
		    switch ( $settings['taxonomy_type'] ) {
			    case 'product_cat':
				    if ( $settings['ids'] ) {
					    $query_args['tax_query'][] = array(
						    'taxonomy' => 'product_cat',
						    'field'    => 'id',
						    'terms'    => $settings['ids'],
					    );
				    }
				    break;
			    default:
				    if ( $settings[ $settings['taxonomy_type'] . 's' ] ) {
					    $query_args['tax_query'][] = array(
						    'taxonomy' => $settings['taxonomy_type'],
						    'field'    => 'id',
						    'terms'    => $settings[ $settings['taxonomy_type'] . 's' ],
					    );
				    }
				    break;
		    }
	    }
	
	    return new \WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
    }
	
	/**
	 * Filter loop start html for compatibility with 3d-party plugins.
	 *
	 * @param $html
	 * @return string|string[]
	 *
	 * @since 4.0.11
	 *
	 */
    public function product_loop_start_filter($html) {
        $class = 'etheme-product-grid type-slider ';
	    $html = str_replace('class="', 'class="'.$class.' ', $html);
	    $html = str_replace('<ul', '<div', $html);
	    return $html;
    }
	
	/**
	 * Filter loop end html for compatibility with 3d-party plugins.
	 *
	 * @param $html
	 * @return string|string[]
	 *
	 * @since 4.0.11
	 *
	 */
	public function product_loop_end_filter($html) {
		return str_replace('</ul', '</div', $html);
	}
	
	/**
	 * Get content of product.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_content_product($settings) {
	    global $local_settings;
		$local_settings = $settings;
//		$link_open = has_filter('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
//		$link_closed = has_filter('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close');
//
//		if ( $link_open )
//			remove_filter('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', $link_open);
//		if ( $link_closed )
//			remove_filter('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', $link_closed);
//
//		// filter image size
		if ( $local_settings['image_size'] != 'custom')
			add_filter('single_product_archive_thumbnail_size', array($this, 'image_prerendered_size_filter'), 10);
		else
			add_filter('woocommerce_product_get_image', array($this, 'filter_image_custom_size'), 10, 5);
		
		// add custom class for title
		add_filter('woocommerce_product_loop_title_classes', array($this, 'add_class_for_title'), 10);
		
		add_filter('etheme_static_block_prevent_setup_post', '__return_true');
		
		global $product;
		
		// Ensure visibility.
        // checked above before .swiper-slide wrapper
//		if ( empty( $product ) || ! $product->is_visible() )
//			return;
		
		$class = 'etheme-product-grid-item';
		if ( $local_settings['type'] == 'list' ) {
		    $class .= ' type-list';
		}
		if ( $local_settings['hover_effect'] != 'disable' ) {
			$class .= ' etheme-product-hover-' . $local_settings['hover_effect'];
			$class .= ' etheme-product-hover-mode-'.$local_settings['hover_effect_mode'];
		}
		
		if ($local_settings['image_hover_effect'] != 'none') {
			$class .= ' etheme-product-image-hover-' . $local_settings['image_hover_effect'];
		}
		
		// for frontend
        wp_enqueue_style('etheme-elementor-product-'.$local_settings['type']);
		
		$edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
        
		?>
        
        <div <?php wc_product_class( $class, $product ); ?><?php if ($local_settings['image_hover_effect'] == 'slider') :
	        echo 'data-images="'.$this->etheme_get_image_list($product).'"';
        endif; ?>>
        
        <?php
        $local_content = array();
		foreach (self::get_product_elements() as $key => $string_text) {
		    
            if ( !isset($local_settings['product_'.$key]) || !$local_settings['product_'.$key]) continue;
		    switch ($key) {
                case 'image':
                    ob_start();
                    if ( $local_settings['product_sale_label'])
                        woocommerce_show_product_loop_sale_flash();
                    woocommerce_template_loop_product_thumbnail();
	                $local_content[$key] = ob_get_clean();
                    break;
                case 'categories':
                    ob_start();
                    $this->get_product_categories();
	                $local_content[$key] = ob_get_clean();
                    break;
                case 'title':
                    ob_start();
                    if ( $local_settings['product_title_limit_type'] != 'none' )
                        add_filter('the_title', array($this, 'limit_title_string'), 10);
	                add_filter('the_title', array($this, 'add_link_for_title'), 10, 2);
	                
                    woocommerce_template_loop_product_title();
	
	                /* @use for etheme_get_fake_product_sales_count() */
	                // not working if ajaxify
	                do_action('after_etheme_product_grid_list_product_element_'.$key);
                    
	                remove_filter('the_title', array($this, 'add_link_for_title'), 10, 2);
	                if ( $local_settings['product_title_limit_type'] != 'none' )
	                    remove_filter('the_title', array($this, 'limit_title_string'), 10);
	                
	                $local_content[$key] = ob_get_clean();
                    break;
                case 'price':
                    ob_start();
	                woocommerce_template_loop_price();
	                $local_content[$key] = ob_get_clean();
                    break;
                case 'rating':
                    ob_start();
                    echo '<div class="star-rating-wrapper">';
	                woocommerce_template_loop_rating();
	                echo '</div>';
	                $local_content[$key] = ob_get_clean();
	                break;
			    case 'button':
				    ob_start();
				    $product_type_quantity_types = apply_filters('etheme_product_type_show_quantity', array('simple', 'variable', 'variation'));
				    if ( $local_settings['product_button_quantity'] && in_array($product->get_type(), $product_type_quantity_types) ) {
					    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
					    add_filter('woocommerce_product_add_to_cart_text', '__return_false');
					    remove_action( 'woocommerce_before_quantity_input_field', 'et_quantity_minus_icon' );
					    remove_action( 'woocommerce_after_quantity_input_field', 'et_quantity_plus_icon' );
					    add_action( 'woocommerce_before_quantity_input_field', array($this, 'quantity_minus_icon') );
					    add_action( 'woocommerce_after_quantity_input_field', array($this, 'quantity_plus_icon') );
					    add_filter('esc_html', array($this, 'escape_text'), 10, 2);
					    add_filter('woocommerce_loop_add_to_cart_args', array($this, 'add_class_for_button'), 10, 1);
					    add_filter('woocommerce_product_add_to_cart_text', array($this, 'add_to_cart_icon'), 10);
					    echo '<div class="quantity-wrapper">';
					    woocommerce_quantity_input( array(), $product, true );
					    woocommerce_template_loop_add_to_cart();
					    echo '</div>';
					    remove_filter('woocommerce_product_add_to_cart_text', array($this, 'add_to_cart_icon'), 10);
					    remove_filter('woocommerce_loop_add_to_cart_args', array($this, 'add_class_for_button'), 10, 1);
					    remove_filter('esc_html', array($this, 'escape_text'), 10, 2);
					    remove_action( 'woocommerce_before_quantity_input_field', array($this, 'quantity_minus_icon') );
					    remove_action( 'woocommerce_after_quantity_input_field', array($this, 'quantity_plus_icon') );
					    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
					    remove_filter('woocommerce_product_add_to_cart_text', '__return_false');
				    }
				    else {
					    add_filter('esc_html', array($this, 'escape_text'), 10, 2);
					    add_filter('woocommerce_loop_add_to_cart_args', array($this, 'add_class_for_button'), 10, 1);
					    add_filter('woocommerce_product_add_to_cart_text', array($this, 'add_to_cart_icon'), 10);
					    woocommerce_template_loop_add_to_cart();
					    remove_filter('woocommerce_product_add_to_cart_text', array($this, 'add_to_cart_icon'), 10);
					    remove_filter('woocommerce_loop_add_to_cart_args', array($this, 'add_class_for_button'), 10, 1);
					    remove_filter('esc_html', array($this, 'escape_text'), 10, 2);
				    }
				    $local_content[$key] = ob_get_clean();
				    break;
                case 'excerpt':
                    ob_start();
	                if ( $local_settings['product_excerpt_limit_type'] != 'none' )
		                add_filter('woocommerce_short_description', array($this, 'limit_excerpt_string'), 10);
	                woocommerce_template_single_excerpt();
	                if ( $local_settings['product_excerpt_limit_type'] != 'none' )
		                remove_filter('woocommerce_short_description', array($this, 'limit_excerpt_string'), 10);
	                $local_content[$key] = ob_get_clean();
                    break;
			    case 'sku':
			        ob_start();
				    $this->get_product_sku();
				    $local_content[$key] = ob_get_clean();
				    break;
			    case 'countdown':
				    ob_start();
				    $this->get_countdown($local_settings, $product);
				    $local_content[$key] = ob_get_clean();
				    break;
                default:
                    ob_start();
	                add_filter('woocommerce_loop_add_to_cart_args', array($this, 'add_class_for_button'), 10, 1);
                    do_action('etheme_product_grid_list_product_element_render', $key, $product, $edit_mode, $this);
	                remove_filter('woocommerce_loop_add_to_cart_args', array($this, 'add_class_for_button'), 10, 1);
                    $get_action_content = ob_get_clean();
                    if ( $get_action_content != '')
	                    $local_content[$key] = $get_action_content;
		    }
		}
		if ( isset($local_content['image'])) {
			echo '<div class="etheme-product-grid-image">';
                 echo '<a href="'.$product->get_permalink().'">';
                    echo $local_content['image'];
                    if ( $local_settings['image_hover_effect'] == 'swap' ) {
                        $this->image_hover_swap_image($product);
                    }
                 echo '</a>';
                 if ( $local_settings['hover_effect'] != 'disable' ) {
	
                     $hover_local_content = array();
	                 $hover_local_content_info = array();
	                 foreach (self::get_product_hover_elements() as $key => $string_text) {
		                 if ( !isset($local_settings['product_hover_'.$key]) || !$local_settings['product_hover_'.$key]) continue;
	                    switch ($key) {
                            case 'button':
	                            add_filter('esc_html', array($this, 'escape_text'), 10, 2);
	                            add_filter('woocommerce_product_add_to_cart_text', array($this, 'hover_add_to_cart_icon'), 10);
	                            ob_start();
	                            woocommerce_template_loop_add_to_cart();
	                            $hover_local_content[$key] = ob_get_clean();
	
	                            remove_filter('woocommerce_product_add_to_cart_text', array($this, 'hover_add_to_cart_icon'), 10);
	                            remove_filter('esc_html', array($this, 'escape_text'), 10, 2);
                                break;
                            case 'wishlist_button':
	                            if ( class_exists( 'YITH_WCWL_Shortcode' ) ) {
		                            ob_start();
		                            add_filter('yith_wcwl_button_icon', array($this, 'yith_wishlist_icon'), 20);
		                            echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		                            remove_filter('yith_wcwl_button_icon', array($this, 'yith_wishlist_icon'), 20);
		                            $hover_local_content[$key] = ob_get_clean();
	                            }
                                break;
                            case 'compare_button':
                                if ( class_exists('YITH_Woocompare_Frontend')) {
                                    add_filter('pre_option_yith_woocompare_is_button', '__return_true');
                                    add_filter('pre_option_yith_woocompare_button_text', array($this, 'compare_button_icon'), 10);
                                    ob_start();
                                    echo do_shortcode('[yith_compare_button]');
	                                $hover_local_content[$key] = ob_get_clean();
	                                remove_filter('pre_option_yith_woocompare_is_button', '__return_true');
	                                remove_filter('pre_option_yith_woocompare_button_text', array($this, 'compare_button_icon'), 10);
                                }
                                break;
		                    case 'categories':
			                    ob_start();
			                    $this->get_product_categories();
			                    $hover_local_content_info[$key] = ob_get_clean();
			                    break;
		                    case 'title':
			                    ob_start();
			                    if ( $local_settings['product_hover_title_limit_type'] != 'none' )
				                    add_filter('the_title', array($this, 'limit_hover_title_string'), 10);
			                    add_filter('the_title', array($this, 'add_link_for_title'), 10, 2);
			
			                    woocommerce_template_loop_product_title();
			
			                    remove_filter('the_title', array($this, 'add_link_for_title'), 10, 2);
			                    if ( $local_settings['product_hover_title_limit_type'] != 'none' )
				                    remove_filter('the_title', array($this, 'limit_hover_title_string'), 10);
			
			                    $hover_local_content_info[$key] = ob_get_clean();
			                    break;
		                    case 'price':
			                    ob_start();
			                    woocommerce_template_loop_price();
			                    $hover_local_content_info[$key] = ob_get_clean();
			                    break;
		                    case 'rating':
			                    ob_start();
			                    echo '<div class="star-rating-wrapper">';
			                    woocommerce_template_loop_rating();
			                    echo '</div>';
			                    $hover_local_content_info[$key] = ob_get_clean();
			                    break;
		                    case 'excerpt':
			                    ob_start();
			                    if ( $local_settings['product_hover_excerpt_limit_type'] != 'none' )
				                    add_filter('woocommerce_short_description', array($this, 'limit_hover_excerpt_string'), 10);
			                    woocommerce_template_single_excerpt();
			                    if ( $local_settings['product_hover_excerpt_limit_type'] != 'none' )
				                    remove_filter('woocommerce_short_description', array($this, 'limit_hover_excerpt_string'), 10);
			                    $hover_local_content_info[$key] = ob_get_clean();
			                    break;
		                    case 'sku':
			                    ob_start();
			                    $this->get_product_sku();
			                    $hover_local_content_info[$key] = ob_get_clean();
			                    break;
		                    default:
			                    ob_start();
			                    do_action('etheme_product_grid_list_product_hover_element_render', $key, $product, $edit_mode, $this);
			                    $get_action_content = ob_get_clean();
			                    if ( $get_action_content != '') {
				                    $hover_local_content[ $key ] = $get_action_content;
			                    }
	                    }
	                 }
	
	                 if ( $local_settings['hover_effect'] == 'default' ) {
		                 if ( array_key_exists('quick_view', $hover_local_content) ) {
			                 $hover_local_content_info['quick_view'] = $hover_local_content['quick_view'];
			                 unset($hover_local_content['quick_view']);
		                 }
	                 }
	
	                 $origin_hover_local_content = $hover_local_content;
	                 $hover_local_content = apply_filters('etheme_product_grid_list_product_hover_elements_render', $hover_local_content, $local_settings['hover_effect'], $hover_local_content_info);
	                 $hover_local_content_info = apply_filters('etheme_product_grid_list_product_hover_info_elements_render', $hover_local_content_info, $local_settings['hover_effect'], $origin_hover_local_content);
	                 
	                 if ( count($hover_local_content)) :?>
                         <footer>
                             <?php
                             if ( count($hover_local_content_info) && in_array($local_settings['hover_effect'], array('info', 'overlay', 'default')) )
                                    echo '<div class="top-footer">'.implode('', $hover_local_content_info).'</div>';
                             echo '<div class="footer-inner">'.implode('', $hover_local_content).'</div>'
                             ?>
                         </footer>
                 <?php endif; }
             echo '</div>';
		}
		
		$list_content = $local_content;
		unset($list_content['image']);
		
        if ( count($list_content) ) {
	        echo '<div class="etheme-product-grid-content">' .
	             implode('', $list_content) .
	             '</div>';
        }
		
		?>
        </div>
        <?php
		
//		if ( $link_open )
//			add_filter('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', $link_open);
//		if ( $link_closed )
//			add_filter('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', $link_closed);
//
		remove_filter('etheme_static_block_prevent_setup_post', '__return_true');
		
		if ( $local_settings['image_size'] != 'custom')
			remove_filter('single_product_archive_thumbnail_size', array($this, 'image_prerendered_size_filter'), 10);
		else
			remove_filter('woocommerce_product_get_image', array($this, 'filter_image_custom_size'), 10, 5);
		
		remove_filter('woocommerce_product_loop_title_classes', array($this, 'add_class_for_title'), 10);
	}
	
	public function etheme_get_image_list( $product, $size = 'woocommerce_thumbnail' ) {
		$images_string = '';
		
		$product_id = $product->get_id();
		$attachment_ids = $product->get_gallery_image_ids();
		if ( get_theme_mod('enable_variation_gallery', false) &&
		     get_theme_mod('variable_products_detach', false) && $product->get_type() == 'variation' ) {
			// take images from variation gallery meta
			$variation_attachment_ids = get_post_meta( $product->get_id(), 'et_variation_gallery_images', true );
			if ( (bool) $variation_attachment_ids && count((array) $variation_attachment_ids) ) {
				$attachment_ids = $variation_attachment_ids;
			}
			else {
				// if inherit parent second image
				$parent = wc_get_product( $product->get_parent_id() );
				$attachment_ids = $parent->get_gallery_image_ids();
			}
		}
		
		$_i = 0;
		
		if ( count( $attachment_ids ) > 0 ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), $size );
			if ( is_array( $image ) && isset( $image[0] ) ) {
				$images_string .= $image[0];
			}
			foreach ( $attachment_ids as $id ) {
				$_i ++;
				$image = wp_get_attachment_image_src( $id, $size );
				if ( $image == '' ) {
					continue;
				}
				if ( $_i == 1 && $images_string != '' ) {
					$images_string .= ';';
				}
				
				
				$images_string .= $image[0];
				
				if ( $_i != count( $attachment_ids ) ) {
					$images_string .= ';';
				}
			}
			
		}
		
		return $images_string;
	}
	
	public function image_hover_swap_image($product, $size = 'woocommerce_thumbnail') {
		global $product;
		
		$attachment_ids = $product->get_gallery_image_ids();
		
		if ( get_theme_mod('enable_variation_gallery', false) &&
		     get_theme_mod('variable_products_detach', false) && $product->get_type() == 'variation' ) {
			// take images from variation gallery meta
			$variation_attachment_ids = get_post_meta( $product->get_id(), 'et_variation_gallery_images', true );
			if ( (bool) $variation_attachment_ids && count((array) $variation_attachment_ids) ) {
				$attachment_ids = $variation_attachment_ids;
			}
			else {
				// if inherit parent second image
				$parent = wc_get_product( $product->get_parent_id() );
				$attachment_ids = $parent->get_gallery_image_ids();
			}
		}
		
		$image = '';
		
		if ( ! empty( $attachment_ids[0] ) ) {
			$image = wp_get_attachment_image( $attachment_ids[0], $size, false );
		}
		
		if ( $image != '' ) {
			echo '<span class="etheme-product-hover-swap-image">' . $image . '</span>';
		}
	}
	
	public function compare_button_icon($text) {
		return '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path d="M22.32 6.12c0.216-0.936 0.672-2.808 0.792-3.744 0.048-0.384-0.048-0.648-0.408-0.744-0.384-0.12-0.624 0.072-0.792 0.504-0.216 0.576-0.576 2.472-0.576 2.472-1.56-2.016-3.936-3.552-6.528-4.2l-0.096-0.024c-3.096-0.744-6.24-0.192-8.928 1.416-5.352 3.264-6.816 9.504-5.064 14.256 0.072 0.168 0.264 0.312 0.48 0.36 0.168 0.048 0.336-0.024 0.456-0.072l0.024-0.024c0.312-0.144 0.456-0.504 0.288-0.888-1.536-4.392 0-9.744 4.656-12.504 2.352-1.392 5.040-1.824 7.824-1.152 2.088 0.504 4.296 1.776 5.664 3.6 0 0-1.92 0-2.568 0.024-0.48 0-0.72 0.12-0.792 0.456-0.096 0.36 0.096 0.744 0.456 0.768 1.176 0.072 4.248 0.096 4.248 0.096 0.12 0 0.144 0 0.288-0.024s0.312-0.144 0.408-0.264c0.072-0.12 0.168-0.312 0.168-0.312zM1.608 17.952c-0.216 0.936-0.648 2.808-0.792 3.744-0.048 0.384 0.048 0.648 0.408 0.744 0.384 0.096 0.624-0.096 0.792-0.528 0.216-0.576 0.576-2.472 0.576-2.472 1.56 2.016 3.96 3.552 6.552 4.2l0.096 0.024c3.096 0.744 6.24 0.192 8.928-1.416 5.352-3.24 6.816-9.504 5.064-14.256-0.072-0.168-0.264-0.312-0.48-0.36-0.168-0.048-0.336 0.024-0.456 0.072l-0.024 0.024c-0.312 0.144-0.456 0.504-0.288 0.888 1.536 4.392 0 9.744-4.656 12.504-2.352 1.392-5.040 1.824-7.824 1.152-2.088-0.504-4.296-1.776-5.664-3.6 0 0 1.92 0 2.568-0.024 0.48 0 0.72-0.12 0.792-0.456 0.096-0.36-0.096-0.744-0.456-0.768-1.176-0.072-4.248-0.096-4.248-0.096-0.12 0-0.144 0-0.288 0.024s-0.312 0.144-0.408 0.264c-0.072 0.12-0.192 0.336-0.192 0.336z"></path>
        </svg>';
	}
	public function yith_wishlist_icon($icon) {
		return (!$icon ? 'fa-heart-o' : $icon);
	}
	public function escape_text($safe_text, $text) {
		return $text;
	}
	
	public function add_to_cart_icon($text) {
//		$settings = $this->get_settings_for_display();
		global $local_settings;
		$icon = '';
		switch ($local_settings['product_button_icon']) {
			case 'bag':
				$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
<path d="M20.232 5.352c-0.024-0.528-0.456-0.912-0.936-0.912h-2.736c-0.12-2.448-2.112-4.392-4.56-4.392s-4.464 1.944-4.56 4.392h-2.712c-0.528 0-0.936 0.432-0.936 0.936l-0.648 16.464c-0.024 0.552 0.168 1.104 0.552 1.512s0.888 0.624 1.464 0.624h13.68c0.552 0 1.056-0.216 1.464-0.624 0.36-0.408 0.552-0.936 0.552-1.488l-0.624-16.512zM12 1.224c1.8 0 3.288 1.416 3.408 3.216l-6.816-0.024c0.12-1.776 1.608-3.192 3.408-3.192zM7.44 5.616v1.968c0 0.336 0.264 0.6 0.6 0.6s0.6-0.264 0.6-0.6v-1.968h6.792v1.968c0 0.336 0.264 0.6 0.6 0.6s0.6-0.264 0.6-0.6v-1.968h2.472l0.624 16.224c-0.024 0.24-0.12 0.48-0.288 0.648s-0.384 0.264-0.6 0.264h-13.68c-0.24 0-0.456-0.096-0.624-0.264s-0.24-0.384-0.216-0.624l0.624-16.248h2.496z"></path>
</svg>';
				break;
			case 'cart':
				$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
<path d="M23.76 4.248c-0.096-0.096-0.24-0.24-0.504-0.24h-18.48l-0.48-2.4c-0.024-0.288-0.384-0.528-0.624-0.528h-2.952c-0.384 0-0.624 0.264-0.624 0.624s0.264 0.648 0.624 0.648h2.424l2.328 11.832c0.312 1.608 1.848 2.856 3.48 2.856h11.28c0.384 0 0.624-0.264 0.624-0.624s-0.264-0.624-0.624-0.624h-11.16c-0.696 0-1.344-0.312-1.704-0.816l14.064-1.92c0.264 0 0.528-0.24 0.528-0.528l1.968-7.824v-0.024c-0.024-0.048-0.024-0.288-0.168-0.432zM22.392 5.184l-1.608 6.696-14.064 1.824-1.704-8.52h17.376zM8.568 17.736c-1.464 0-2.592 1.128-2.592 2.592s1.128 2.592 2.592 2.592c1.464 0 2.592-1.128 2.592-2.592s-1.128-2.592-2.592-2.592zM9.888 20.328c0 0.696-0.624 1.32-1.32 1.32s-1.32-0.624-1.32-1.32 0.624-1.32 1.32-1.32 1.32 0.624 1.32 1.32zM18.36 17.736c-1.464 0-2.592 1.128-2.592 2.592s1.128 2.592 2.592 2.592c1.464 0 2.592-1.128 2.592-2.592s-1.128-2.592-2.592-2.592zM19.704 20.328c0 0.696-0.624 1.32-1.32 1.32s-1.344-0.6-1.344-1.32 0.624-1.32 1.32-1.32 1.344 0.624 1.344 1.32z"></path>
</svg>';
				break;
			case 'cart2':
				$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
<path d="M0.096 4.656v0.024l1.968 7.824c0 0.264 0.264 0.528 0.528 0.528l14.064 1.92c-0.384 0.504-1.032 0.816-1.704 0.816h-11.184c-0.384 0-0.624 0.264-0.624 0.624s0.264 0.624 0.624 0.624h11.28c1.656 0 3.168-1.248 3.48-2.856l2.328-11.832h2.424c0.384 0 0.624-0.264 0.624-0.624s-0.264-0.624-0.624-0.624h-2.952c-0.24 0-0.624 0.24-0.624 0.528l-0.456 2.424h-18.528c-0.264 0-0.384 0.144-0.504 0.24-0.12 0.12-0.12 0.36-0.12 0.384zM18.984 5.184l-1.704 8.52-14.088-1.824-1.584-6.696h17.376zM12.84 20.328c0 1.464 1.128 2.592 2.592 2.592s2.592-1.128 2.592-2.592c0-1.464-1.128-2.592-2.592-2.592s-2.592 1.128-2.592 2.592zM15.432 19.008c0.696 0 1.32 0.624 1.32 1.32s-0.624 1.32-1.32 1.32-1.32-0.624-1.32-1.32 0.6-1.32 1.32-1.32zM3.024 20.328c0 1.464 1.128 2.592 2.592 2.592s2.592-1.128 2.592-2.592c0-1.464-1.128-2.592-2.592-2.592-1.44 0-2.592 1.128-2.592 2.592zM5.64 19.008c0.696 0 1.32 0.624 1.32 1.32s-0.624 1.32-1.32 1.32-1.32-0.624-1.32-1.32 0.6-1.32 1.32-1.32z"></path>
</svg>';
				break;
			case 'custom':
				if ( ! empty( $local_settings['product_button_custom_icon'] ) || ! empty( $local_settings['product_button_custom_selected_icon']['value'] ) ) :
					ob_start();
					\Elementor\Icons_Manager::render_icon( $local_settings['product_button_custom_selected_icon'], [ 'aria-hidden' => 'true' ] );
					$icon = ob_get_clean();
				endif;
				break;
		}
		
		$text = $text ? '<span class="button-text">'.$text.'</span>' : $text;
		return ($local_settings['product_button_icon_align'] == 'left') ? $icon . $text : $text . $icon;
	}
	
	public function hover_add_to_cart_icon($text) {
//		$settings = $this->get_settings_for_display();
		global $local_settings;
		$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
<path d="M23.76 4.248c-0.096-0.096-0.24-0.24-0.504-0.24h-18.48l-0.48-2.4c-0.024-0.288-0.384-0.528-0.624-0.528h-2.952c-0.384 0-0.624 0.264-0.624 0.624s0.264 0.648 0.624 0.648h2.424l2.328 11.832c0.312 1.608 1.848 2.856 3.48 2.856h11.28c0.384 0 0.624-0.264 0.624-0.624s-0.264-0.624-0.624-0.624h-11.16c-0.696 0-1.344-0.312-1.704-0.816l14.064-1.92c0.264 0 0.528-0.24 0.528-0.528l1.968-7.824v-0.024c-0.024-0.048-0.024-0.288-0.168-0.432zM22.392 5.184l-1.608 6.696-14.064 1.824-1.704-8.52h17.376zM8.568 17.736c-1.464 0-2.592 1.128-2.592 2.592s1.128 2.592 2.592 2.592c1.464 0 2.592-1.128 2.592-2.592s-1.128-2.592-2.592-2.592zM9.888 20.328c0 0.696-0.624 1.32-1.32 1.32s-1.32-0.624-1.32-1.32 0.624-1.32 1.32-1.32 1.32 0.624 1.32 1.32zM18.36 17.736c-1.464 0-2.592 1.128-2.592 2.592s1.128 2.592 2.592 2.592c1.464 0 2.592-1.128 2.592-2.592s-1.128-2.592-2.592-2.592zM19.704 20.328c0 0.696-0.624 1.32-1.32 1.32s-1.344-0.6-1.344-1.32 0.624-1.32 1.32-1.32 1.344 0.624 1.344 1.32z"></path>
</svg>';
		switch ($local_settings['product_hover_button_icon']) {
			case 'bag':
				$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
<path d="M20.232 5.352c-0.024-0.528-0.456-0.912-0.936-0.912h-2.736c-0.12-2.448-2.112-4.392-4.56-4.392s-4.464 1.944-4.56 4.392h-2.712c-0.528 0-0.936 0.432-0.936 0.936l-0.648 16.464c-0.024 0.552 0.168 1.104 0.552 1.512s0.888 0.624 1.464 0.624h13.68c0.552 0 1.056-0.216 1.464-0.624 0.36-0.408 0.552-0.936 0.552-1.488l-0.624-16.512zM12 1.224c1.8 0 3.288 1.416 3.408 3.216l-6.816-0.024c0.12-1.776 1.608-3.192 3.408-3.192zM7.44 5.616v1.968c0 0.336 0.264 0.6 0.6 0.6s0.6-0.264 0.6-0.6v-1.968h6.792v1.968c0 0.336 0.264 0.6 0.6 0.6s0.6-0.264 0.6-0.6v-1.968h2.472l0.624 16.224c-0.024 0.24-0.12 0.48-0.288 0.648s-0.384 0.264-0.6 0.264h-13.68c-0.24 0-0.456-0.096-0.624-0.264s-0.24-0.384-0.216-0.624l0.624-16.248h2.496z"></path>
</svg>';
				break;
//			case 'cart':
//				$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
//<path d="M23.76 4.248c-0.096-0.096-0.24-0.24-0.504-0.24h-18.48l-0.48-2.4c-0.024-0.288-0.384-0.528-0.624-0.528h-2.952c-0.384 0-0.624 0.264-0.624 0.624s0.264 0.648 0.624 0.648h2.424l2.328 11.832c0.312 1.608 1.848 2.856 3.48 2.856h11.28c0.384 0 0.624-0.264 0.624-0.624s-0.264-0.624-0.624-0.624h-11.16c-0.696 0-1.344-0.312-1.704-0.816l14.064-1.92c0.264 0 0.528-0.24 0.528-0.528l1.968-7.824v-0.024c-0.024-0.048-0.024-0.288-0.168-0.432zM22.392 5.184l-1.608 6.696-14.064 1.824-1.704-8.52h17.376zM8.568 17.736c-1.464 0-2.592 1.128-2.592 2.592s1.128 2.592 2.592 2.592c1.464 0 2.592-1.128 2.592-2.592s-1.128-2.592-2.592-2.592zM9.888 20.328c0 0.696-0.624 1.32-1.32 1.32s-1.32-0.624-1.32-1.32 0.624-1.32 1.32-1.32 1.32 0.624 1.32 1.32zM18.36 17.736c-1.464 0-2.592 1.128-2.592 2.592s1.128 2.592 2.592 2.592c1.464 0 2.592-1.128 2.592-2.592s-1.128-2.592-2.592-2.592zM19.704 20.328c0 0.696-0.624 1.32-1.32 1.32s-1.344-0.6-1.344-1.32 0.624-1.32 1.32-1.32 1.344 0.624 1.344 1.32z"></path>
//</svg>';
				break;
			case 'cart2':
				$icon = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
<path d="M0.096 4.656v0.024l1.968 7.824c0 0.264 0.264 0.528 0.528 0.528l14.064 1.92c-0.384 0.504-1.032 0.816-1.704 0.816h-11.184c-0.384 0-0.624 0.264-0.624 0.624s0.264 0.624 0.624 0.624h11.28c1.656 0 3.168-1.248 3.48-2.856l2.328-11.832h2.424c0.384 0 0.624-0.264 0.624-0.624s-0.264-0.624-0.624-0.624h-2.952c-0.24 0-0.624 0.24-0.624 0.528l-0.456 2.424h-18.528c-0.264 0-0.384 0.144-0.504 0.24-0.12 0.12-0.12 0.36-0.12 0.384zM18.984 5.184l-1.704 8.52-14.088-1.824-1.584-6.696h17.376zM12.84 20.328c0 1.464 1.128 2.592 2.592 2.592s2.592-1.128 2.592-2.592c0-1.464-1.128-2.592-2.592-2.592s-2.592 1.128-2.592 2.592zM15.432 19.008c0.696 0 1.32 0.624 1.32 1.32s-0.624 1.32-1.32 1.32-1.32-0.624-1.32-1.32 0.6-1.32 1.32-1.32zM3.024 20.328c0 1.464 1.128 2.592 2.592 2.592s2.592-1.128 2.592-2.592c0-1.464-1.128-2.592-2.592-2.592-1.44 0-2.592 1.128-2.592 2.592zM5.64 19.008c0.696 0 1.32 0.624 1.32 1.32s-0.624 1.32-1.32 1.32-1.32-0.624-1.32-1.32 0.6-1.32 1.32-1.32z"></path>
</svg>';
				break;
			case 'custom':
				if ( ! empty( $local_settings['product_hover_button_custom_icon'] ) || ! empty( $local_settings['product_hover_button_custom_selected_icon']['value'] ) ) :
					ob_start();
					\Elementor\Icons_Manager::render_icon( $local_settings['product_hover_button_custom_selected_icon'], [ 'aria-hidden' => 'true' ] );
					$icon = ob_get_clean();
				endif;
				break;
		}
		return $icon;
	}
	
	public function quantity_plus_icon() {
		echo '<span class="plus">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M23.52 11.4h-10.92v-10.92c0-0.264-0.216-0.48-0.48-0.48h-0.24c-0.264 0-0.48 0.216-0.48 0.48v10.92h-10.92c-0.264 0-0.48 0.216-0.48 0.48v0.24c0 0.264 0.216 0.48 0.48 0.48h10.92v10.92c0 0.264 0.216 0.48 0.48 0.48h0.24c0.264 0 0.48-0.216 0.48-0.48v-10.92h10.92c0.264 0 0.48-0.216 0.48-0.48v-0.24c0-0.264-0.216-0.48-0.48-0.48z"></path>
                </svg>
            </span>';
	}
	
	public function quantity_minus_icon() {
		echo '<span class="minus">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M23.52 11.4h-23.040c-0.264 0-0.48 0.216-0.48 0.48v0.24c0 0.264 0.216 0.48 0.48 0.48h23.040c0.264 0 0.48-0.216 0.48-0.48v-0.24c0-0.264-0.216-0.48-0.48-0.48z"></path>
                </svg>
            </span>';
	}
	
	/**
	 * Return first product's category.
	 *
	 * @since 4.0.11
	 *
	 * @return void
	 */
	public function get_product_categories() {
	    global $product;
		$product_cats = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( $product->get_ID(), '\n', '', '' ) : $product->get_categories( '\n', '', '' );
		// hide html tags
        // $product_cats = strip_tags( $product_cats );
		
		if ( $product_cats ) {
			list( $first_cat ) = explode( '\n', $product_cats );
			echo '<div class="etheme-product-grid-categories">'.$first_cat.'</div>';
		}
	}
	
	/**
	 * Return product sku.
	 *
	 * @since 4.0.11
	 *
	 * @return void
	 */
	public function get_product_sku() {
	    global $product;
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'xstore-core' ); ?>
                <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'xstore-core' ); ?></span>
            </span>
		<?php endif;
	}
	
	public function get_countdown($settings, $product = null) {
	    if ( !$product )
	        return;
		
	    $product_id = $product->get_ID();
		$date       = get_post_meta( $product_id, '_sale_price_dates_to', true );
		$date_from  = get_post_meta( $product_id, '_sale_price_dates_from', true );
		$time_start = get_post_meta( $product_id, '_sale_price_time_start', true );
		$time_start = explode( ':', $time_start );
		$time_end   = get_post_meta( $product_id, '_sale_price_time_end', true );
		$time_end   = explode( ':', $time_end );
		
		$start_hour = ( isset( $time_start[0] ) && $time_start[0] != 'Array' && $time_start[0] > 0 ) ? $time_start[0] : '00';
		$start_minute = isset( $time_start[1] ) ? $time_start[1] : '00';
		
		$end_hour = ( isset( $time_end[0] ) && $time_end[0] != 'Array' && $time_end[0] > 0 ) ? $time_end[0] : '00';
        $end_minute = isset( $time_end[1] ) ? $time_end[1] : '00';
		
		if ( !$date ) return;
		
        $now = strtotime('now');
        
        if ( $date_from ) {
	        // place condition here because we have time start/end post_meta in XStore Theme so
	        // origin time is 23:59 but user could set another and time could be already out
	        $date_from = strtotime( get_gmt_from_date( date( 'Y-m-d', $date_from ) . ' ' . $start_hour . ':' . $start_minute . ':00' ) );
        }
		
		if ( ($date_from && $now < $date_from) ) return;
		
		// for frontend
		wp_enqueue_script('etheme_countdown');
		wp_enqueue_style('etheme-elementor-countdown');
		
		$date = strtotime( get_gmt_from_date(date('Y-m-d', $date) . ' '. $end_hour.':'.$end_minute.':00') );
		
		// place condition here because we have time start/end post_meta in XStore Theme so
        // origin time is 23:59 but user could set another and time could be already out
		if ( ($date && $now > $date) ) return;
		
		?>
    <div class="etheme-countdown-wrapper" data-date="<?php echo $date; ?>">

        <div class="etheme-countdown">
			<?php
			\ETC\App\Controllers\Elementor\General\Countdown::render_countdown(array(
				'show_labels' => $settings['countdown_show_labels'],
				'custom_labels' => $settings['countdown_custom_labels'],
                'label_days' => $settings['countdown_label_days'],
                'label_hours' => $settings['countdown_label_hours'],
                'label_minutes' => $settings['countdown_label_minutes'],
                'label_seconds' => $settings['countdown_label_seconds'],
				'label_position' => 'bottom',
				'show_days' => $settings['countdown_show_days'],
				'show_hours' => $settings['countdown_show_hours'],
				'show_minutes' => $settings['countdown_show_minutes'],
				'show_seconds' => $settings['countdown_show_seconds'],
				'add_delimiter' => $settings['countdown_add_delimiter'],
				'delimiter' => $settings['countdown_delimiter'],
			));
            ?>
        </div>
        
    </div>
        <?php
        
	}
	
	/**
	 * Filter image by default (wp) size.
	 *
	 * @param $old_size
	 * @return mixed
	 *
	 * @since 4.0.11
	 *
	 */
    public function image_prerendered_size_filter($old_size) {
        global $local_settings;
//	    $settings = $this->get_settings_for_display();
	    return $local_settings['image_size'];
    }
	
	/**
	 * Filter image with custom size.
	 *
	 * @param $image_origin
	 * @param $WC_Product
	 * @param $size
	 * @param $attr
	 * @param $placeholder
	 * @return string|string[]
	 *
	 * @since 4.0.11
	 *
	 */
    public function filter_image_custom_size($image_origin, $WC_Product, $size, $attr, $placeholder) {
//	    $settings = $this->get_settings_for_display();
	    global $local_settings;
	    $product_id = '';
	    if ( $WC_Product->get_image_id() ) {
		    $product_id = $WC_Product->get_image_id();
	    } elseif ( $WC_Product->get_parent_id() ) {
		    $parent_product = wc_get_product( $WC_Product->get_parent_id() );
		    if ( $parent_product ) {
			    $product_id = $parent_product->get_image_id();
		    }
	    }

	    if ( $product_id ) {
	        $custom_size = $local_settings['image_custom_dimension'];
		    $image = \Elementor\Group_Control_Image_Size::get_attachment_image_html(
			    array(
				    'image' => array(
					    'id' => $product_id,
				    ),
				    'image_custom_dimension' =>
                        array(
                            'width' => $custom_size['width'],
                            'height' => $custom_size['width']
                        ),
				    'image_size' => 'custom',
			    )
		    );
		    $image = str_replace(
		            '<img ',
                    sprintf('<img width="%1s" height="%2s"',
                        $custom_size['width'],
                        $custom_size['height']
                    ),
                    $image
            );
	    }
        else
		    $image = wc_placeholder_img( $size, $attr );
	    
	   return $image;
    }
	
	/**
	 * Wraps title in link.
	 *
	 * @param $title
	 * @param $id
	 * @return string
	 *
	 * @since 4.0.11
	 *
	 */
	public function add_link_for_title($title, $id) {
		$permalink = get_permalink( $id );
		return ( $permalink ) ? '<a href="'.$permalink.'">'.$title.'</a>' : $title;
	}
	
	/**
	 * Function that returns rendered title by chars/words limit.
	 *
	 * @param $title
	 * @return mixed|string
	 *
	 * @since 4.0.11
	 *
	 */
	public function limit_title_string($title) {
//		$settings = $this->get_settings_for_display();
        global $local_settings;
		if ( $local_settings['product_title_limit'] > 0) {
			if ( $local_settings['product_title_limit_type'] == 'chars' ) {
				return Elementor::limit_string_by_chars($title, $local_settings['product_title_limit']);
			}
            elseif ( $local_settings['product_title_limit_type'] == 'words' ) {
				return Elementor::limit_string_by_words($title, $local_settings['product_title_limit']);
			}
		}
		return $title;
	}
	
	/**
	 * Function that returns rendered excerpt by chars/words limit.
	 *
	 * @param $title
	 * @return mixed|string
	 *
	 * @since 4.0.11
	 *
	 */
	public function limit_excerpt_string($excerpt) {
//		$settings = $this->get_settings_for_display();
		global $local_settings;
		if ( $local_settings['product_excerpt_limit'] > 0) {
			if ( $local_settings['product_excerpt_limit_type'] == 'chars' ) {
				return Elementor::limit_string_by_chars($excerpt, $local_settings['product_excerpt_limit']);
			}
            elseif ( $local_settings['product_excerpt_limit_type'] == 'words' ) {
				return Elementor::limit_string_by_words($excerpt, $local_settings['product_excerpt_limit']);
			}
		}
		return $excerpt;
	}
	
	/**
	 * Function that returns rendered title by chars/words limit.
	 *
	 * @param $title
	 * @return mixed|string
	 *
	 * @since 4.0.11
	 *
	 */
	public function limit_hover_title_string($title) {
//		$settings = $this->get_settings_for_display();
		global $local_settings;
		if ( $local_settings['product_hover_title_limit'] > 0) {
			if ( $local_settings['product_hover_title_limit_type'] == 'chars' ) {
				return Elementor::limit_string_by_chars($title, $local_settings['product_hover_title_limit']);
			}
            elseif ( $local_settings['product_hover_title_limit_type'] == 'words' ) {
				return Elementor::limit_string_by_words($title, $local_settings['product_hover_title_limit']);
			}
		}
		return $title;
	}
	
	/**
	 * Function that returns rendered excerpt by chars/words limit.
	 *
	 * @param $title
	 * @return mixed|string
	 *
	 * @since 4.0.11
	 *
	 */
	public function limit_hover_excerpt_string($excerpt) {
//		$settings = $this->get_settings_for_display();
        global $local_settings;
		if ( $local_settings['product_hover_excerpt_limit'] > 0) {
			if ( $local_settings['product_hover_excerpt_limit_type'] == 'chars' ) {
				return Elementor::limit_string_by_chars($excerpt, $local_settings['product_hover_excerpt_limit']);
			}
            elseif ( $local_settings['product_hover_excerpt_limit_type'] == 'words' ) {
				return Elementor::limit_string_by_words($excerpt, $local_settings['product_hover_excerpt_limit']);
			}
		}
		return $excerpt;
	}
	
	/**
	 * Function that adds custom class for product title.
	 *
	 * @param $class
	 * @return string
	 *
	 * @since 4.0.11
	 *
	 */
	public function add_class_for_title($class) {
		$class .= ($class) ? ' ' : '';
		$class .= 'etheme-product-grid-title';
		return $class;
	}
	
	/**
	 * Function that adds custom class for loop button (add-to-cart/read-more/etc).
	 *
	 * @param $args
	 * @return mixed
	 *
	 * @since 4.0.11
	 *
	 */
	public function add_class_for_button($args) {
		$args['class'] .= ' etheme-product-grid-button';
		return $args;
	}
	
	/**
	 * All product element that could be shown.
	 *
	 * @since 4.0.11
	 *
	 * @return mixed
	 */
    public static function get_product_elements() {
	    $elements = array(
		    'image' => esc_html__('Show Image', 'xstore-core'),
		    'categories' => esc_html__('Show Categories', 'xstore-core'),
		    'title' => esc_html__('Show Title', 'xstore-core'),
		    'rating' => esc_html__('Show Rating', 'xstore-core'),
		    'price' => esc_html__('Show Price', 'xstore-core'),
		    'excerpt' => esc_html__('Show Excerpt', 'xstore-core'),
		    'sku' => esc_html__('Show SKU', 'xstore-core'),
		    'button' => esc_html__('Show Add To Cart Button', 'xstore-core'),
            'countdown' => esc_html__('Show Countdown', 'xstore-core'),
	    );
	    return apply_filters('etheme_product_grid_list_product_elements', $elements);
    }
	
	/**
	 * All product element that could be shown on hover.
	 *
	 * @since 4.0.11
	 *
	 * @return mixed
	 */
    public static function get_product_hover_elements() {
	    $elements = array(
		    'categories' => esc_html__('Show Categories', 'xstore-core'),
		    'title' => esc_html__('Show Title', 'xstore-core'),
		    'rating' => esc_html__('Show Rating', 'xstore-core'),
		    'price' => esc_html__('Show Price', 'xstore-core'),
		    'excerpt' => esc_html__('Show Excerpt', 'xstore-core'),
		    'sku' => esc_html__('Show SKU', 'xstore-core'),
		    'button' => esc_html__('Show Add To Cart Button', 'xstore-core'),
	    );
	    if ( class_exists('YITH_WCWL_Shortcode') )
		    $elements['wishlist_button'] = esc_html__('Show Wishlist Button', 'xstore-core');
	
	    if ( class_exists( 'YITH_Woocompare' ) )
		    $elements['compare_button'] = esc_html__('Show Compare Button', 'xstore-core');
	
	    return apply_filters('etheme_product_grid_list_product_hover_elements', $elements);
    }
	
	/**
	 * Return filtered product taxonomies.
	 *
	 * @since 4.2.1
	 *
	 * @return mixed
	 */
	public static function product_taxonomies_to_filter() {
		return apply_filters('etheme_product_grid_list_product_taxonomies', array(
			'product_cat' => esc_html__('Categories', 'xstore-core'),
			'product_tag' => esc_html__('Product tags', 'xstore-core'),
		) );
	}
	
	/**
	 * Returns the instance.
	 *
	 * @return object
	 * @since  4.1
	 */
	public static function get_instance( $shortcodes = array() ) {
		
		if ( null == self::$instance ) {
			self::$instance = new self( $shortcodes );
		}
		
		return self::$instance;
	}
	
}
