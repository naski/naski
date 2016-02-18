#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerinit ]] && exit 0

set -xe

# Install exention
apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git -yqq




# Install phpunit, the tool that we will use for testing
apt-get install -y phpunit
