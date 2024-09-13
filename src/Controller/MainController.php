<?php
abstract class AbstractController
{
    /**
     * Afficher une vue en passant des variables
     *
     * @param string $fichier
     * @param array $data
     * @return void
     */
    public function render(string $fichier, array $data = []): void
    {
        define('ROOT', $_SERVER['DOCUMENT_ROOT']);
        extract($data);
        // On démarre le buffer de sortie
        ob_start();
        // On génère la vue
        $currentClassLowerCase = strtolower(get_class($this));
        require_once(ROOT . 'views/' . $currentClassLowerCase . '/' . $fichier . '.php');
        // On stocke le contenu dans $content
        $content = ob_get_clean();
        // On fabrique le "template"
        require_once(ROOT . 'views/layout/default.php');
    }

    /**
     * Permet de charger un modèle
     *
     * @param string $modelName
     * @return void
     */
    public function loadModel(string $modelName): void
    {
        // On va chercher le fichier correspondant au modèle souhaité
        $upperModelName = ucfirst($modelName) . 'Model';
        $propertyName = $modelName . 'Model';
        require_once(ROOT . 'models/' . $upperModelName . '.php');
        // On crée une instance de ce modèle. Ainsi la table "article" sera accessible par $this->ArticleModel
        $this->$propertyName = new $upperModelName();
    }
}
