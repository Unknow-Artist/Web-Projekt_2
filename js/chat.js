updateApplication(1);

function updateApplication() {
    requestData('php/getContacts.php', 'contacts');
    requestData('php/getMessages.php', 'chat-messages');
}

function sendMessage(message) {
	if (message != null && message != '') {
	console.log(message);
	updateApplication();
	}
}

function switchChatGroup(id) {
	document.cookie = "selected_conversation =" + id;
	updateApplication();
}

function requestData(quelle, ziel, fehlermeldung = 'Fehler') {
	fetch(quelle)
	.then(function(response){
		if (response.ok){
			return response.text();
		}
		else{
			throw new Error(fehlermeldung);
		}
	})
	.then(function(data){
		document.getElementById(ziel).innerHTML = data;
	})
	.catch(function(error){
		console.log(error);
	});
}