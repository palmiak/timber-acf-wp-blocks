<?php
use Timber\Timber;

/**
 * Check if class exists before redefining it
 */
if ( ! class_exists( 'Timber_Acf_Wp_Blocks' ) ) {
	/**
	 * Main Timber_Acf_Wp_Block Class
	 */
	class Timber_Acf_Wp_Blocks {
		/**
		 * Constructor
		 */
		public function __construct() {
			if ( is_callable( 'add_action' )
				&& is_callable( 'acf_register_block_type' )
				&& class_exists( 'Timber' )
				) {
				add_action( 'acf/init', array( __CLASS__, 'timber_block_init' ), 10, 0 );
			} elseif ( is_callable( 'add_action' ) ) {
				add_action(
					'admin_notices',
					function() {
						echo '<div class="error"><p>Timber ACF WP Blocks requires Timber and ACF.';
						echo 'Check if the plugins or libraries are installed and activated.</p></div>';
					}
				);
			}
		}


		/**
		 * Create blocks based on templates found in Timber's "views/blocks" directory
		 */
		public static function timber_block_init() {
			// Get an array of directories containing blocks.
			$directories = self::timber_block_directory_getter();

			// Check whether ACF exists before continuing.
			foreach ( $directories as $dir ) {
				// Sanity check whether the directory we're iterating over exists first.
				if ( ! file_exists( \locate_template( $dir ) ) ) {
					return;
				}

				// Iterate over the directories provided and look for templates.
				$template_directory = new DirectoryIterator( \locate_template( $dir ) );
				foreach ( $template_directory as $template ) {

					if ( $template->isDot() || $template->isDir() ) {
						continue;
					}

					$file_parts = pathinfo( $template->getFilename() );
					if ( 'twig' !== $file_parts['extension'] ) {
						continue;
					}

					// Strip the file extension to get the slug.
					$slug = $file_parts['filename'];

					// Get header info from the found template file(s).
					$file_path    = locate_template( $dir . "/${slug}.twig" );
					$file_headers = get_file_data(
						$file_path,
						array(
							'title'                      => 'Title',
							'description'                => 'Description',
							'category'                   => 'Category',
							'icon'                       => 'Icon',
							'keywords'                   => 'Keywords',
							'mode'                       => 'Mode',
							'align'                      => 'Align',
							'post_types'                 => 'PostTypes',
							'supports_align'             => 'SupportsAlign',
							'supports_mode'              => 'SupportsMode',
							'supports_multiple'          => 'SupportsMultiple',
							'supports_anchor'            => 'SupportsAnchor',
							'enqueue_style'              => 'EnqueueStyle',
							'enqueue_script'             => 'EnqueueScript',
							'enqueue_assets'             => 'EnqueueAssets',
							'supports_custom_class_name' => 'SupportsCustomClassName',
							'supports_reusable'          => 'SupportsReusable',
							'supports_full_height'       => 'SupportsFullHeight',
							'example'                    => 'Example',
							'supports_jsx'               => 'SupportsJSX',
							'parent'                     => 'Parent',
							'default_data'               => 'DefaultData',
						)
					);

					if ( empty( $file_headers['title'] ) || empty( $file_headers['category'] ) ) {
						continue;
					}

					// Keywords exploding with quotes.
					$keywords = str_getcsv( $file_headers['keywords'], ' ', '"' );

					// Set up block data for registration.
					$data = array(
						'name'            => $slug,
						'title'           => $file_headers['title'],
						'description'     => $file_headers['description'],
						'category'        => $file_headers['category'],
						'icon'            => $file_headers['icon'],
						'keywords'        => $keywords,
						'mode'            => $file_headers['mode'],
						'align'           => $file_headers['align'],
						'render_callback' => array( __CLASS__, 'timber_blocks_callback' ),
						'enqueue_assets'  => $file_headers['enqueue_assets'],
						'default_data'    => $file_headers['default_data'],
					);

					// Removes empty defaults.
					$data = array_filter( $data );

					// If the PostTypes header is set in the template, restrict this block
					// to those types.
					if ( ! empty( $file_headers['post_types'] ) ) {
						$data['post_types'] = explode( ' ', $file_headers['post_types'] );
					}
					// If the SupportsAlign header is set in the template, restrict this block
					// to those aligns.
					if ( ! empty( $file_headers['supports_align'] ) ) {
						$data['supports']['align'] =
							in_array( $file_headers['supports_align'], array( 'true', 'false' ), true ) ?
							filter_var( $file_headers['supports_align'], FILTER_VALIDATE_BOOLEAN ) :
							explode( ' ', $file_headers['supports_align'] );
					}
					// If the SupportsMode header is set in the template, restrict this block
					// mode feature.
					if ( ! empty( $file_headers['supports_mode'] ) ) {
						$data['supports']['mode'] =
							( 'true' === $file_headers['supports_mode'] ) ? true : false;
					}
					// If the SupportsMultiple header is set in the template, restrict this block
					// multiple feature.
					if ( ! empty( $file_headers['supports_multiple'] ) ) {
						$data['supports']['multiple'] =
							( 'true' === $file_headers['supports_multiple'] ) ? true : false;
					}
					// If the SupportsAnchor header is set in the template, restrict this block
					// anchor feature.
					if ( ! empty( $file_headers['supports_anchor'] ) ) {
						$data['supports']['anchor'] =
							( 'true' === $file_headers['supports_anchor'] ) ? true : false;
					}

					// If the SupportsCustomClassName is set to false hides the possibilty to
					// add custom class name.
					if ( ! empty( $file_headers['supports_custom_class_name'] ) ) {
						$data['supports']['customClassName'] =
							( 'true' === $file_headers['supports_custom_class_name'] ) ? true : false;
					}

					// If the SupportsReusable is set in the templates it adds a posibility to
					// make this block reusable.
					if ( ! empty( $file_headers['supports_reusable'] ) ) {
						$data['supports']['reusable'] =
							( 'true' === $file_headers['supports_reusable'] ) ? true : false;
					}

					// If the SupportsFullHeight is set in the templates it adds a posibility to
					// make this block full height.
					if ( ! empty( $file_headers['supports_full_height'] ) ) {
						$data['supports']['full_height'] =
							( 'true' === $file_headers['supports_full_height'] ) ? true : false;
					}

					// Gives a possibility to enqueue style. If not an absoulte URL than adds
					// theme directory.
					if ( ! empty( $file_headers['enqueue_style'] ) ) {
						if ( ! filter_var( $file_headers['enqueue_style'], FILTER_VALIDATE_URL ) ) {
							$data['enqueue_style'] =
								get_template_directory_uri() . '/' . $file_headers['enqueue_style'];
						} else {
							$data['enqueue_style'] = $file_headers['enqueue_style'];
						}
					}

					// Gives a possibility to enqueue script. If not an absoulte URL than adds
					// theme directory.
					if ( ! empty( $file_headers['enqueue_script'] ) ) {
						if ( ! filter_var( $file_headers['enqueue_script'], FILTER_VALIDATE_URL ) ) {
							$data['enqueue_script'] =
								get_template_directory_uri() . '/' . $file_headers['enqueue_script'];
						} else {
							$data['enqueue_script'] = $file_headers['enqueue_script'];
						}
					}

					// Support for experimantal JSX.
					if ( ! empty( $file_headers['supports_jsx'] ) ) {
						// Leaving the experimaental part for 2 versions.
						$data['supports']['__experimental_jsx'] =
							( 'true' === $file_headers['supports_jsx'] ) ? true : false;
						$data['supports']['jsx']                =
							( 'true' === $file_headers['supports_jsx'] ) ? true : false;
					}

					// Support for "example".
					if ( ! empty( $file_headers['example'] ) ) {
						$json                       = json_decode( $file_headers['example'], true );
						$example_data               = ( null !== $json ) ? $json : array();
						$example_data['is_example'] = true;
						$data['example']            = array(
							'attributes' => array(
								'mode' => 'preview',
								'data' => $example_data,
							),
						);
					}

					// Support for "parent".
					if ( ! empty( $file_headers['parent'] ) ) {
						$data['parent'] = str_getcsv( $file_headers['parent'], ' ', '"' );
					}

					// Merges the default options.
					$data = self::timber_block_default_data( $data );

					// Register the block with ACF.
					acf_register_block_type( $data );
				}
			}
		}

		/**
		 * Callback to register blocks
		 *
		 * @param array  $block      stores all the data from ACF.
		 * @param string $content    content passed to block.
		 * @param bool   $is_preview checks if block is in preview mode.
		 * @param int    $post_id    Post ID.
		 */
		public static function timber_blocks_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
			// Context compatibility.
			if ( method_exists( 'Timber', 'context' ) ) {
				$context = Timber::context();
			} else {
				$context = Timber::get_context();
			}

			// Set up the slug to be useful.
			$slug = str_replace( 'acf/', '', $block['name'] );

			$context['block']      = $block;
			$context['post_id']    = $post_id;
			$context['slug']       = $slug;
			$context['is_preview'] = $is_preview;
			$context['fields']     = \get_fields();
			$classes               = array_merge(
				array( $slug ),
				isset( $block['className'] ) ? array( $block['className'] ) : array(),
				$is_preview ? array( 'is-preview' ) : array(),
				array( 'align' . $context['block']['align'] )
			);

			$context['classes'] = implode( ' ', $classes );

			$is_example = false;

			if ( ! empty( $block['data']['is_example'] ) ) {
				$is_example        = true;
				$context['fields'] = $block['data'];
			}

			$context = apply_filters( 'timber/acf-gutenberg-blocks-data', $context );
			$context = apply_filters( 'timber/acf-gutenberg-blocks-data/' . $slug, $context );
			$context = apply_filters( 'timber/acf-gutenberg-blocks-data/' . $block['id'], $context );

			$paths = self::timber_acf_path_render( $slug, $is_preview, $is_example );

			Timber::render( $paths, $context );
		}

		/**
		 * Generates array with paths and slugs
		 *
		 * @param string $slug       File slug.
		 * @param bool   $is_preview Checks if preview.
		 * @param bool   $is_example Checks if example.
		 */
		public static function timber_acf_path_render( $slug, $is_preview, $is_example ) {
			$directories = self::timber_block_directory_getter();

			$ret = array();

			/**
			 * Filters the name of suffix for example file.
			 *
			 * @since 1.12
			 */
			$example_identifier = apply_filters( 'timber/acf-gutenberg-blocks-example-identifier', '-example' );

			/**
			 * Filters the name of suffix for preview file.
			 *
			 * @since 1.12
			 */
			$preview_identifier = apply_filters( 'timber/acf-gutenberg-blocks-preview-identifier', '-preview' );

			foreach ( $directories as $directory ) {
				if ( $is_example ) {
					$ret[] = $directory . "/{$slug}{$example_identifier}.twig";
				}
				if ( $is_preview ) {
					$ret[] = $directory . "/{$slug}{$preview_identifier}.twig";
				}
				$ret[] = $directory . "/{$slug}.twig";
			}

			return $ret;
		}

		/**
		 * Generates the list of subfolders based on current directories
		 *
		 * @param array $directories File path array.
		 */
		public static function timber_blocks_subdirectories( $directories ) {
			$ret = array();

			foreach ( $directories as $base_directory ) {
				// Check if the folder exist.
				if ( ! file_exists( \locate_template( $base_directory ) ) ) {
					continue;
				}

				$template_directory = new RecursiveDirectoryIterator(
					\locate_template( $base_directory ),
					FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_SELF
				);

				if ( $template_directory ) {
					foreach ( $template_directory as $directory ) {
						if ( $directory->isDir() && ! $directory->isDot() ) {
							$ret[] = $base_directory . '/' . $directory->getFilename();
						}
					}
				}
			}

			return $ret;
		}

		/**
		 * Universal function to handle getting folders and subfolders
		 */
		public static function timber_block_directory_getter() {
			// Get an array of directories containing blocks.
			$directories = apply_filters( 'timber/acf-gutenberg-blocks-templates', array( 'views/blocks' ) );

			// Check subfolders.
			$subdirectories = self::timber_blocks_subdirectories( $directories );

			if ( ! empty( $subdirectories ) ) {
				$directories = array_merge( $directories, $subdirectories );
			}

			return $directories;
		}

		/**
		 * Default options setter.
		 *
		 * @param  [array] $data - header set data.
		 * @return [array]
		 */
		public static function timber_block_default_data( $data ) {
			$default_data = apply_filters( 'timber/acf-gutenberg-blocks-default-data', array() );
			$data_array   = array();

			if ( ! empty( $data['default_data'] ) ) {
				$default_data_key = $data['default_data'];
			}

			if ( isset( $default_data_key ) && ! empty( $default_data[ $default_data_key ] ) ) {
				$data_array = $default_data[ $default_data_key ];
			} elseif ( ! empty( $default_data['default'] ) ) {
				$data_array = $default_data['default'];
			}

			if ( is_array( $data_array ) ) {
				$data = array_merge( $data_array, $data );
			}

			return $data;
		}
	}
}

if ( is_callable( 'add_action' ) ) {
	add_action(
		'after_setup_theme',
		function() {
			new Timber_Acf_Wp_Blocks();
		}
	);
}
