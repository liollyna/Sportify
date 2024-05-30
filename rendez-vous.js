document.getElementById('rendez-vous-form').addEventListener('submit', function(event) {
    const date = document.getElementById('date').value;
    const time = document.getElementById('heure').value;
    const activite = document.getElementById('activite').value;

    if (!date || !time || !activite) {
        event.preventDefault();
        alert('Veuillez remplir tous les champs avant de soumettre le formulaire.');
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const creneauxDisponibles = document.querySelectorAll('.creneau-disponible');
    
    creneauxDisponibles.forEach(creneau => {
        creneau.addEventListener('click', function () {
            const dispoId = this.dataset.id;
            window.location.href = `rendez-vous.php?action=book&dispo_id=${dispoId}`;
        });
    });
});
