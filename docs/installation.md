# Installation

## Requirements
To use **Timber ACF WP Blocks** you will need:
- [Advanced Custom Fields Pro 5.8](https://www.advancedcustomfields.com) or newer
- [Timber](https://github.com/timber/timber)

## Installation
Run the following in your Timber-based theme directory
```sh
composer require "palmiak/timber-acf-wp-blocks"
```

or if want to install it as a Plugin run:
```sh
composer require "palmiak/timber-acf-wp-blocks-plugin"
```

Next you can create your blocks in your theme in **views/blocks** folder, or you can change your blocks directory with a [filter](filters.md).

> **Note**: filenames should only contain lowercase alphanumeric characters and dashes, and must begin with a letter.

When you have your blocks ready the only thing left it to create a New group in ACF and select your block in **Show this field group if** selector.
