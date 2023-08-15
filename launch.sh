#!/bin/bash

# Check for docker installation
if [ -x "$(command -v docker)" ]; then
    echo "Check docker already installed"
else
    echo "Please install docker"
    exit 1
fi

# Check for docker-compose installation
if [ -x "$(command -v docker-compose)" ]; then
    echo "Check docker-compose already installed"
else
    echo "Please install docker-compose"
    exit 1
fi

# Go to root folder
#cd public_html

# Set access for folder
#chmod -R 755 storage

# Exit root folder
#cd ../

docker-compose build && docker-compose up -d

# docker-compose exec php php /var/www/html/artisan migrate