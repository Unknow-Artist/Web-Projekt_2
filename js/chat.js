var conversation_id = 1;
let listItems = document.getElementsByClassName("list-group-item");

updateMessages(conversation_id);

for(let i = 0; i < listItems.length; i++) {
    listItems[i].addEventListener("click", highlightListItem);
}

function highlightListItem() {
    for(let i = 0; i < listItems.length; i++) {
        listItems[i].classList.remove("active");
    }
    this.classList.add("active");
    updateMessages(1);
}

function updateMessages(conversation_id) {
    requestData('php/getMessages.php?id=' + conversation_id, 'chat-messages');
};

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