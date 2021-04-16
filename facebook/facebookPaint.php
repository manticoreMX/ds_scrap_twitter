<?php
function drawPosts($filename) {
    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
    } else {
        return array('error' => 'no existe');
    }
    
    $result = [];
    $head = [];
    $fileLine = 0;
    while (($line = fgetcsv($file)) !== FALSE) {
        if ($fileLine == 0) {
            $head = $line;
        } else {
            $newPost = [];
            foreach ($line as $key => $value) {
                $newPost[$head[$key]] = $value;
            }
            $result[] = $newPost;
        }
        $fileLine++;
    }
    //echo '<pre>';
    //echo '</pre>';
    fclose($file);
    return $result;
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        //return mb_convert_encoding($d, 'UTF-8', 'Windows-1252');
        return html_entity_decode($d);
    }
    return $d;
}

$rs = drawPosts('scrap/'.$_GET['user'].'_page_posts.csv');
    echo json_encode(utf8ize($rs));