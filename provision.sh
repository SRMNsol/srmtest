#!/usr/bin/env bash

# variables
SERVER_TIMEZONE="Europe/Madrid"
APP_ROOT="/var/www/app"
MYSQLDUMP="$APP_ROOT/data/beesavy_dev.sql"
HOST_IP=`route -n | grep UG | grep -Eo '[1-9][0-9]*\.[0-9]+\.[0-9]+\.[0-9]+'`

# set timezone
echo $SERVER_TIMEZONE | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

# update package list
apt-get update

# apache
apt-get install -y apache2
a2enmod rewrite ssl
service apache2 restart

# memcache
apt-get install memcached

# php
apt-get install -y php5 php-apc php5-mysql php5-sqlite php5-json php5-intl php5-curl php5-memcache php5-xdebug

cat <<CONF > /etc/php5/mods-available/app.ini
date.timezone = $SERVER_TIMEZONE
display_errors = 1
xdebug.max_nesting_level = 250
xdebug.remote_enable = 1
xdebug.remote_host = $HOST_IP
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

# https
# https://www.digitalocean.com/community/tutorials/how-to-create-a-ssl-certificate-on-apache-for-ubuntu-14-04
# http://crohr.me/journal/2014/generate-self-signed-ssl-certificate-without-prompt-noninteractive-mode.html
openssl genrsa -des3 -passout pass:x -out server.pass.key 2048
openssl rsa -passin pass:x -in server.pass.key -out server.key
openssl req -new -key server.key -out server.csr -subj '/C=ES/ST=BCN/L=BCN/O=DEV/OU=DEV/CN=localhost'
openssl x509 -req -days 365 -in server.csr -signkey server.key -out server.crt
rm server.pass.key server.csr
mv server.crt /etc/ssl/certs/
mv server.key /etc/ssl/private/

# front-end web (https)
cat <<CONF > /etc/apache2/sites-available/001-app.conf
<VirtualHost *:443>
  DocumentRoot "$APP_ROOT/legacy/public"
  SetEnv APP_ENV devel
  <Directory "$APP_ROOT/legacy/public">
    AllowOverride All
    Require all granted
  </Directory>

  SSLEngine on
  SSLCertificateFile /etc/ssl/certs/server.crt
  SSLCertificateKeyFile /etc/ssl/private/server.key
  <FilesMatch "\.php$">
    SSLOptions +StdEnvVars
  </FilesMatch>
  BrowserMatch "MSIE [2-6]" nokeepalive ssl-unclean-shutdown downgrade-1.0 force-response-1.0
  BrowserMatch "MSIE [17-9]" ssl-unclean-shutdown
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

# s3cmd
apt-get install -y s3cmd

# avoid time synchronization issues with Amazon S3
# http://digitalsanctum.com/2009/08/22/solved-time-synchronization-issues-with-amazon-s3/
ntpdate ntp.ubuntu.com
