// Funzione per popolare il Checkbox con i generi
function populateGenres(genres) {
    var genreContainer = document.getElementById("genreContainer");

    genres.forEach(function(genre) {
        var checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.name = "genres[]";
        checkbox.value = genre;
        checkbox.textContent = genre;

        genreContainer.appendChild(checkbox);
        genreContainer.appendChild(document.createElement("br"));
    });
}

// Recupera i generi dal tuo database utilizzando una richiesta AJAX
// E popola il Checkbox all'apertura della pagina
window.addEventListener("DOMContentLoaded", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "genres.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var genres = JSON.parse(xhr.responseText);
            populateGenres(genres);
        }
    };
    xhr.send();
});