// Sélectionne tous les éléments ayant la classe 'btn'
const buttons = document.getElementsByClassName("delete");
console.log(buttons);

// Parcours de chaque bouton pour ajouter un écouteur d'événement
Array.from(buttons).forEach(button => {
  button.addEventListener("click", function () {
    console.log("ID du bouton cliqué :", button.id);

    // Définir l'URL pour la requête DELETE (exemple : "/api/resource/{id}")
    const url = `/database/${button.id}/delete`;

    fetch(url, {
      method: "DELETE",
    })
      .then((response) => {
        if (!response.ok) {
          return response.text(); // Lire la réponse en texte brut pour le débogage
        }
          return response.json();
      })
      .then((data) => {
        console.log("Réponse du serveur :", data);
        window.location.reload(true);
      })
      .catch((error) => {
        console.error("Erreur lors de la requête :", error);
      });
  });
});
