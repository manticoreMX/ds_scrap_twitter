<?php
$scrap = shell_exec("facebook-scraper --filename scrap/".$_GET["user"]."_page_posts.csv --encoding utf-8 --pages 6 ".$_GET["user"]);
echo "1".$scrap;