# alumni_tcsn
Run npm update to fetch npm libraries and composer update to fetch Composer libraries.
You can get composer [here](https://getcomposer.org/download/) (link: https://getcomposer.org/download/).

## Key generation
Don't forget to **locally** create RSA keys (never commit them) with OpenSSL (and passphrase).

## Apache / PHP conf
Further details are in composer.json, but please make sure your web server runs on Apache 2.4+, and your version of PHP is at least 8.2+.

Your Apache vHost conf / .htaccess file should determine DocumentRoot to this location: /var/www/alumni_tcsn/public. If you use a different directory, please refer to "Configuring .env" section.

## Configuring .env
Your .env file should look like this:
```
APP_ENV=dev
APP_DEBUG=true

# Database configuration
DB_HOST=localhost
DB_NAME=DB_name
DB_USER=username
DB_PASSWORD=password
DB_PORT=3306

# App configuration
APP_URL=http://alumni.localhost/
APP_DIR=/path/to/dir/website

# Paths to keys
PRIVATE_KEY_PATH=/path/to/public/key.pem
PRIVATE_KEY_PASSPHRASE=Louvre (^^)
PUBLIC_KEY_PATH=/path/to/private/key.pem

# JWT token Cookie
COOKIE_DOMAIN=alumni.localhost
```

You are free to change the name of the directory by whatever you want.

## Doctrine conf
Before testing, make sure Doctrine has the access to your DB (with .ENV entries). Also run php bin/doctrine orm:schema-tool:update --dump-sql --complete to sync your DB and Doctrine schemes.

An SQL file will soon be committed so that you'll get sample entries into your DB, ready to be used & printed.

## Cautions
Always ensure you have a backup of your project (website + DB) before committing any change or before updating your DB with Doctrine.
