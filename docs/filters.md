# Filters

`timber/acf-gutenberg-blocks-templates` - path where you blocks are kept - default: `[ 'views/blocks' ]`

`timber/acf-gutenberg-blocks-data/{slug}` - filters data in each block with slug name `{slug}`
```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-data/some_block', function( $context ){
	$context['fields']['title'] = 'New cool title';

	return $context;
} );
```

`timber/acf-gutenberg-blocks-data/{block_id}` - filters data in block with block id `{block_id}`
```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-data/block_5d6ed05b6b931', function( $context ){
	$context['fields']['title'] = 'New cool title';

	return $context;
} );
```
