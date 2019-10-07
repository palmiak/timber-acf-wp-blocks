<?php
/**
 * Check whether WordPress and ACF are available; bail if not.
 *
 * @package timber-acf-wp-blocks
 **/

if ( ! function_exists( 'acf_register_block' ) ) {
	return;
}
if ( ! function_exists( 'add_filter' ) ) {
	return;
}
if ( ! function_exists( 'add_action' ) ) {
	return;
}

/**
 * Create blocks based on templates found in Timber's "views/blocks" directory
 */
add_action(
	'acf/init',
	function () {
		// Get an array of directories containing blocks.
		$directories = apply_filters( 'timber/acf-gutenberg-blocks-templates', [ 'views/blocks' ] );

		// Check whether ACF exists before continuing.
		foreach ( $directories as $dir ) {
			// Sanity check whether the directory we're iterating over exists first.
			if ( ! file_exists( \locate_template( $dir ) ) ) {
				return;
			}
			// Iterate over the directories provided and look for templates.
			$template_directory = new \DirectoryIterator( \locate_template( $dir ) );
			foreach ( $template_directory as $template ) {

				if ( ! $template->isDot() && ! $template->isDir() ) {
					// Strip the file extension to get the slug.
					$slug = str_replace( '.twig', '', $template->getFilename() );

					// Get header info from the found template file(s).
					$file_path    = locate_template( $dir . "/${slug}.twig" );
					$file_headers = get_file_data(
						$file_path,
						[
							'title'             => 'Title',
							'description'       => 'Description',
							'category'          => 'Category',
							'icon'              => 'Icon',
							'keywords'          => 'Keywords',
							'mode'              => 'Mode',
							'align'             => 'Align',
							'post_types'        => 'PostTypes',
							'supports_align'    => 'SupportsAlign',
							'supports_mode'     => 'SupportsMode',
							'supports_multiple' => 'SupportsMultiple',
							'supports_anchor'   => 'SupportsAnchor',
							'enqueue_style'     => 'EnqueueStyle',
							'enqueue_script'    => 'EnqueueScript',
							'enqueue_assets'    => 'EnqueueAssets',
						]
					);

					if ( empty( $file_headers['title'] ) ) {
						continue;
					}
					if ( empty( $file_headers['category'] ) ) {
						continue;
					}

					// Keywords exploding with quotes.
					$keywords = str_getcsv( $file_headers['keywords'], ' ', '"' );

					// Set up block data for registration.
					$data = [
						'name'            => $slug,
						'title'           => $file_headers['title'],
						'description'     => $file_headers['description'],
						'category'        => $file_headers['category'],
						'icon'            => $file_headers['icon'],
						'keywords'        => $keywords,
						'mode'            => $file_headers['mode'],
						'render_callback' => 'timber_blocks_callback',
						'enqueue_style'   => $file_headers['enqueue_style'],
						'enqueue_script'  => $file_headers['enqueue_script'],
						'enqueue_assets'  => $file_headers['enqueue_assets'],
					];
					// If the PostTypes header is set in the template, restrict this block
					// to those types.
					if ( ! empty( $file_headers['post_types'] ) ) {
						$data['post_types'] = explode( ' ', $file_headers['post_types'] );
					}
					// If the SupportsAlign header is set in the template, restrict this block
					// to those aligns.
					if ( ! empty( $file_headers['supports_align'] ) ) {
						$data['supports']['align'] = in_array( $file_headers['supports_align'], [ 'true', 'false' ], true ) ?
						filter_var( $file_headers['supports_align'], FILTER_VALIDATE_BOOLEAN ) :
						explode( ' ', $file_headers['supports_align'] );
					}
					// If the SupportsMode header is set in the template, restrict this block
					// mode feature.
					if ( ! empty( $file_headers['supports_mode'] ) ) {
						$data['supports']['mode'] = 'true' === $file_headers['supports_mode'] ? true : false;
					}
					// If the SupportsMultiple header is set in the template, restrict this block
					// multiple feature.
					if ( ! empty( $file_headers['supports_multiple'] ) ) {
						$data['supports']['multiple'] = 'true' === $file_headers['supports_multiple'] ? true : false;
					}
					// If the SupportsAnchor header is set in the template, restrict this block
					// anchor feature.
					if ( ! empty( $file_headers['supports_anchor'] ) ) {
						$data['supports']['anchor'] = 'true' === $file_headers['supports_anchor'] ? true : false;
					}

					// Register the block with ACF.
					acf_register_block_type( $data );
				}
			}
		}
	}
);

/**
 * Callback to register blocks
 *
 * @param array  $block stores all the data from ACF.
 * @param string $content content passed to block.
 * @param bool   $is_preview checks if block is in preview mode.
 * @param int    $post_id Post ID.
 */
function timber_blocks_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	// Set up the slug to be useful.
	$context = Timber::get_context();
	$slug    = str_replace( 'acf/', '', $block['name'] );

	$context['block']      = $block;
	$context['post_id']    = $post_id;
	$context['slug']       = $slug;
	$context['is_preview'] = $is_preview;
	$context['fields']     = get_fields();
	$classes               = [
		$slug,
		isset( $block['className'] ) ? $block['className'] : null,
		$is_preview ? 'is-preview' : null,
		'align' . $context['block']['align'],
	];

	$context['classes'] = implode( ' ', $classes );

	$context = apply_filters( 'timber/acf-gutenberg-blocks-data/' . $slug, $context );
	$context = apply_filters( 'timber/acf-gutenberg-blocks-data/' . $block['id'], $context );

	$paths = timber_acf_path_render( $slug );

	Timber::render( $paths, $context );
}

/**
 * Generates array with paths and slugs
 *
 * @param string $slug File slug.
 */
function timber_acf_path_render( $slug ) {
	$directories = apply_filters( 'timber/acf-gutenberg-blocks-templates', [ 'views/blocks' ] );

	$ret = [];
	foreach ( $directories as $directory ) {
		$ret[] = $directory . "/{$slug}.twig";
	}

	return $ret;
}
