# SierraTecnologia Fabrica
https://github.com/lxerxa/actionview-fe/tree/master/app/components
**SierraTecnologia Fabrica** fabrica is all of freelancer developer need. Validator functionality, and basic controller included out-of-the-box.

[![Packagist](https://img.shields.io/packagist/v/sierratecnologia/fabrica.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/sierratecnologia/fabrica)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/sierratecnologia/fabrica.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/sierratecnologia/fabrica/)
[![Travis](https://img.shields.io/travis/sierratecnologia/fabrica.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/sierratecnologia/fabrica)
[![StyleCI](https://styleci.io/repos/60968880/shield)](https://styleci.io/repos/60968880)
[![License](https://img.shields.io/packagist/l/sierratecnologia/fabrica.svg?label=License&style=flat-square)](https://github.com/sierratecnologia/fabrica/blob/master/LICENSE)

    
    public $formFields = [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
        ['name' => 'body', 'label' => 'Enter your content here', 'type' => 'textarea'],
        ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        ['name' => 'published', 'label' => 'Published', 'type' => 'checkbox'],
        ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'title',
        'category_id',
        'published'
    ];

    public $validationRules = [
        'title'       => 'required|max:255',
        'slug'        => 'required|max:100',
        'body'        => 'required',
        'publish_on'  => 'date',
        'published'   => 'boolean',
        'category_id' => 'required|int',
    ];

    public $validationMessages = [
        'body.required' => "You need to fill in the post content."
    ];

    public $validationAttributes = [
        'title' => 'Post title'
    ];
## Installation

Install via `composer require sierratecnologia/fabrica`


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](https://bit.ly/sierratecnologia-slack)
- [Help on Email](mailto:help@sierratecnologia.com.br)
- [Follow on Twitter](https://twitter.com/sierratecnologia)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [help@sierratecnologia.com.br](help@sierratecnologia.com.br). All security vulnerabilities will be promptly addressed.


## About SierraTecnologia

SierraTecnologia is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Rio de Janeiro, Brazil since June 2008. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2008-2020 SierraTecnologia, Some rights reserved.




## removi


        "sensio/distribution-bundle":        ">=2.3",

        "symfony/symfony":                   ">=2.4",
        "doctrine/orm":                      ">=2.4",
        "swiftmailer/swiftmailer":           ">=5.0",

        "doctrine/doctrine-bundle":          ">=1.2",
        "twig/extensions":                   ">=1.0",
        "symfony/assetic-bundle":            ">=2.3",
        "symfony/monolog-bundle":            ">=2.3",
        "doctrine/doctrine-fixtures-bundle": ">=2.2",
        "alexandresalome/mailcatcher":       ">=0.2",



https://github.com/kanboard