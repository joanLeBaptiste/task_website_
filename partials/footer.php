<footer>
    <link rel="stylesheet" href="../css/style.css">
    <div class="container">
        <!-- Formulaire pour déclencher la déconnexion -->
        <form id="logoutForm" method="post" style="margin-left: 100px;">
            <button type="submit">Se déconnecter</button>
        </form>
        <p style="margin-left: 100px;">&copy; <?php echo date("Y"); ?> Système de Gestion de Tâches_Joan-Baptiste Ferrando </p>
    </div>
</footer>
</body>
<script>
    // Fonction pour supprimer le cookie JWT lors de la déconnexion
    function deleteJwtCookie() {
        document.cookie = "jwt=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    // Fonction pour obtenir la valeur d'un cookie par son nom
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    document.getElementById("logoutForm").addEventListener("submit", function(event) {
        event.preventDefault();
        deleteJwtCookie();
        fetch('../pages/logout.php', {
            method: 'POST'
        }).then(function(response) {
            return response.json(); // Convertit la réponse en JSON
        }).then(function(data) {
            if (data.message) {
                alert(data.message); // Affiche le message de succès dans une alerte
                window.location.href = "../templates/pagesLogin.php";
            } else if (data.error) {
                alert(data.error); // Affiche le message d'erreur dans une alerte
            }
        }).catch(function(error) {
            console.error('Une erreur s\'est produite :', error);
        });
    });
</script>
</html>
