# Filters

There a number of filters available for you to customise behaviour of your blocks. Add the following snippets of code to your theme's `functions.php`. 
## Twig Block Directory
You can customise the location of your twig blocks by applying a filter to `timber/acf-gutenberg-blocks-templates` returning a path relative to your **theme**'s root directory.
```php
add_filter( 'timber/acf-gutenberg-blocks-templates', function () {
    return ['relative/path/to/blocks']; // default: ['views/blocks']
} )
```

## Filter data to all your blocks
You can add or change data to the Timber context of all your blocks using the 
`timber/acf-gutenberg-blocks-data` filter.
```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-data', function( $context ){
	$context['fields']['extra_data'] = 'New extra data';

	return $context;
} );
```
## Filter data to specific blocks
You can also filter for a specific block based on the block's **slug** or **block ID** using the `timber/acf-gutenberg-blocks-data/{slug/block_id}` filter.
### By Slug
```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-data/example_block', function( $context ){
	$context['fields']['extra_data_for_example_block'] = 'New example block data';

	return $context;
} );
```
### By ID
```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-data/block_5d6ed05b6b931', function( $context ){
	$context['fields']['extra_data_for_block_id'] = 'This block\'s ID is block_5d6ed05b6b931';

	return $context;
} );
```

## Customising the preview/example file suffix
You can change the [example](using-example.md) or [preview](previews.md) file's suffix. 

### Example
`timber/acf-gutenberg-blocks-example-identifier` - filters the example file sufix. default `-example`
Since version 1.12

```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-example-identifier', function( $sufix ){
	return '-custom-example';
} );
```
So the example file would be called `{slug}-custom-example.twig`.

### Preview
`timber/acf-gutenberg-blocks-preview-identifier` - filters the preview file sufix. default `-preview`
Since version 1.12

```php
<?php
add_filter( 'timber/acf-gutenberg-blocks-preview-identifier', function( $sufix ){

	return '-custom-preview';
} );
```

So the preview file would be called `{slug}-custom-prev.twig`.

## Setting default parameters for all blocks

You can set a default set of parameters for all your blocks to avoid needing to specify the same thing for all your blocks, or you can create a group of defaults to be applied.

The filter `timber/acf-gutenberg-blocks-default-data` sets the default block parameters
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

With this filter added - by default each block will have **post** as a post type.
If we add `DefaultData: page` to the block's parameters it will use the `$data['pages']` parameters to set post type to **page**.

By setting a `PostType` or any other parameters in a block it will override the default settings set using this filter.
