Command-line interface
======================

**Create a user**

.. code-block:: bash

    $ php app/console fabrica:user-create username password email fullname

**Create a project**

.. code-block:: bash

    $ php app/console fabrica:project-create myproject "My project"

**Grant a user access to a project**

.. code-block:: bash

    $ php app/console fabrica:user-role-create myuser "Lead developer" myproject

**Configuration of Fabrica**

If you need to read configuration from Fabrica, please use the ``fabrica:config:show``
command:

.. code-block:: bash

    $ php app/console fabrica:config:show

    name             Fabrica
    baseline         git repositories inside your infrastructure
    ssh_access       git@example.org
    repository_path  /path/to/repositories

If you want to get a specific value:

.. code-block:: bash

    $ php app/console fabrica:config:show repository_path

    /path/to/repositories
