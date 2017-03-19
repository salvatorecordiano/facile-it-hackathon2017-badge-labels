#!/bin/bash
docker build -t hackathon-php-cli . --no-cache
docker run -it -v `pwd`/project:/home hackathon-php-cli /bin/bash -c "composer install"
