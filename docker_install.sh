#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerinit ]] && exit 0

set -xe

git clone https://git.php.net/repository/php-src.git
cd php-src
./buildconf
./configure --enable-mbstring

# Install phpunit, the tool that we will use for testing
curl -o /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
chmod +x /usr/local/bin/phpunit



rm -r xcache \
docker-php-ext-enable xcache
