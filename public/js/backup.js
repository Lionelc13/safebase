// Sélectionne tous les éléments ayant la classe 'btn'
const buttons = document.getElementsByClassName("delete");
console.log(buttons);

// Parcours de chaque bouton pour ajouter un écouteur d'événement
Array.from(buttons).forEach((button) => {
  button.addEventListener("click", function () {
    console.log("ID du bouton cliqué :", button.id);

    const url = `/backup/${button.id}/delete`;

    fetch(url, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Réponse du serveur :", data);
        window.location.reload(true);
      })
      .catch((error) => {
        console.error("Erreur lors de la requête :", error);
      });
  });
});
