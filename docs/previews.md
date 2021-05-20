# Previews

If your preview file differs a lot from the normal block you can create a separate preview file.

To do this you need to first create a normal block - let's call it `testimonial.twig`:
```twig
{#
  Title: Testimonial
  Description: Customer testimonial
  Category: formatting
  Icon: admin-comments
  Keywords: testimonial quote "customer testimonial"
  Mode: edit
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
## Creating the preview output
Next create a `testimonial-preview.twig` file without comments at the top:
```twig
<p>This is a preview</p>
<blockquote data-{{ block.id }}>
    <p>{{ fields.testimonial }}</p>
    <cite>
      <span>{{ fields.author }}</span>
    </cite>
</blockquote>
<p>This is a preview</p>

<style type="text/css">
  [data-{{ block.id }}] {
    background: {{ fields.background_color }};
    color: {{ fields.text_color }};
  }
</style>
```
The suffix for this **preview** file can be changed using a [filter](filters.md)
