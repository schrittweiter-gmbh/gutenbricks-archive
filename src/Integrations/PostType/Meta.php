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
 * Class Meta
 *
 * Handles the registration of the Archive Templates meta fields
 *
 * @since 1.0.0
 */
class Meta {

	/**
	 * Register custom post meta for archive templates.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_meta(): void {
		register_post_meta(
			'gb_archive_templates',
			'_gb_archive_type',
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => static function (): bool {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}

	/**
	 * Enqueue editor assets.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_editor_assets(): void {
		$asset_file = include GUTENBRICKS_ARCHIVE_PATH . 'build/index.asset.php';

		wp_enqueue_script(
			'gutenbricks-archive-editor',
			GUTENBRICKS_ARCHIVE_URL . 'build/index.js',
			$asset_file['dependencies'],
			$asset_file['version']
		);

		wp_localize_script(
			'gutenbricks-archive-editor',
			'gbArchiveOptions',
			$this->get_archive_options()
		);
	}

	/**
	 * Get archive options for post types and taxonomies.
	 *
	 * @since 1.0.0
	 * @return array<string, array{label: string, options: array<int, array{value: string, label: string}>}>
	 */
	private function get_archive_options(): array {
		$options = array();

		// Get public post types with archives.
		$post_types = get_post_types(
			array(
				'public'      => true,
				'has_archive' => true,
			),
			'objects'
		);

		if ( ! empty( $post_types ) ) {
			$options['post_types'] = array(
				'label'   => __( 'Post Types', 'gutenbricks-archive' ),
				'options' => array(),
			);

			foreach ( $post_types as $post_type ) {
				$options['post_types']['options'][] = array(
					'value' => $post_type->name,
					'label' => $post_type->label,
				);
			}
		}

		// Get all taxonomies.
		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

		foreach ( $taxonomies as $taxonomy ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy->name,
					'hide_empty' => false,
				)
			);

			if ( empty( $terms ) || is_wp_error( $terms ) ) {
				continue;
			}

			$options[ $taxonomy->name ] = array(
				'label'   => $taxonomy->label,
				'options' => array(),
			);

			foreach ( $terms as $term ) {
				$options[ $taxonomy->name ]['options'][] = array(
					'value' => sprintf( 'term_%s_%d', $term->taxonomy, $term->term_id ),
					'label' => $term->name,
				);
			}
		}

		return $options;
	}
}
