//MODIFIER UN MEMBRE
function editEquipier (btn, name, poste, description){
    let bouton = document.getElementById(btn);
    bouton.addEventListener('click', function() {
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
    });
}

editEquipier("paige-btn-edit", "paige-name", "paige-poste", "paige-description");
editEquipier("lex-btn-edit", "lex-name", "lex-poste", "lex-description");
editEquipier("belle-btn-edit", "belle-name", "belle-poste", "belle-description");
// editEquipier("ash-btn-edit", "ash-name", "ash-poste", "ash-description");


//AJOUTER UN MEMBRE
// Sélection du formulaire dans le DOM
const form = document.querySelector('.contact-form');

// Écoute de l'événement de soumission du formulaire
form.addEventListener('submit', function(event) {
    // Empêche le comportement par défaut de soumettre le formulaire
    event.preventDefault();

    // Récupération des valeurs des champs du formulaire
    const fullName = document.getElementById('full-name').value;
    const poste = document.getElementById('poste').value;
    const description = document.getElementById('description').value;

    // Création d'un nouveau bloc HTML avec les données du nouveau membre
    const newMemberHTML = `
        <div class="equipier">
            <div class="equipier-photo">
            <img src="images/equipe-images/owl.jpg" alt="owl-photo" id="owl-photo" />
            </div>
            <h2>${fullName}</h2>
            <h3>${poste}</h3>
            <p>${description}</p>
            <button>Modifier</button>
        </div>
    `;

    // Sélection de la section de l'équipe dans le DOM
    const equipeContenu = document.querySelector('.equipe-contenu');

    // Insertion du nouveau bloc dans la section de l'équipe
    equipeContenu.innerHTML += newMemberHTML;

  

    // Réinitialisation du formulaire après soumission
    form.reset();
});