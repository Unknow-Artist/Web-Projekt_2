updateApplication(1);

const form = document.getElementById('send-form');
const inputField = document.getElementById('send-input');
const submitButton = document.getElementById('send-button');

form.addEventListener('submit', function(event) {
	event.preventDefault();

	if (inputField.value.length === 0) return;
	
	const formData = new FormData(this);
	const url = this.action;
	const method = this.method;

	fetch(url, {
		method: method,
		body: formData
	});

	inputField.value = '';
});

inputField.addEventListener('keypress', function(event) {
	event.preventDefault();
	if (event.key == 'Enter') {
		submitButton.click();
	}
});

function updateApplication() {
    requestData('php/getContacts.php', 'contacts');
    requestData('php/getMessages.php', 'chat-messages');
}

function switchChatGroup(id) {
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