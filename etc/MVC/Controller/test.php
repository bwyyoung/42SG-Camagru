<?php

$link = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=sva_build");
print_r($link);

print_r("HELLO WORLD");