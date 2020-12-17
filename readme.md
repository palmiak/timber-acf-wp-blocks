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
- [Kuba Mikita](https://github.com/Kubitomakita)
- [LandWire](https://github.com/landwire)
- [Viktor Szépe](https://github.com/szepeviktor)


## Creating blocks
Add twig templates to `views/blocks` which get and use ACF data. Each template requires a comment block with some data in it:
```twig
{#
  Title: Testimonial
  Description: Customer testimonial
  Category: formatting
  Icon: admin-comments
  Keywords: testimonial quote "customer testimonial"
  Mode: edit
  Align: left
  PostTypes: page post
  SupportsAlign: left right
  SupportsMode: false
  SupportsMultiple: false
#}

<blockquote data-{{ block.id }}>
    <p>{{ fields.testimonial }}</p>
    <cite>
      <span>{{ fields.author }}</span>
    </cite>
</blockquote>

<style type="text/css">
  [data-{{ block.id }}] {
    background: {{ fields.background_color }};
    color: {{ fields.text_color }};
  }
</style>
```

## Timber 2.0
**Timber ACF WP Blocks** is fully compatible with both **Timber 1.x** and **Timber 2.x** versions.
