document.addEventListener('DOMContentLoaded', function() {
    function showDetails(id) {
        var sections = document.querySelectorAll('.details');
        sections.forEach(function(section) {
            section.style.display = 'none';
        });

        var selectedSection = document.getElementById(id);
        if (selectedSection) {
            selectedSection.style.display = 'block';
        }
    }

    var buttons = document.querySelectorAll('button[name="sports"]');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var value = this.value;
            if (value == '1') {
                showDetails('activites-sportives');
            } else if (value == '2') {
                showDetails('sports-competition');
            } else if (value == '3') {
                showDetails('salle-sport-omnes');
            }
        });
    });
});

function voirCV(cvPath) {
    window.open(cvPath, '_blank');
}
