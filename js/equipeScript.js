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

editEquipier("paige-btn-edit", "paige-name", "paige-poste", "paige-description");
editEquipier("lex-btn-edit", "lex-name", "lex-poste", "lex-description");
editEquipier("belle-btn-edit", "belle-name", "belle-poste", "belle-description");
// editEquipier("ash-btn-edit", "ash-name", "ash-poste", "ash-description");