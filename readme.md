[![Board Status](https://dev.azure.com/mpalmowski/c9c53e50-a425-4405-9d1a-d735ed0fb8e1/5f7b72aa-dbed-415b-820f-4d5db5ad1e47/_apis/work/boardbadge/68d3302a-4e9f-4fd1-9151-1f16fdf6385a)](https://dev.azure.com/mpalmowski/c9c53e50-a425-4405-9d1a-d735ed0fb8e1/_boards/board/t/5f7b72aa-dbed-415b-820f-4d5db5ad1e47/Microsoft.RequirementCategory)
<p align="center">
  <img src="timber-wp-acf-blocks.png">
</p>

# Timber ACF WP Blocks
Generate ACF Gutenberg blocks just by adding templates to your Timber theme. This package is based heavily on [this article](https://medium.com/nicooprat/acf-blocks-avec-gutenberg-et-sage-d8c20dab6270) by [nicoprat](https://github.com/nicooprat) and the [plugin](https://github.com/MWDelaney/sage-acf-wp-blocks) by [MWDelaney](https://github.com/MWDelaney).

## Complete documentation
[Read the complete documentation](https://palmiak.github.io/timber-acf-wp-blocks/#/)

## Contributors
This plugin is build with help of contributors: [roylodder](https://github.com/roylodder)

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
  SupportsAnchor:
  EnqueueStyle:
  EnqueueScript:
  EnqueueAssets:
#}
```
