Dimensional Weight Attributes
=============================


#### Contents
*   [Synopsis](#syn)
*   [Overview](#over)
*   [Installation](#install)
*   [Tests](#tests)
*   [Contributors](#contrib)
*   [License](#lic)


## <a name="syn"></a>Synopsis

A Magento 2 utility module that allows users to select and install dimensional attributes.

## <a name="over"></a>Overview

Dimensional Weight Attributes is a module that allows users to select and install dimensional attributes,
so that they could be used by other modules.

## <a name="install"></a>Installation

Below, you can find two ways to install the dimensional weight attributes module.

### 1. Install via Composer (Recommended)
First, make sure that Composer is installed: https://getcomposer.org/doc/00-intro.md

Make sure that Packagist repository is not disabled.

Run Composer require to install the module:

    php <your Composer install dir>/composer.phar require shopgo/dimensional-weight-attributes:*

### 2. Clone the dimensional-weight-attributes repository
Clone the <a href="https://github.com/shopgo-magento2/dimensional-weight-attributes" target="_blank">dimensional-weight-attributes</a> repository using either the HTTPS or SSH protocols.

### 2.1. Copy the code
Create a directory for the dimensional weight attributes module and copy the cloned repository contents to it:

    mkdir -p <your Magento install dir>/app/code/ShopGo/DimensionalWeightAttributes
    cp -R <dimensional-weight-attributes clone dir>/* <your Magento install dir>/app/code/ShopGo/DimensionalWeightAttributes

### Update the Magento database and schema
If you added the module to an existing Magento installation, run the following command:

    php <your Magento install dir>/bin/magento setup:upgrade

### Verify the module is installed and enabled
Enter the following command:

    php <your Magento install dir>/bin/magento module:status

The following confirms you installed the module correctly, and that it's enabled:

    example
        List of enabled modules:
        ...
        ShopGo_DimensionalWeightAttributes
        ...

## <a name="tests"></a>Tests

TODO

## <a name="contrib"></a>Contributors

Ammar (<ammar@shopgo.me>)

## <a name="lic"></a>License

[Open Source License](LICENSE.txt)
