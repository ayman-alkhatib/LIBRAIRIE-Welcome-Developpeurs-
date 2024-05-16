//MODIFIER UN MEMBRE
function editEquipier (btnEdit, name, poste, description, photo){
    const bouton = document.getElementById(btnEdit);
    bouton.addEventListener('click', function() {
        // Saisir les nouveaux détails
        const nouvelleImage = prompt("Entrez l'url de la nouvelle image :")
        const nouveauNom = prompt("Entrez le nouveau nom :");
        const nouveauPoste = prompt("Entrez le nouveau poste :");
        const nouvelleDescription = prompt("Entrez la nouvelle description :");

        //Récupérer les éléments du HTML    
        const ancienImg = document.getElementById(photo)
        const ancienNom = document.getElementById(name);
        const ancienPoste = document.getElementById(poste);
        const ancienneDescription = document.getElementById(description);

        // Vérifier si l'utilisateur a entré des détails valides
        if (nouvelleImage !== null && nouvelleImage !== "" &&
        nouveauNom !== null && nouveauNom !== "" &&
        nouveauPoste !== null && nouveauPoste !== "" &&
        nouvelleDescription !== null && nouvelleDescription !== "") {
            // Modifier les détails de la personne dans l'équipe
            ancienNom.textContent = nouveauNom;
            ancienPoste.textContent = nouveauPoste;
            ancienneDescription.textContent = nouvelleDescription;
            ancienImg.setAttribute("src",nouvelleImage)
        } else {
            // Afficher un message si des détails valides n'ont pas été entrés
            alert("Veuillez entrer des détails valides pour la personne.");
        }
    });
}

editEquipier("paige-btn-edit", "paige-name", "paige-poste", "paige-description", "paige-photo");
editEquipier("lex-btn-edit", "lex-name", "lex-poste", "lex-description", "lex-photo");
editEquipier("belle-btn-edit", "belle-name", "belle-poste", "belle-description", "belle-photo");

// SUPPRIMER UN MEMBRE
function supprEquipier (btnSuppr, idMembre) {
    //Récupère le bouton
    const suppr = document.getElementById(btnSuppr);
    //Récupère la div equipier avec l'id correspondant
    const idSuppr = document.getElementById(idMembre);
    //Ecoute le bouton
    suppr.addEventListener('click', function() {
        //Si on valide la confirmation
        if (window.confirm("Voulez vraiment tuer cet animal si mignon?")) {
            //Supprime la div
        idSuppr.remove();
        }
    });
}

supprEquipier("paige-btn-suppr", "paige");
supprEquipier("lex-btn-suppr", "lex");
supprEquipier("belle-btn-suppr", "belle");


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
    const photo = document.getElementById('photo-url').value

    // Création d'un nouveau bloc HTML avec les données du nouveau membre
    const newMemberHTML = `
        <div class="equipier" id="new">
            <div class="equipier-photo">
            <img src="${photo}" alt="new-photo" id="new-photo" />
            </div>
            <h2 id="new-name">${fullName}</h2>
            <h3 id="new-poste">${poste}</h3>
            <p id="paige-description">${description}</p>
            <button id="new-button-edit">Modifier</button>
            <button id="new-btn-suppr">Supprimer</button>
        </div>
    `;

    // Sélection de la section de l'équipe dans le DOM
    const equipeContenu = document.querySelector('.equipe-contenu');

    // Insertion du nouveau bloc dans la section de l'équipe
    equipeContenu.innerHTML += newMemberHTML;
    //Rendre le nouveau membre modifiable
    editEquipier("new-button-edit", "new-name", "new-poste", "new-description", "new-photo");
    //Rendre le nouveau membre supprimable
    supprEquipier("new-btn-suppr", "new");
  

    // Réinitialisation du formulaire après soumission
    form.reset();
});



