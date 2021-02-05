# Demonstration

A block can be created very easily using **Timber ACF WP Blocks**.

Create a file in **views/blocks** called `testimonial.twig`.

Start by defining the [parameters](parameters.md) for the block then create the fields you'd like to use in your block using ACF. The `fields` variable is automatically populated from ACF's `get_fields()` method, so all your fields will be available automatically. You can also access the `block` variable.

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

<blockquote class="{{ classes }}" data-{{ block.id }}>
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
More functionality can be achieved easily using [filters](filters.md) to process the data before your block renders.
