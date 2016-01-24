chown -R root:www-data .

find . -type d -exec chmod 755 {} +
find . -type f -exec chmod 644 {} +

find app/logs -type d -exec chmod 775 {} +
find app/logs -type f -exec chmod 764 {} +

find app/cache -type d -exec chmod 775 {} +
find app/cache -type f -exec chmod 764 {} +

chmod 774 scripts/*
