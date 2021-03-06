<?php
session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;

require_once __DIR__ . '/functions.php';

$db = getDb();
$conversation_id = $_SESSION['conversation_id'];

$messages = $db -> prepare("SELECT id, sender_id, text, created FROM message WHERE conversation_id = :conversation_id ORDER BY id DESC");
$messages -> execute([':conversation_id' => $conversation_id]);

foreach ($messages as $message) {
	$user = getUserById($message["sender_id"]);
	$date = date("d.m.Y", strtotime($message["created"]));
	$time = date("H:i", strtotime($message["created"]));

	if (date("d.m.Y", strtotime($message["created"])) == date("d.m.Y")) {
		$date = "Heute um " . $time;
	} else if (date("d.m.Y", strtotime($message["created"])) == date("d.m.Y", strtotime("-1 day"))) {
		$date = "Gestern um " . $time;
	}

	if ($message["sender_id"] == $_SESSION["user_id"]) {
		echo <<<MESSAGE
		<div class="message px-3 py-2 align-self-end text-bg-primary" style="border-radius: 15px 0 15px 15px;">
			<div class="d-flex flex-row justify-content-between">
				<strong>$user[username]</strong>
				<span class="hide">$date</span>
				<div id="editButtons">
					<i class="bi bi-trash" onclick="deleteMessage($message[id])"></i>
				</div>
			</div>
			<p class="m-0 fw-normal text-wrap">$message[text]</p>
		</div>
		MESSAGE;
	} else {
		echo <<<MESSAGE
		<div class="message px-3 py-2 align-self-start text-bg-secondary" style="border-radius: 0 15px 15px 15px;">
			<div class="d-flex flex-row justify-content-between">
				<strong>$user[username]</strong>
				<span>$date</span>
			</div>
			<p class="m-0 fw-normal text-wrap">$message[text]</p>
		</div>
		MESSAGE;
	}
}

$db = null;
?>