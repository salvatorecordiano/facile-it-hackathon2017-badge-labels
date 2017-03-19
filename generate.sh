#!/bin/bash

CSV_FILE=$1
COMMAND_CONFIG="php generate.php test.csv"

if [ "$CSV_FILE" != "" ]; then
    COMMAND_CONFIG="php generate.php $CSV_FILE"
fi

docker run -it -v `pwd`/project:/home -w /home hackathon-php-cli /bin/bash -c "$COMMAND_CONFIG"
