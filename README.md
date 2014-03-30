FATECA
================================

FATECA is a library collection manager build uppon [CakePHP](http://www.cakephp.org) and based on the needs of [Fatec Itapetininga](http://fatecitapetininga.edu.br).

**Still in development**

Feel free to contribute and free to use.

**Build Status:** [![Build Status](https://travis-ci.org/gpedote/fateca.png?branch=master)](https://travis-ci.org/gpedote/fateca)

### Installation
------------------------------------------

**Step 1**

	git clone --recursive https://github.com/gpedote/fateca.git

**Step 2**

	git submodule update --init

**Step 3**

Follow [Cake Installation](http://book.cakephp.org/2.0/en/installation.html) steps.

**Step 4**

Ensure that you have a connection with your database then go to app folder and execute:

	./Console/cake schema create

### Contributing
------------------------------------------

If you would like to contribute, clone the source on GitHub, make your changes and send me a pull request.
If you are unable to fix the issue, create a ticket and we'll see what happens from there.

### Requirements
------------------------------------------

* [XAMPP](http://www.apachefriends.org/en/xampp.html) - **It isn't a requirement, but strongly recommended**
* [PHP 5.2+](http://php.net/)
* [MySQL 5.6+](http://www.mysql.com/)
* [CakePHP 2.4+](http://www.cakephp.org) - lib folder
* [CakeDC Search plugin](http://github.com/CakeDC/search) - Submodule
* [MarkStory AclExtras plugin](https://github.com/markstory/acl_extras) - Submodule
* [CakeStrap Theme](https://github.com/Rhym/cakeStrap) - Integrated on code

License and Authors
-------------------
Author: Gabriel Pedote

[MIT LICENSE](LICENSE.md)

[![Cake Power](https://raw.github.com/cakephp/cakephp/master/lib/Cake/Console/Templates/skel/webroot/img/cake.power.gif)](http://www.cakephp.org)
