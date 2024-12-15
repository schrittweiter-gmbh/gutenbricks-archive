<?php
/**
 * Archive Block Element for Bricks Builder.
 *
 * @package    GutenBricks_Archive
 * @subpackage GutenBricks_Archive\Integrations\Bricks\Elements
 * @since      1.0.0
 */

namespace GutenBricks_Archive\Integrations\Bricks\Elements;

use Bricks\Element;
use WP_Post;
use WP_Query;
use WP_Post_Type;
use WP_Term;

/**
 * Class Archive_Block
 *
 * Handles the archive block element functionality in Bricks Builder.
 *
 * @since 1.0.0
 */
class Archive_Block extends Element {

	/**
	 * Element category.
	 *
	 * @var string
	 */
	public $category = 'gutenbricks';

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'gb-archive-block';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'fas fa-box-archive';

	/**
	 * Whether the element is nestable.
	 *
	 * @var bool
	 */
	public $nestable = false;

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'GutenBricks Archive', 'gutenbricks-archive' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return string[]
	 */
	public function get_keywords(): array {
		return [ 'archive', 'gutenbricks' ];
	}

	/**
	 * Set element controls.
	 *
	 * @return void
	 */
	public function set_controls(): void {
		$this->controls['info'] = [
			'tab'     => 'content',
			'type'    => 'info',
			'content' => esc_html__( 'This element will display the matching archive template content.', 'gutenbricks-archives' ),
		];

		$this->controls['fallbackContent'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Fallback Content', 'gutenbricks-archives' ),
			'type'        => 'textarea',
			'placeholder' => esc_html__( 'Content to show if no matching archive template is found', 'gutenbricks-archives' ),
		];
	}

	/**
	 * Render the element.
	 *
	 * @return void
	 */
	public function render(): void {
		$settings = $this->settings;

		$render = true;

		if ( ! is_archive() ) {
			$render = false;
		}

		$archive_type = $this->get_current_archive_type();

		if ( false === $archive_type ) {
			$render = false;
			$content = $this->render_fallback( $settings );
		}

		$template_id = $this->get_archive_template_by_type( $archive_type );

		if ( ! $template_id ) {
			$render = false;
			$content = $this->render_fallback( $settings );
		}

		if($render) {
			$content  = $this->render_template_content( $template_id );
		}

		echo "<div {$this->render_attributes('_root')}>";
		echo $content;
		echo "</div>";
	}

	/**
	 * Render fallback content.
	 *
	 * @param array<string, mixed> $settings Element settings.
	 * @return string
	 */
	private function render_fallback( array $settings ): string {
		if ( empty( $settings['fallbackContent'] ) ) {
			return '';
		}

		return sprintf(
			'<div %s>%s</div>',
			$this->render_attributes( [ '_root' => [ 'gutenbricks-archive', 'fallback' ] ] ),
			$settings['fallbackContent']
		);
	}

	/**
	 * Get the current archive type identifier.
	 *
	 * @return string|false Archive type identifier or false if not an archive.
	 */
	public function get_current_archive_type() {
		$queried_object = get_queried_object();

		if ( is_post_type_archive() && $queried_object instanceof WP_Post_Type ) {
			return $queried_object->name;
		}

		if ( ( is_tax() || is_category() || is_tag() ) && $queried_object instanceof WP_Term ) {
			return sprintf( 'term_%s_%d', $queried_object->taxonomy, $queried_object->term_id );
		}

		return false;
	}

	/**
	 * Render archive template content.
	 *
	 * @param int $template_id The template post ID.
	 * @return string
	 */
	public function render_template_content( int $template_id ): string {
		$content_post = get_post( $template_id );

		if ( ! $content_post instanceof WP_Post || ! has_blocks( $content_post->post_content ) ) {
			return '';
		}

		$output = '';
		$blocks = parse_blocks( $content_post->post_content );

		foreach ( $blocks as $block ) {
			$output .= do_shortcode( render_block( $block ) );
		}

		return $output;
	}

	/**
	 * Get archive template by type.
	 *
	 * @param string $archive_type The archive type to search for.
	 * @return int|false
	 */
	public function get_archive_template_by_type( string $archive_type ) {
		$query = new WP_Query(
			[
				'post_type'      => 'gb_archive_templates',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_query'     => [
					[
						'key'     => '_gb_archive_type',
						'value'   => $archive_type,
						'compare' => '=',
					],
				],
			]
		);

		return ! empty( $query->posts ) ? $query->posts[0] : false;
	}
}