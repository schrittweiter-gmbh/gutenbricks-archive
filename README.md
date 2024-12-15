# GutenBricks Archive

GutenBricks Archive is a WordPress plugin that enables the creation of custom archive templates using the WordPress Block Editor and seamlessly integrates them with Bricks Builder.

## Features

- Custom post type for archive templates
- Support for post type archives and taxonomy terms
- Seamless integration with Bricks Builder
- Fallback content option
- Full block editor support

## Technical Details

### Post Types

- `gb_archive_templates`: Custom post type for storing archive templates

### Meta Fields

- `_gb_archive_type`: Stores the archive type identifier (post type or taxonomy term)

### Bricks Integration

The plugin adds a new Bricks element `gb-archive-block` with the following features:

- Displays matching archive template content
- Configurable fallback content
- Automatic template selection based on current archive context
- Support for post type archives and taxonomy terms

### Supported Archive Types

- Post Type Archives (for public post types with archives enabled)
- Taxonomy Archives (categories, tags, and custom taxonomies)

## Requirements

- WordPress 6.0 or higher
- PHP 8.0 or higher
- Bricks Builder 1.5 or higher

## Installation

1. Upload the plugin files to `/wp-content/plugins/gutenbricks-archive`
2. Activate the plugin through the WordPress plugins screen
3. Create archive templates under the "Archive Templates" menu
4. Use the "GutenBricks Archive" element in Bricks Builder

## Usage

1. Create a new archive template under "Archive Templates"
2. Select the target archive type (post type or taxonomy term)
3. Design your template using the block editor
4. Add the "GutenBricks Archive" element to your Bricks template
5. Configure fallback content if desired

## Development

The plugin follows WordPress coding standards and uses modern PHP features:

- Namespaced classes
- Type hints and return types
- PHPStan compatibility
- WP_Filesystem implementation
- Object-oriented architecture

## License

MIT License

Copyright (c) 2024 schrittweiter GmbH

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Credits

Developed by schrittweiter GmbH