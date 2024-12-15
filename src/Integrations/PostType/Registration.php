<?php
/**
 * Class for registering custom post type for archive templates.
 *
 * @link       https://schrittweiter.de
 * @since      1.0.0
 *
 * @package    GutenBricks_Archive
 * @subpackage GutenBricks_Archive\Integrations\PostType
 */

namespace GutenBricks_Archive\Integrations\PostType;

/**
 * Class Registration
 *
 * Handles the registration of the Archive Templates custom post type.
 *
 * @since 1.0.0
 */
class Registration {

	/**
	 * Register the custom post type for archive templates.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_post_type(): void {
		$labels = $this->get_post_type_labels();
		$args   = $this->get_post_type_args( $labels );

		register_post_type( 'gb_archive_templates', $args );
	}

	/**
	 * Get the labels for the custom post type.
	 *
	 * @since 1.0.0
	 *
	 * @return array<string, string>
	 */
	private function get_post_type_labels(): array {
		return array(
			'name'          => _x( 'Archive Templates', 'Post type general name', 'gutenbricks-archive' ),
			'singular_name' => _x( 'Archive Template', 'Post type singular name', 'gutenbricks-archive' ),
			'menu_name'     => _x( 'Archive Templates', 'Admin Menu text', 'gutenbricks-archive' ),
			'add_new'       => __( 'Add New', 'gutenbricks-archive' ),
			'add_new_item'  => __( 'Add New Template', 'gutenbricks-archive' ),
			'edit_item'     => __( 'Edit Template', 'gutenbricks-archive' ),
			'new_item'      => __( 'New Template', 'gutenbricks-archive' ),
			'view_item'     => __( 'View Template', 'gutenbricks-archive' ),
			'search_items'  => __( 'Search Templates', 'gutenbricks-archive' ),
		);
	}

	/**
	 * Get the arguments for registering the custom post type.
	 *
	 * @since 1.0.0
	 *
	 * @param array<string, string> $labels Post type labels.
	 * @return array<string, mixed>
	 */
	private function get_post_type_args( array $labels ): array {
		return array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'custom-fields' ),
			'template'           => array(
				array(
					'core/paragraph',
					array(
						'placeholder' => __( 'Add your archive template content...', 'gutenbricks-archive' ),
					),
				),
			),
		);
	}
}
