document.getElementById('rendez-vous-form').addEventListener('submit', function(event) {
    const date = document.getElementById('date').value;
    const time = document.getElementById('heure').value;
    const activite = document.getElementById('activite').value;

    if (!date || !time || !activite) {
        event.preventDefault();
        alert('Veuillez remplir tous les champs avant de soumettre le formulaire.');
    }
});
