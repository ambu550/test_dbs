#!/usr/bin/env bash

composer install --no-interaction --no-suggest --no-progress 2>&1

PATH=/api/config/
FILE=$PATH.env
if [[ -f "$FILE" ]];
then
    echo "============ $FILE exists ====================="
else
    echo "============ $FILE create test .env ====================="
    cp $PATH.env.test /api/config/.env
fi


php-fpm
