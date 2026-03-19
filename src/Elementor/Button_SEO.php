<?php

namespace Elementor_Button_SEO\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;

class Button_SEO {

	const ACTION_TYPES = [
		'ReadAction'     => 'Read Action',
		'ViewAction'     => 'View Action',
		'PlayAction'     => 'Play Action',
		'DownloadAction' => 'Download Action',
		'SearchAction'   => 'Search Action',
		'RegisterAction' => 'Register / Sign Up',
		'SubscribeAction'=> 'Subscribe',
		'ShareAction'    => 'Share',
		'CommunicateAction' => 'Communicate / Contact',
		'BuyAction'      => 'Buy / Purchase',
	];

	const OBJECT_TYPES = [
		'WebPage'  => 'WebPage',
		'Article'  => 'Article',
		'Product'  => 'Product',
		'Video'    => 'Video',
		'Course'   => 'Course',
		'Event'    => 'Event',
		'WebSite'  => 'WebSite',
		'Custom'   => 'Custom @type',
	];

	public function __construct() {
		add_action( 'elementor/element/button/_section_responsive/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/widget/before_render_content', [ $this, 'render_attributes' ], 10, 1 );
		add_action( 'elementor/widget/before_render_content', [ $this, 'render_schema' ], 20, 1 );
	}

	public function register_controls( Widget_Base $widget, $args ) {
		$widget->start_controls_section(
			'section_button_seo',
			[
				'label' => __( 'Button SEO & Accessibility', 'elementor-button-seo' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$widget->add_control(
			'button_seo_enabled',
			[
				'label'        => __( 'Enable SEO Enhancements', 'elementor-button-seo' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'description'  => __( 'Enable SEO and accessibility attributes for this button.', 'elementor-button-seo' ),
			]
		);

		$widget->add_control(
			'button_seo_accessibility_heading',
			[
				'label'     => __( 'Accessibility (Fixes "Links do not have descriptive text")', 'elementor-button-seo' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_seo_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_aria_label',
			[
				'label'       => __( 'ARIA Label', 'elementor-button-seo' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Descriptive text for screen readers. Overrides the visible button text for accessibility.', 'elementor-button-seo' ),
				'placeholder' => __( 'e.g., Download the free PDF report', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled' => 'yes',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'button_seo_aria_label_fallback',
			[
				'label'        => __( 'Auto ARIA Label from Button Text', 'elementor-button-seo' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => __( 'Automatically use the button text as aria-label when a custom one is not set.', 'elementor-button-seo' ),
				'condition'    => [
					'button_seo_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_title',
			[
				'label'       => __( 'Link Title Attribute', 'elementor-button-seo' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Tooltip text shown on hover. Also used by search engines to understand link context.', 'elementor-button-seo' ),
				'placeholder' => __( 'e.g., Visit our pricing page', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled' => 'yes',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'button_seo_title_from_text',
			[
				'label'        => __( 'Auto Title from Button Text', 'elementor-button-seo' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'description'  => __( 'Automatically set the title attribute from the button text when a custom title is not set.', 'elementor-button-seo' ),
				'condition'    => [
					'button_seo_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_schema_heading',
			[
				'label'     => __( 'Schema.org Structured Data (JSON-LD)', 'elementor-button-seo' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_seo_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_schema_enabled',
			[
				'label'        => __( 'Enable JSON-LD Schema', 'elementor-button-seo' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'description'  => __( 'Add Schema.org structured data to this button for rich results.', 'elementor-button-seo' ),
				'condition'    => [
					'button_seo_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_action_type',
			[
				'label'       => __( 'Action Type', 'elementor-button-seo' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => self::ACTION_TYPES,
				'default'     => 'ReadAction',
				'description' => __( 'The Schema.org action type this button performs.', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled'      => 'yes',
					'button_seo_schema_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_name',
			[
				'label'       => __( 'Action Name', 'elementor-button-seo' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'The name of the action. Defaults to the button text.', 'elementor-button-seo' ),
				'placeholder' => __( 'e.g., Read Article', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled'       => 'yes',
					'button_seo_schema_enabled' => 'yes',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'button_seo_description',
			[
				'label'       => __( 'Action Description', 'elementor-button-seo' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Optional description of the action.', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled'       => 'yes',
					'button_seo_schema_enabled' => 'yes',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'button_seo_object_type',
			[
				'label'     => __( 'Target Object Type', 'elementor-button-seo' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => self::OBJECT_TYPES,
				'default'   => 'WebPage',
				'condition' => [
					'button_seo_enabled'       => 'yes',
					'button_seo_schema_enabled' => 'yes',
				],
			]
		);

		$widget->add_control(
			'button_seo_custom_object_type',
			[
				'label'       => __( 'Custom Object @type', 'elementor-button-seo' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Enter a custom Schema.org type (e.g., SoftwareApplication, MusicAlbum).', 'elementor-button-seo' ),
				'placeholder' => __( 'e.g., SoftwareApplication', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled'       => 'yes',
					'button_seo_schema_enabled' => 'yes',
					'button_seo_object_type'   => 'Custom',
				],
			]
		);

		$widget->add_control(
			'button_seo_custom_json',
			[
				'label'       => __( 'Custom JSON-LD', 'elementor-button-seo' ),
				'type'        => Controls_Manager::CODE,
				'language'    => 'json',
				'description' => __( 'Override all schema fields with custom JSON-LD. Must be valid JSON.', 'elementor-button-seo' ),
				'condition'   => [
					'button_seo_enabled'       => 'yes',
					'button_seo_schema_enabled' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->end_controls_section();
	}

	public function render_attributes( Widget_Base $widget ) {
		if ( 'button' !== $widget->get_name() ) {
			return;
		}

		$settings = $widget->get_settings_for_display();

		if ( 'yes' !== $settings['button_seo_enabled'] ) {
			return;
		}

		$button_text = ! empty( $settings['text'] ) ? $settings['text'] : '';

		$aria_label = '';
		if ( ! empty( $settings['button_seo_aria_label'] ) ) {
			$aria_label = $settings['button_seo_aria_label'];
		} elseif ( 'yes' === $settings['button_seo_aria_label_fallback'] && ! empty( $button_text ) ) {
			$aria_label = $button_text;
		}

		if ( ! empty( $aria_label ) ) {
			$widget->add_render_attribute( 'button', 'aria-label', esc_attr( $aria_label ) );
		}

		$title_attr = '';
		if ( ! empty( $settings['button_seo_title'] ) ) {
			$title_attr = $settings['button_seo_title'];
		} elseif ( 'yes' === $settings['button_seo_title_from_text'] && ! empty( $button_text ) ) {
			$title_attr = $button_text;
		}

		if ( ! empty( $title_attr ) ) {
			$widget->add_render_attribute( 'button', 'title', esc_attr( $title_attr ) );
		}
	}

	public function render_schema( Widget_Base $widget ) {
		if ( 'button' !== $widget->get_name() ) {
			return;
		}

		$settings = $widget->get_settings_for_display();

		if ( 'yes' !== $settings['button_seo_enabled'] ) {
			return;
		}

		if ( 'yes' !== $settings['button_seo_schema_enabled'] ) {
			return;
		}

		$button_text = ! empty( $settings['text'] ) ? $settings['text'] : '';
		$link_url    = ! empty( $settings['link']['url'] ) ? $settings['link']['url'] : '';

		$json_ld = null;

		if ( ! empty( $settings['button_seo_custom_json'] ) ) {
			$decoded = json_decode( $settings['button_seo_custom_json'], true );
			if ( is_array( $decoded ) ) {
				$json_ld = $decoded;
			}
		}

		if ( null === $json_ld ) {
			$action_type  = ! empty( $settings['button_seo_action_type'] ) ? $settings['button_seo_action_type'] : 'ReadAction';
			$action_name  = ! empty( $settings['button_seo_name'] ) ? $settings['button_seo_name'] : $button_text;
			$description  = ! empty( $settings['button_seo_description'] ) ? $settings['button_seo_description'] : '';
			$object_type  = ! empty( $settings['button_seo_object_type'] ) ? $settings['button_seo_object_type'] : 'WebPage';

			if ( 'Custom' === $object_type ) {
				$object_type = ! empty( $settings['button_seo_custom_object_type'] ) ? $settings['button_seo_custom_object_type'] : 'Thing';
			}

			$object = [
				'@type' => $object_type,
			];

			if ( ! empty( $link_url ) ) {
				$object['@id'] = $link_url;
			}

			$json_ld = [
				'@context' => 'https://schema.org',
				'@type'    => $action_type,
				'name'     => $action_name,
				'target'   => $object,
			];

			if ( ! empty( $description ) ) {
				$json_ld['description'] = $description;
			}
		}

		if ( is_array( $json_ld ) ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
		}
	}
}
