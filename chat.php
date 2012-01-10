<?php
/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/


include( "config.php" );


if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { sendChat(); } 
if ($_GET['action'] == "closechat") { closeChat(); } 
if ($_GET['action'] == "startchatsession") { startChatSession(); } 

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();	
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();	
}

function chatHeartbeat() {
	global $DB;
	$sql = "select fl_messages.*, fl_users.username from fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId where (fl_messages.recipentUserId = '".(int)$_SESSION['userId']."' AND shownChat = 'NO') order by id ASC";
	$query = $DB->GetAssoc( $sql, FALSE, TRUE );
	$items = '';

	$chatBoxes = array();

	while ( list( $key, $chat ) = each( $query ) )
	{

		if (!isset($_SESSION['openChatBoxes'][$chat['username']]) && isset($_SESSION['chatHistory'][$chat['username']])) {
			$items = $_SESSION['chatHistory'][$chat['username']];
		}

		$chat['message'] = sanitize(utf8_encode($chat['message']));

		$items .= <<<EOD
					   {
			"s": "0",
			"f": "{$chat['username']}",
			"m": "{$chat['message']}"
	   },
EOD;

	if (!isset($_SESSION['chatHistory'][$chat['username']])) {
		$_SESSION['chatHistory'][$chat['username']] = '';
	}

	$_SESSION['chatHistory'][$chat['username']] .= <<<EOD
						   {
			"s": "0",
			"f": "{$chat['username']}",
			"m": "{$chat['message']}"
	   },
EOD;
		
		unset($_SESSION['tsChatBoxes'][$chat['username']]);
		$_SESSION['openChatBoxes'][$chat['username']] = $chat['insDate'];
	}

	if (!empty($_SESSION['openChatBoxes'])) {
	foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
		if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
			$now = time()-strtotime($time);
			$time = date('Y-m-d H:i:s', strtotime($time));

			$message = "Skickades $time";
			if ($now > 180) {
				$items .= <<<EOD
{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;

	if (!isset($_SESSION['chatHistory'][$chatbox])) {
		$_SESSION['chatHistory'][$chatbox] = '';
	}

	$_SESSION['chatHistory'][$chatbox] .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;
			$_SESSION['tsChatBoxes'][$chatbox] = 1;
		}
		}
	}
}


	$record = array();
	$record["shownChat"] = 'YES';
	$DB->AutoExecute( "fl_messages", $record, 'UPDATE', "recipentUserId = '".(int)$_SESSION['userId']."' AND shownChat = 'NO'"); 

	if ($items != '') {
		$items = substr($items, 0, -1);
	}
header('Content-type: application/json');
?>
{
		"items": [
			<?php echo $items;?>
        ]
}

<?php
			exit(0);
}

function chatBoxSession($chatbox) {
	
	$items = '';
	
	if (isset($_SESSION['chatHistory'][$chatbox])) {
		$items = $_SESSION['chatHistory'][$chatbox];
	}

	return $items;
}

function startChatSession() {
	global $userProfile;
	$items = '';
	if (!empty($_SESSION['openChatBoxes'])) {
		foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
			$items .= chatBoxSession($chatbox);
		}
	}


	if ($items != '') {
		$items = substr($items, 0, -1);
	}

header('Content-type: application/json');
?>
{
		"username": "<?php echo $userProfile['username'];?>",
		"items": [
			<?php echo $items;?>
        ]
}

<?php


	exit(0);
}

function sendChat() {
	global $DB;
	$from = $_SESSION['userId'];
	$to = $_POST['to'];
	$message = utf8_decode($_POST['message']);

	$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $to ) . "' AND rights > 1";
	$userKonv = $DB->GetRow( $q, FALSE, TRUE );
	

	$_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
	
	$messagesan = sanitize($message);
	$messagesanutf = utf8_encode(sanitize($message));

	if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
		$_SESSION['chatHistory'][$_POST['to']] = '';
	}

	$_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
					   {
			"s": "1",
			"f": "{$to}",
			"m": "{$messagesanutf}"
	   },
EOD;


	unset($_SESSION['tsChatBoxes'][$_POST['to']]);

	
	$record = array();
	$record["userId"] = mysql_real_escape_string($from);
	$record["recipentUserId"] = mysql_real_escape_string($userKonv["id"]);
	$record["message"] = mysql_real_escape_string($message);
	$record["newMessage"] = "YES";
	$record["insDate"] = date("Y-m-d H:i:s");
	$DB->AutoExecute( "fl_messages", $record, 'INSERT'); 

	echo "1";
	exit(0);
}

function closeChat() {

	unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
	
	echo "1";
	exit(0);
}

function sanitize($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}
?>