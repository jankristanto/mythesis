<?php

include_once 'IDNstemmer.php';

$word = "pemukulan";

$st = new IDNstemmer();

echo "stemming result : ".$st->doStemming($word);

?>