# Timber ACF Gutenberg Blocks
Generate ACF Gutenberg blocks just by adding templates to your Timber theme. This package is based heavily on [this article](https://medium.com/nicooprat/acf-blocks-avec-gutenberg-et-sage-d8c20dab6270) by [nicoprat](https://github.com/nicooprat) and the [plugin](https://github.com/MWDelaney/sage-acf-wp-blocks) by [MWDelaney](https://github.com/MWDelaney).

## Installation
Run the following in your Timber-based theme directory:
```sh
composer require "palmiak/timber-acf-wp-blocks"
```

## Creating blocks
Add twig templates to `views/blocks` which get and use ACF data. Each template requires a comment block with some data in it:
```twig
{#
  Title:
  Description:
  Category:
  Icon:
  Keywords:
  Mode:
  Align:
  PostTypes:
  SupportsAlign:
  SupportsMode:
  SupportsMultiple:
  EnqueueStyle:
  EnqueueScript:
  EnqueueAssets:
#}
```

### Example block template

```twig
{#
  Title: Testimonial
  Description: Customer testimonial
  Category: formatting
  Icon: admin-comments
  Keywords: testimonial quote
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

## Creating ACF fields
Once a block is created you'll be able to assign ACF fields to it using the standard Custom Fields interface in WordPress.

## Read more about this
- [Easiest way for Gutenberg Blocks with Timber and ACF Blocks](https://medium.com/@maciejpalmowski/easiest-way-for-gutenberg-block-with-timber-and-acf-blocks-29cbe2fda096)
- [Prostszy sposób na Gutenberga przy użyciu ACF Blocks](https://pandify.pl/2019/06/prostszy-sposob-na-gutenberga-przy-uzyciu-acf-blocks/)
