function handleCredentialResponse(response) {
    payload = parseJwt(response.credential);
    post('signin.php', {google_id: payload.sub, google_name: payload.name, google_email: payload.email});
}

function parseJwt(token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');

    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
};
  
window.onload = function () {
    google.accounts.id.initialize({
        client_id: "843031511733-8c8qd8eh5vugf0m3ujaitsc43lcbaipp.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });
    google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        {
            ux_mode: "popup",
            theme: "outline",
            size: "large",
            shape: "pill",
            logo_alignment: "center",
            locale: "de-CH"
        }  // customization attributes
    );
    google.accounts.id.prompt(); // also display the One Tap dialog
}

function post(path, params, method='post') {
    const form = document.createElement('form');
    form.method = method;
    form.action = path;
  
    for (const key in params) {
      if (params.hasOwnProperty(key)) {
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = key;
        hiddenField.value = params[key];
  
        form.appendChild(hiddenField);
      }
    }
  
    document.body.appendChild(form);
    form.submit();
}