Develop
=======

Yay! If you're on this page, you're planning to develop Fabrica!

Requirements for development
----------------------------

* PHP 5.3 & MySQL
* A selenium server
* Compass & Sass

Selenium server is used for acceptance tests, using Behat under the hood.

Compass is used for assets management in Fabrica. When the application is
tagged and released, generated CSS from Compass are bundled inside the archive.

For local development, assets will be regenerated on the fly.

Local installation
------------------

.. code-block:: bash

    git clone git@github.com:fabrica/fabrica.git
    cd fabrica
    ./reset.sh

This will setup the development version of the project, with demo accounts. It
will add demo repositories, too.

You can connect as *alice:alice*, or any other demo account:

* alice:alice
* bob:bob
* charlie:charlie
* lead:lead
* visitor:visitor
