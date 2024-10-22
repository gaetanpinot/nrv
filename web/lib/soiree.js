window.onload = function() {

    document.querySelectorAll('.toggle').forEach(button => {
        button.onclick = function() {
            var descriptionContent = this.nextElementSibling;

            if (descriptionContent.style.display === 'none' || descriptionContent.style.display === '') {
                descriptionContent.style.display = 'block';
            } else {
                descriptionContent.style.display = 'none';
            }
        };
    });
}