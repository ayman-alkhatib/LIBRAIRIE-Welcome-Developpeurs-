function modifierEquipe
document.getElementById("edit-tex-name").onclick = function() {
    // Saisir les nouveaux détails
    let nouveauNom = prompt("Entrez le nouveau nom :");
    let nouveauPoste = prompt("Entrez le nouveau poste :");
    let nouvelleDescription = prompt("Entrez la nouvelle description :");

        // Modifiez les détails de la personne dans l'équipe
    document.getElementById("tex-name").innerText = nouveauNom;
    document.getElementById("tex-poste").innerText = nouveauPoste;
    document.getElementById("tex-description").innerText = nouvelleDescription;
    
};
