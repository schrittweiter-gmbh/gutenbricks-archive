<?php
/**
 * Elements loader for Bricks Builder integration.
 *
 * @package    GutenBricks_Archive
 * @subpackage GutenBricks_Archive\Integrations\Bricks
 * @since      1.0.0
 */

namespace GutenBricks_Archive\Integrations\Bricks;

use WP_Filesystem_Direct;

/**
 * Class Elements
 *
 * Handles the registration of custom Bricks elements.
 *
 * @since 1.0.0
 */
class Elements {

	/**
	 * WP Filesystem instance.
	 *
	 * @var WP_Filesystem_Direct
	 */
	private WP_Filesystem_Direct $filesystem;

	/**
	 * Constructor.
	 */
	public function __construct() {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		$this->filesystem = new WP_Filesystem_Direct( null );
	}

	/**
	 * Load and register custom Bricks elements.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load(): void {
		$path = __DIR__ . '/Elements';

		if ( ! $this->filesystem->exists( $path ) || ! $this->filesystem->is_dir( $path ) ) {
			return;
		}

		$elements = $this->filesystem->dirlist( $path );

		if ( ! is_array( $elements ) ) {
			return;
		}

		foreach ( $elements as $element ) {
			// Skip directories and non-PHP files.
			if ( 'f' !== $element['type'] || ! $this->is_valid_php_file( $element['name'] ) ) {
				continue;
			}

			$element_path = trailingslashit( $path ) . $element['name'];

			if ( ! class_exists( '\Bricks\Elements' ) ) {
				return;
			}

			/** @phpstan-ignore-next-line */
			\Bricks\Elements::register_element( $element_path );
		}
	}

	/**
	 * Check if the file is a valid PHP file.
	 *
	 * @since 1.0.0
	 * @param string $filename The filename to check.
	 * @return bool Whether the file is a valid PHP file.
	 */
	private function is_valid_php_file( string $filename ): bool {
		return '.php' === substr( $filename, -4 );
	}
}