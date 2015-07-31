# QS
A Quick Start for web developement

Requirements:
- Python
- Node
    - npm
        - bower
        - gulp
- php
    - composer
- Ruby (to install components like Bitters)

#Setup:
Go to /dev/, Revise package.json and run:
    npm install
Revise bower.json and run:
    bower install

To add an additional package:
    npm install [package name] --save-dev

edit imports in /dev/css/import.sass

##Symfony2 setup
sudo apt-get install curl
sudo apt-get install php5-curl
sudo apt-get install php5-cli

install composer globally
go to cookbook and install a new symfony2 project inside this folder

prawa symphony:
	sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
	sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
php app/console cache:clear
php app/console cache:clear --env=prod --no-debug


php app/console server:run

php app/console generate:bundle --namespace=Qn/TestBundle
php app/console generate:controller

assetic:
	config:
		bundles: ['QnTestBundle']

baza danychl
	config/parameters

	php app/console doctrine:database:create
	php app/console doctrine:database:drop --force
	php app/console doctrine:generate:entity
	php app/console doctrine:schema:update --force

	php app/console doctrine:generate:entities QnTestBundle
	php app/console doctrine:schema:update --force

Crud
    composer require sensio/generator-bundle
    php app/console generate:doctrine:crud --overwrite

Install Ladybug

#Usage:
Run gulp in /dev/
In order to change css (Sass) go to /dev/css/

#TODO
clean up .gitignore
    dodaj symfony2 gitignore
gulp
    compass?
    bower files (go over all java files supplied by bower, put them in dev and dist)
    java dependencies
    watch
    minify css
    move html files to dist and/or to symfony2 views folder
    browserify
    autoprefixer?
    fix java errors
    throw sass into browser
    java dep
    write colorpalet extractor task (regexp)
set up symfony2
    composer!
    htaccess!
    set proper permissions

#my webdev tools
Atom
    packages
Ruby (for installation of Bitters)
Python?
Node
    npm
Server
    php
    apache2
    mysql?
Winscp
Sourcetree