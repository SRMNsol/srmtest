#!/usr/bin/env bash

# variables
SERVER_TIMEZONE="Europe/Madrid"
APP_ROOT="/var/www/app"
MYSQLDUMP="$APP_ROOT/data/beesavy_dev.sql"

# set timezone
echo $SERVER_TIMEZONE | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

# update package list
apt-get update

# apache
apt-get install -y apache2
a2enmod rewrite
service apache2 restart

# memcache
apt-get install memcached

# php
apt-get install -y php5 php-apc php5-mysql php5-sqlite php5-json php5-intl php5-curl php5-memcache

cat <<CONF > /etc/php5/mods-available/app.ini
date.timezone = $SERVER_TIMEZONE
CONF

rm /etc/php5/cli/conf.d/8*
(cd /etc/php5/cli/conf.d && ln -sf ../../mods-available/app.ini 80-app.ini)
rm /etc/php5/apache2/conf.d/8*
(cd /etc/php5/apache2/conf.d && ln -sf ../../mods-available/app.ini 80-app.ini)

# mysql
DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server
echo "Creating database"
echo "CREATE DATABASE IF NOT EXISTS app DEFAULT CHARACTER SET utf8" | mysql -uroot
if [ -f "$MYSQLDUMP" ]; then
  echo "Loading database backup"
  cat "$MYSQLDUMP" | mysql -uroot app
fi

# nodejs and modules
sudo apt-get install -y nodejs npm
npm install -g less

# assets
apt-get install -y yui-compressor jpegoptim optipng

# git
apt-get install -y git

# composer
apt-get install -y curl
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod u+x /usr/local/bin/composer

# front-end web 
cat <<CONF > /etc/apache2/sites-available/001-app.conf
<VirtualHost *:80>
  DocumentRoot "$APP_ROOT/legacy/public"
  <Directory "$APP_ROOT/legacy/public">
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
CONF
a2ensite 001-app

# admin web
cat <<CONF > /etc/apache2/sites-available/002-admin.conf
Listen 81
<VirtualHost *:81>
  DocumentRoot "$APP_ROOT/web"
  <Directory "$APP_ROOT/web">
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
CONF
a2ensite 002-admin

# composer install
(cd /var/www/app && composer install)

# reload
a2dissite 000-default
service apache2 reload
