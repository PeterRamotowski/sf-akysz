# Akysz Storefront Child Theme

The Akysz Storefront Child Theme is a theme with several improvements compared to the original Storefront theme

## Installation

1. Download the child theme from it's GitHub Repository [Download Akysz StoreFront Child Theme](https://github.com/PeterRamotowski/sf-akysz).
2. Goto WordPress > Appearance > Themes > Add New.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

## Features

1. Single page, fully ajaxified cart and checkout
2. Ajaxified "Add to cart" button on product's pages
3. Quantity field with larger, custom -/+ buttons
4. Simplified product's content layout, tabs has been removed
5. Checkout fields:
  - email and phone at the beginning
  - phone not required
  - removed secondary address field
  - postcode and city fields in one line
6. Mini Cart:
  - scroll to mini cart after add to cart
  - removed not needed cart button
  - details animation

## Usage

This theme is designed to be used as a child theme for the WooCommerce StoreFront theme which you can download for free below.

* [Download WooCommerce StoreFront Theme](https://wordpress.org/themes/storefront/)

## Customization

Any CSS customizations should be made through style.scss file within the /sass/ folder. 

1. Install dependencies:

```
npm install
```

2. Next, you should use command:

```
gulp build
```

to compile files or:

```
gulp watch
```

to enable compiling theme's style.css and scripts.js after each file save.
