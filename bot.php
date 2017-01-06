<?php
$access_token = 'aCFp3hvSxkxY0BhTdjaEl8xFCDa1eLhUmAJZ0SBMiP7LivPeF8dIcQyOTG/nE+OJiEiW+XscLy0tEZN2KaEg757lbVedq9Rx+8VkL/cv48pvZl0Nr16GR5AFziJeq9Ohip3XbwYXz/U3CvbbqzLpqQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

//dic
$path_log = 'lexitron.sqlite';
$db = new SQLite3($path_log);
$result = '';
$sql = "SELECT * FROM eng2thai WHERE esearch = '".$text."'";
$results = $db->query($sql);
while ($row = $results->fetchArray()) {
    $result .= '[';
    $result .= $row['ecat'];
    $result .= '] ';
    $result .= $row['tentry'];

    if($row['esyn'] != ''){
        $result .= ',<strong>';
        $result .= ' Syn. ';
        $result .= '</strong>';
        $result .= $row['esyn'];
    }

    if($row['ethai'] != ''){
        $result .= ',<strong>';
        $result .= ' See also: ';
        $result .= '</strong>';
        $result .= $row['ethai'];
    }
    //$result .= "\n";    
}
			
			
			// Build message to reply back
			$messages = [
				{
				    "type":"text",
				    "text":"Hello, user"
				},
				{
				'type' => 'text',
				'text' => $result
				}
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
