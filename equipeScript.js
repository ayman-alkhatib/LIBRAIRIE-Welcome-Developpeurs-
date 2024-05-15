function editEquipier (btn, name, poste, description){
    document.getElementById(btn).onclick = function() {
        // Saisir les nouveaux détails
        let nouveauNom = prompt("Entrez le nouveau nom :");
        let nouveauPoste = prompt("Entrez le nouveau poste :");
        let nouvelleDescription = prompt("Entrez la nouvelle description :");

        // Vérifier si l'utilisateur a entré des détails valides
        if (nouveauNom !== null && nouveauNom !== "" &&
            nouveauPoste !== null && nouveauPoste !== "" &&
            nouvelleDescription !== null && nouvelleDescription !== "") {
            // Modifier les détails de la personne dans l'équipe
            document.getElementById(name).innerText = nouveauNom;
            document.getElementById(poste).innerText = nouveauPoste;
            document.getElementById(description).innerText = nouvelleDescription;
        } else {
            // Afficher un message si des détails valides n'ont pas été entrés
            alert("Veuillez entrer des détails valides pour la personne.");
        }
    };
}

editEquipier("tex-btn-edit", "tex-name", "tex-poste", "tex-description");
editEquipier("marge-btn-edit", "marge-name", "marge-poste", "marge-description");
editEquipier("isaac-btn-edit", "isaac-name", "isaac-poste", "isaac-description");
editEquipier("ash-btn-edit", "ash-name", "ash-poste", "ash-description");