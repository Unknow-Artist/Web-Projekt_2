updateApplication();
setInterval(updateApplication, 1000);

function updateApplication() {
    requestData('php/getContacts.php', 'contacts');
    requestData('php/getMessages.php', 'chat-messages');
}

function switchChat(id) {
	fetch('php/switchChat.php?id=' + id);
	updateApplication();
}

function addUser(id) {
	fetch('php/addUser.php?id=' + id);
	const inputField = document.getElementById('search-input');
	requestData('php/search.php?username=' + inputField.value, 'search-results');
	updateApplication();
}

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
	})
	.then(respone => {
		if (respone.ok) {
			return respone.text();
		}
		else {
			throw new Error('Fehler');
		}
	});

	inputField.value = '';
});

document.getElementById('search-input').addEventListener('input', function() {
	const inputField = document.getElementById('search-input');
	requestData('php/search.php?username=' + inputField.value, 'search-results');
});

document.getElementById('search-input').addEventListener('focus', function() {
	const inputField = document.getElementById('search-input');
	requestData('php/search.php?username=' + inputField.value, 'search-results');
});

document.getElementById('search-input').addEventListener('focusout', function() {
	document.getElementById('search-results').innerHTML = '';
});

// Doge Emoji in Console
console.log("░░░░░░░░░▄░░░░░░░░░░░░░░▄░░░░\n░░░░░░░░▌▒█░░░░░░░░░░░▄▀▒▌░░░\n░░░░░░░░▌▒▒█░░░░░░░░▄▀▒▒▒▐░░░\n░░░░░░░▐▄▀▒▒▀▀▀▀▄▄▄▀▒▒▒▒▒▐░░░\n░░░░░▄▄▀▒░▒▒▒▒▒▒▒▒▒█▒▒▄█▒▐░░░\n░░░▄▀▒▒▒░░░▒▒▒░░░▒▒▒▀██▀▒▌░░░\n░░▐▒▒▒▄▄▒▒▒▒░░░▒▒▒▒▒▒▒▀▄▒▒▌░░\n░░▌░░▌█▀▒▒▒▒▒▄▀█▄▒▒▒▒▒▒▒█▒▐░░\n░▐░░░▒▒▒▒▒▒▒▒▌██▀▒▒░░░▒▒▒▀▄▌░\n░▌░▒▄██▄▒▒▒▒▒▒▒▒▒░░░░░░▒▒▒▒▌░\n▐▒▀▐▄█▄█▌▄░▀▒▒░░░░░░░░░░▒▒▒▐░\n▐▒▒▐▀▐▀▒░▄▄▒▄▒▒▒▒▒▒░▒░▒░▒▒▒▒▌\n▐▒▒▒▀▀▄▄▒▒▒▄▒▒▒▒▒▒▒▒░▒░▒░▒▒▐░\n░▌▒▒▒▒▒▒▀▀▀▒▒▒▒▒▒░▒░▒░▒░▒▒▒▌░\n░▐▒▒▒▒▒▒▒▒▒▒▒▒▒▒░▒░▒░▒▒▄▒▒▐░░\n░░▀▄▒▒▒▒▒▒▒▒▒▒▒░▒░▒░▒▄▒▒▒▒▌░░\n░░░░▀▄▒▒▒▒▒▒▒▒▒▒▄▄▄▀▒▒▒▒▄▀░░░\n░░░░░░▀▄▄▄▄▄▄▀▀▀▒▒▒▒▒▄▄▀░░░░░\n░░░░░░░░░▒▒▒▒▒▒▒▒▒▒▀▀░░░░░░░░");