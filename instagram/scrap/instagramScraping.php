<?php
$scrap = shell_exec("instagram-scraper ".$_GET["user"]." -u bearsolutions88 -p BearSolutions --media-metadata -m 25 -t none");
echo "1".$scrap;