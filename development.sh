#!/usr/bin/env bash

# variables
HOST_IP=`route -n | grep UG | grep -Eo '[1-9][0-9]*\.[0-9]+\.[0-9]+\.[0-9]+'`

# php
apt-get install php5-xdebug

cat <<CONF > /etc/php5/mods-available/dev.ini
display_errors = 1
xdebug.max_nesting_level = 250
xdebug.remote_enable = 1
xdebug.remote_host = $HOST_IP
CONF

rm /etc/php5/cli/conf.d/9*
(cd /etc/php5/cli/conf.d && ln -sf ../../mods-available/dev.ini 90-dev.ini)
rm /etc/php5/apache2/conf.d/9*
(cd /etc/php5/apache2/conf.d && ln -sf ../../mods-available/dev.ini 90-dev.ini)
