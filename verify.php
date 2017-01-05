<?php
$access_token = 'aCFp3hvSxkxY0BhTdjaEl8xFCDa1eLhUmAJZ0SBMiP7LivPeF8dIcQyOTG/nE+OJiEiW+XscLy0tEZN2KaEg757lbVedq9Rx+8VkL/cv48pvZl0Nr16GR5AFziJeq9Ohip3XbwYXz/U3CvbbqzLpqQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;