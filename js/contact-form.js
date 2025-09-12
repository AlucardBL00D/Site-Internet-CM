document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne le formulaire de contact peu importe le chemin de l'action
    const form = document.getElementById('contactForm');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        // Récupère dynamiquement le chemin d'action du formulaire
        let action = form.getAttribute('action');
        fetch(action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            let match = data.match(/alert\(['"](.+?)['"]\)/);
            if (match) {
                alert(match[1]);
            } else {
                alert(data);
            }
            form.reset();
        })
        .catch(() => {
            alert('Erreur lors de l\'envoi du message.');
        });
    });
});
