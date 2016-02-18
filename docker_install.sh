#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerinit ]] && exit 0

set -xe


# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git -yqq

# Install exention
git clone https://git.php.net/repository/php-src.git
cd php-src
./buildconf
./configure --enable-mbstring

# Install phpunit, the tool that we will use for testing
apt-get install -y phpunit



rm -r xcache \
docker-php-ext-enable xcache
