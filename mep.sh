cd /var/www/blablafoundry
git reset --hard
git checkout master
git fetch --all
git reset --hard origin/master
composer update
chmod -R 775 app/logs
sudo -u www-data rm -r app/cache/*
chmod -R 775 app/cache
