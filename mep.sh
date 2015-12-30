cd /var/www/blablafoundry
git reset --hard
git checkout master
git fetch --all
git reset --hard origin/master
php ~/composer.phar update
chmod -R 775 app/logs
chmod -R 775 app/cache
sudo -u www-data rm -r app/cache/*
