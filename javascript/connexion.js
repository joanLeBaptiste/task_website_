function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function send() {
    document.getElementById("submitButton").disabled = true;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const user = { email: email, password: password };

    const body = JSON.stringify(user);

    fetch("../pages/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: body
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error(`Erreur HTTP ${response.status}`);
            }
        })
        .then(data => {
            const token = data.jwt;
            const message = data.message;
            console.log("Token: " + token+ "message"+message);
            alert(message+token);
            const now = new Date();
            const expires = new Date(now.getTime() + 3600000);
            setCookie('jwt', token, 1);
            console.log("Cookie: " + document.cookie);
            window.location.href = "dashboard.php";
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
            alert(`Erreur lors de la connexion: ${error.message}`);
        });
}