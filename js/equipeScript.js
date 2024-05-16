
//Modifier Equipier
function editEquipier (btn, name, poste, description){
    let bouton = document.getElementById(btn);
    bouton.addEventListener('click', () => {
        let nouveauNom = prompt("Entrez le nouveau nom :");
        let nouveauPoste = prompt("Entrez le nouveau poste :");
        let nouvelleDescription = prompt("Entrez la nouvelle description :");

        if (nouveauNom !== null && nouveauNom !== "" &&
            nouveauPoste !== null && nouveauPoste !== "" &&
            nouvelleDescription !== null && nouvelleDescription !== "") {
                document.getElementById(name).innerText = nouveauNom;
                document.getElementById(poste).innerText = nouveauPoste;
                document.getElementById(description).innerText = nouvelleDescription;
        } else {
                alert("Veuillez entrer des détails valides pour la personne.");
        }
    });
}

editEquipier("paige-btn-edit", "paige-name", "paige-poste", "paige-description");
editEquipier("lex-btn-edit", "lex-name", "lex-poste", "lex-description");
editEquipier("belle-btn-edit", "belle-name", "belle-poste", "belle-description");




// Ajouter un équipier
const form = document.querySelector('.contact-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    const fullName = document.getElementById('full-name').value;
    const poste = document.getElementById('poste').value;
    const description = document.getElementById('description').value;

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

    const equipeContenu = document.querySelector('.equipe-contenu');

    equipeContenu.innerHTML += newMemberHTML;

  

    // Réinitialisation du formulaire après soumission
    form.reset();
});