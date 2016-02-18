#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerinit ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git -yqq
apt-get install -y phpunit

# Install phpunit, the tool that we will use for testing
curl -o /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
chmod +x /usr/local/bin/phpunit

curl -fsSL 'https://xcache.lighttpd.net/pub/Releases/3.2.0/xcache-3.2.0.tar.gz' -o xcache.tar.gz

mkdir -p xcache
tar -xf xcache.tar.gz -C xcache --strip-components=1
rm xcache.tar.gz

cd xcache
phpize
./configure --enable-xcache
make -j$(nproc)
make install

rm -r xcache \
docker-php-ext-enable xcache
