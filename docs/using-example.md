# Using examples
From ACF 5.8.11 you can use **Example** to set example data for block previews. You can read more about this:
- [https://developer.wordpress.org/block-editor/developers/block-api/block-registration/](https://developer.wordpress.org/block-editor/developers/block-api/block-registration/)

To do this in **Timber ACF Blocks** you need to create your block like this:
```twig
{#
  Title: Testimonial
  Description: Customer testimonial
  Category: formatting
  Icon: admin-comments
  Keywords: testimonial quote "customer testimonial"
  Mode: edit
  Example: { "testimonial": "Testimonials", "author": "John Doe" }
#}

<blockquote>
    <p>{{ fields.testimonial }}</p>
    <cite>
      <span>{{ fields.author }}</span>
    </cite>
</blockquote>

```
In **Example** we only pass the fields and their values as a valid JSON.

## Using static HTML as preview
There are cases when we would like to use a static HTML as example. To do this create a file called `your-block-name-example.twig`. So if your block is called `testimonial.twig` than the example would be called `testimonial-example.twig`.

This file would like this:
```twig
<blockquote>
    <p>Testimonial</p>
    <cite>
      <span>John Doe</span>
    </cite>
</blockquote>

```

You can also create an image preview and put it like this:
```twig
<img src="https://example.com/img/testominial-preview.jpg" alt="testimonial example">
```
