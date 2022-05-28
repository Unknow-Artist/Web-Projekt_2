<?php
session_start();
require_once __DIR__ . '/functions.php';

$inhalt = array();
$db = getDb();
$conversation_id = $_GET["id"];

$messages = $db -> prepare("SELECT * FROM message WHERE conversation_id = :conversation_id ORDER BY id DESC");
$messages -> bindParam(':conversation_id', $conversation_id);
$messages -> execute();

foreach ($messages as $message) {
	$diff = date_diff(date_create($message["created"]), date_create(date("Y-m-d"))) -> format("%a");
	if ($diff == 0) $created = "Heute um " . date("H:i", strtotime($message["created"]));
	else $created = date("d.m.Y", strtotime($message["created"]));

	if ($message["sender_id"] == $_SESSION["user_id"]) {
		$alignment = 'align-self-end';
		$color = 'text-bg-primary';
		$border = 'border-radius: 15px 0 15px 15px;';
		$deleteButton = '<i class="bi bi-trash"></i>';
	}
	else {
		$alignment = '';
		$color = 'text-bg-secondary';
		$border = 'border-radius: 0 15px 15px 15px;';
		$deleteButton = '';
	}

	$userData = getUserData($message["sender_id"]);
	$inhalt .= <<<MESSAGE
	<div class="message px-3 py-2 $alignment $color" style="$border">
		<div class="d-flex flex-row justify-content-between">
			<strong>$userData[username]</strong>
			<span>$created</span>
		</div>
		<p class="m-0 fw-normal text-wrap">$message[text]</p>
	</div>
	MESSAGE;
}
echo $inhalt;
?>