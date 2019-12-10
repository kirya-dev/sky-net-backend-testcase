#/bin/bash

if [ "$1" == "serve" ]
then
  php -S localhost:8000 index.php
else
  php index.php "$@"
fi
