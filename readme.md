<p align="center">
  <img src="timber-wp-acf-blocks.png">
</p>

# Timber ACF WP Blocks
Generate ACF Gutenberg blocks just by adding templates to your Timber theme. This package is based heavily on [this article](https://medium.com/nicooprat/acf-blocks-avec-gutenberg-et-sage-d8c20dab6270) by [nicoprat](https://github.com/nicooprat) and the [plugin](https://github.com/MWDelaney/sage-acf-wp-blocks) by [MWDelaney](https://github.com/MWDelaney).

## Complete documentation
[Read the complete documentation](https://palmiak.github.io/timber-acf-wp-blocks/#/)

## Contributors
This plugin is build with help of contributors:
- [roylodder](https://github.com/roylodder)
- [BrentWMiller](https://github.com/BrentWMiller)
- [Marcin Krzemiński](https://github.com/marcinkrzeminski)

## Creating blocks
Add twig templates to `views/blocks` which get and use ACF data. Each template requires a comment block with some data in it:
```twig
{#
 Block Name: (required)
 Description:
 Category:
 Icon:
 Keywords: (comma-separated)
 Post Types: 	(comma-separated)
 Mode:
 Align:
 Enqueue Style:
 Enqueue Script:
 Enqueue Assets:
 Supports Align: (comma-separated)
 Supports Anchor: (true|false)
 Supports Custom Class Name: (true|false)
 Supports Mode: (true|false)
 Supports Multiple: (true|false)
 Supports Reusable: (true|false)
#}
```
