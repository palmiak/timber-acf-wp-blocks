# What is it?

Generate ACF Gutenberg blocks just by adding templates to your Timber theme. This package is based heavily on [this article](https://medium.com/nicooprat/acf-blocks-avec-gutenberg-et-sage-d8c20dab6270) by [nicoprat](https://github.com/nicooprat) and the [plugin](https://github.com/MWDelaney/sage-acf-wp-blocks) by [MWDelaney](https://github.com/MWDelaney).

You can simply add blocks ACF Blocks by using comments in your twig files:

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
```
