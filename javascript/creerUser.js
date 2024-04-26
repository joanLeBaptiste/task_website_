function creerUSer() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;

    if (password !== confirm) {
        alert("saisissez le meme mot de passe");
        return 0;
    }

    const data = {
        username: username,
        email: email,
        password: password
    };

    fetch('../pages/signup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            console.log(data);
            console.log(result.message);
            alert(result.message);
            window.location.href = "../templates/pagesLogin.php";
        })
        .catch(error => {
            console.error('Error:', error);
        });
}