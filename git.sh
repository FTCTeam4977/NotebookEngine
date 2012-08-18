#!/bin/bash
echo "Content-type: text/plain"
echo

cd /var/www/4977labbook/EngineeringNotebook2012-2013
echo `git pull origin master`
cd /var/www/4977labbook
php generator.php
#chmod -R -x /var/www/4977labbook/EngineeringNotebook2012-2013
