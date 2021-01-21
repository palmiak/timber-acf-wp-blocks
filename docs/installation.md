# Installation

## Requirements
To use **Timber ACF WP Blocks** you will need:
- [Advanced Custom Fields Pro 5.8](https://www.advancedcustomfields.com) or newer
- [Timber](https://github.com/timber/timber)

## Installation
Run the following in your Timber-based theme directory, or use `composer/installers` to [specify an installation directory](https://getcomposer.org/doc/faqs/how-do-i-install-a-package-to-a-custom-path-for-my-framework.md).
```sh
composer require "palmiak/timber-acf-wp-blocks"
```

Next you can create your blocks in your theme in **views/blocks** folder, or you can change your blocks directory with a [filter]('filters.md').

> **Note**: filenames should only contain lowercase alphanumeric characters and dashes, and must begin with a letter.



When you have your blocks ready the only thing left it to create a New group in ACF and select your block in **Show this field group if** selector.