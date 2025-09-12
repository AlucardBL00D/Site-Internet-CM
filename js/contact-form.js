document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="../send_contact.php"]');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        fetch('../send_contact.php', {
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
