updateApplication();
setInterval(updateApplication, 1000);

function updateApplication() {
    requestData('php/getContacts.php', 'contacts');
    requestData('php/getMessages.php', 'chat-messages');
}

function switchChat(id) {
	fetch('php/switchChat.php?id=' + id);
}

function addUser(id) {
	fetch('php/addUser.php?id=' + id);
	search();
}

function removeUser(id) {
	fetch('php/removeUser.php?id=' + id);
	search();
}

function deleteMessage(id) {
	fetch('php/deleteMessage.php?id=' + id);
}

document.getElementById('search-input').addEventListener('input', function() {
	search();
});

document.getElementById('search-input').addEventListener('focus', function() {
	search();
});

document.getElementById('search-input').addEventListener('', function() {
	document.getElementById('search-results').innerHTML = '';
});

function requestData(url, target, errorMsg = 'Fehler') {
	fetch(url)
	.then(function(response){
		if (response.ok){
			return response.text();
		}
		else{
			throw new Error(errorMsg);
		}
	})
	.then(function(data) {
		document.getElementById(target).innerHTML = data;
	})
	.catch(function(error) {
		console.log(error);
	});
}

document.getElementById('send-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const inputField = document.getElementById('send-input');
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

document.getElementById('new-form').addEventListener('submit', function(event) {
	event.preventDefault();

	const inputField = document.getElementById('new-input');
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

function search() {
	const results = document.getElementById('search-results');
	const form = document.getElementById('search-form');

	const formData = new FormData(form);
	const url = form.action;
	const method = form.method;

	fetch(url, {
		method: method,
		body: formData
	})
	.then(function(response){
		if (response.ok){
			return response.text();
		}
		else{
			throw new Error(errorMsg);
		}
	})
	.then(function(data) {
		results.innerHTML = data;
	});
}

// Doge Emoji in Console
console.log("░░░░░░░░░▄░░░░░░░░░░░░░░▄░░░░\n░░░░░░░░▌▒█░░░░░░░░░░░▄▀▒▌░░░\n░░░░░░░░▌▒▒█░░░░░░░░▄▀▒▒▒▐░░░\n░░░░░░░▐▄▀▒▒▀▀▀▀▄▄▄▀▒▒▒▒▒▐░░░\n░░░░░▄▄▀▒░▒▒▒▒▒▒▒▒▒█▒▒▄█▒▐░░░\n░░░▄▀▒▒▒░░░▒▒▒░░░▒▒▒▀██▀▒▌░░░\n░░▐▒▒▒▄▄▒▒▒▒░░░▒▒▒▒▒▒▒▀▄▒▒▌░░\n░░▌░░▌█▀▒▒▒▒▒▄▀█▄▒▒▒▒▒▒▒█▒▐░░\n░▐░░░▒▒▒▒▒▒▒▒▌██▀▒▒░░░▒▒▒▀▄▌░\n░▌░▒▄██▄▒▒▒▒▒▒▒▒▒░░░░░░▒▒▒▒▌░\n▐▒▀▐▄█▄█▌▄░▀▒▒░░░░░░░░░░▒▒▒▐░\n▐▒▒▐▀▐▀▒░▄▄▒▄▒▒▒▒▒▒░▒░▒░▒▒▒▒▌\n▐▒▒▒▀▀▄▄▒▒▒▄▒▒▒▒▒▒▒▒░▒░▒░▒▒▐░\n░▌▒▒▒▒▒▒▀▀▀▒▒▒▒▒▒░▒░▒░▒░▒▒▒▌░\n░▐▒▒▒▒▒▒▒▒▒▒▒▒▒▒░▒░▒░▒▒▄▒▒▐░░\n░░▀▄▒▒▒▒▒▒▒▒▒▒▒░▒░▒░▒▄▒▒▒▒▌░░\n░░░░▀▄▒▒▒▒▒▒▒▒▒▒▄▄▄▀▒▒▒▒▄▀░░░\n░░░░░░▀▄▄▄▄▄▄▀▀▀▒▒▒▒▒▄▄▀░░░░░\n░░░░░░░░░▒▒▒▒▒▒▒▒▒▒▀▀░░░░░░░░");