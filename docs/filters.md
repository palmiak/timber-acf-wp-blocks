# Filters

`timber/acf-gutenberg-blocks-templates` - path where you blocks are kept - default: `[ 'views/blocks' ]`

`timber/acf-gutenberg-blocks-data` - filters data in each block
```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-data', function( $context ){
	$context['fields']['title'] = 'New cool title';

	return $context;
} );
```

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

`timber/acf-gutenberg-blocks-example-identifier` - filters the example file sufix. default `-example`
Since version 1.12

```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-example-identifier', function( $sufix ){

	return '-expl';
} );
```

So the example file would be called `slug-exmpl.twig`.

`timber/acf-gutenberg-blocks-preview-identifier` - filters the preview file sufix. default `-preview`
Since version 1.12

```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-preview-identifier', function( $sufix ){

	return '-prev';
} );
```

So the preview file would be called `slug-prev.twig`.

`timber/acf-gutenberg-blocks-default-data` - sets the default block parameters
Since version 1.13

```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-default-data', function( $data ){
    $data['default'] = array(
        'post_type' => 'post',
    );
    $data['pages'] = array(
        'post_type' => 'page',
    );
	return $data;
} );
```

With this filter added - by default each block will have **post** as a post type, but if we'll add:
`DefaultData: page` to the block - it will set post type to **page**.

Of course setting a `PostType` in a block will override the default-data settings.
