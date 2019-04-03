# FU KING Restaurant
Requirements:
* Ubuntu with
    - PHP 7.3
    - MySQL 14.14
    - PHP extensions xml, mbstring, mysql (pdo)
    - composer

## Installing
1. Make sure you're SSH'd into your vagrant VM, from your Vagrantfile location:
```bash
vagrant ssh
```
2. Disable whatever version of PHP you're running
```bash
sudo a2dismod php7.0
```
3. Enable PHP 7.3
```bash
sudo a2enmod php7.3
```
4. Restart apache
```bash
sudo service apache2 restart
```
## On your machine
5. Open a terminal on your own machine, make sure you're in the project root
```bash
cd /path/to/PEWebAdvanced
```
6. Deploy to your vagrant VM
```bash
deploy.sh
```
## Back to VM
7. Install your dependencies
```bash
composer install
composer update
composer -o dump-autoload
```
8. Registering the entities(models) with doctrine (ORM)
```bash
php entities_generator.php
```
9. Update to the latest migration
```bash
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```
10. Done, open a browser on address 192.168.33.22

## Developing
You do NOT have to run composer install + update again unless you
add a dependency or overwrite your vendor folder on your VM (avoid copying files via PHPStorm).
Simply make changes to the part you're working on and run the deploy.sh script.
The deploy script copies everything except the vendor file over.
You should get instant changes when you refresh the page in the browser.

Note: please do not add a c to our restaurant name, thanks in advance!
