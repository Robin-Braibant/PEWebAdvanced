#!/bin/bash
sshpass -p "vagrant" scp -rp ./app .htaccess ./public ./resources ./sql ./composer.json ./entities_generator.php vagrant@192.168.33.22:/var/www/html/
