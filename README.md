REQUIREMENTS
Php ^7.2
check composer is installed
check yarn and node are installed

PROJECT INSTALLATION
clone the project

install dependencies:
run composer install 
run yarn install 

run yarn encore dev to build assets


LAUNCH SERVER
run symfony server:start to launch symfny server
run yarn run dev --watch to launch local server for assets

CONFIGURE DATABASE
copy .env file, rename copy to .env.local
configure database into ###> doctrine/doctrine-bundle ### 

Create database:
php bin/console d:d:c

Execute migrations:
php bin/console d:m:m
php bin/console doctrine:schema:update --force