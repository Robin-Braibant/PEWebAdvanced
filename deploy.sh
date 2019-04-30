#!/bin/bash
scp -rp ./app cli-config.php .htaccess ./public ./resources ./sql ./composer.json ./entities_generator.php vagrant@192.168.33.22:/var/www/html/
