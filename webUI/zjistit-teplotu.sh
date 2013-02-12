#!/bin/bash

cd /var/www/jicin-teplota/

wget -q -O - http://teplomer.jicin.cz/ | grep "<font class='aktua'>" | sed -e 's/<[^>]*>//g' | sed 's/&.*//' | sed 's/\s*//' | sed 's/\s//' | tr -d '\n' > aktualni-teplota-v-jicine.txt

echo "Posledni aktualizace teploty probehla:" `date` > posledni-aktualizace.txt             

chown www-data:www-data aktualni-teplota-v-jicine.txt posledni-aktualizace.txt

chmod a+r aktualni-teplota-v-jicine.txt posledni-aktualizace.txt


