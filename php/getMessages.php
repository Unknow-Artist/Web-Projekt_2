<?php
session_start();

require_once __DIR__ . '/functions.php';

$db = getDb();
$conversation_id = $_COOKIE["selected_conversation"];

$messages = $db -> prepare("SELECT sender_id, text, created FROM message WHERE conversation_id = :conversation_id ORDER BY id DESC");
$messages -> bindParam(':conversation_id', $conversation_id);
$messages -> execute();

foreach ($messages as $message) {
	$diff = date_diff(date_create($message["created"]), date_create(date("Y-m-d"))) -> format("%a");
	if ($diff == 0) $created = "Heute um " . date("H:i", strtotime($message["created"]));
	else $created = date("d.m.Y", strtotime($message["created"]));

	if ($message["sender_id"] == $_COOKIE["user_id"]) {
		$alignment = 'align-self-end';
		$color = 'text-bg-primary';
		$border = 'border-radius: 15px 0 15px 15px;';
		$editButtons = '<div id="editButtons"><i class="bi bi-pencil"></i><i class="bi bi-trash"></i></div>';
	}
	else {
		$alignment = '';
		$color = 'text-bg-secondary';
		$border = 'border-radius: 0 15px 15px 15px;';
		$editButtons = '';
	}

	$userData = getUserData($message["sender_id"]);

	echo <<<MESSAGE
	<div class="message px-3 py-2 $alignment $color" style="$border">
		<div class="d-flex flex-row justify-content-between">
			<strong>$userData[username]</strong>
			<span>$created</span>
			$editButtons
		</div>
		<p class="m-0 fw-normal text-wrap">$message[text]</p>
	</div>
	MESSAGE;
}
?>