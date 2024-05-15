document.getElementById("edit-tex").onclick = function () {
    // Saisir les nouveaux détails
    var nouveauNom = prompt("Entrez le nouveau nom :");
    var nouveauPoste = prompt("Entrez le nouveau poste :");
    var nouvelleDescription = prompt("Entrez la nouvelle description :");

    // Vérifier si l'utilisateur a entré des détails valides
    if (nouveauNom !== null && nouveauNom !== "" &&
        nouveauPoste !== null && nouveauPoste !== "" &&
        nouvelleDescription !== null && nouvelleDescription !== "") {
        // Modifier les détails de la personne dans l'équipe
        document.getElementById("tex-name").innerText = nouveauNom;
        document.getElementById("tex-poste").innerText = nouveauPoste;
        document.getElementById("tex-description").innerText = nouvelleDescription;
    } else {
        // Afficher un message si des détails valides n'ont pas été entrés
        alert("Veuillez entrer des détails valides pour la personne.");
    }
};