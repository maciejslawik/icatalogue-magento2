[![Latest Stable Version](https://poser.pugx.org/mslwk/icatalogue-magento2/v/stable)](https://packagist.org/packages/mslwk/icatalogue-magento2)
[![License](https://poser.pugx.org/mslwk/icatalogue-magento2/license)](https://packagist.org/packages/mslwk/icatalogue-magento2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maciejslawik/icatalogue-magento2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/icatalogue-magento2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/maciejslawik/icatalogue-magento2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/icatalogue-magento2/build-status/master)

# Interactive Catalogue Magento2 extension #

The extension allows you to create interactive catalogues (flipbook-styled).

### Installation ###

##### Via Composer #####

To install the extension using Composer use the 
following commands:

```bash
 composer require mslwk/icatalogue-magento2
 php bin/magento module:enable MSlwk_ICatalogue
 php bin/magento setup:upgrade
 ```
 
##### From GitHub #####
 
You can download the extension directly from GitHub and 
put it inside `` app/code/MSlwk/ICatalogue `` directory. Then run the
following commands:

```bash
 php bin/magento module:enable MSlwk_ICatalogue
 php bin/magento setup:upgrade
 ```