<?php
$title = 'Create new task';
$myDescription = 'Ajout une nouvelle tache';
require "header.php";
?>
<html>

<body>
    <script src="/public/js/backup.js" type="module"></script>
    <div class="container-fluid d-flex">
        <?php require_once "NavBar.php" ?>
        <div class="d-flex flex-column w-100">
            <!-- Container pour le titre et le bouton -->
            <div class="d-flex justify-content-between mb-3">
                <h1 class="titre">Backups</h1>
                <!-- Bouton placé à l'extrême droite et légèrement en bas du titre -->
                <button type="button" id="btnajout" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary w-10">
                    Create backup +
                </button>
                <button type="button" id="btnajout" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary w-10">
                    Create task +
                </button>
            </div>

            <!-- Tableau occupant toute la largeur -->
            <div class="w-100">
                <table class="table table-dark table-striped w-100">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Backup</th>
                            <th scope="col">Version</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($backups as $backup) { ?>
                            <tr>
                                <th scope="row"><?= $backup['id'] ?></th>
                                <td><?= $backup['dbase'] ?></td>
                                <td><?= $backup['version'] ?></td>
                                <td><button class="btn btn-danger delete" type="button" id="<?= $backup['id'] ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal d'ajout de base de données -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1>Creer une sauvegarde</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/task/create" method="post">
                                <div>
                                    <label for="nom">Nom de la tache: </label><input type="text" id="nom" name="nom" required>
                                    <div>

                                        <label for="iddatabase">Base de données :</label>
                                        <select name="iddatabase" id="iddatabase">
                                            <?php foreach ($databases as $database) { ?>
                                                <option value=" <?= $database['id'] ?>"><?= $database['nom'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="datestart">Date de démarrage </label><input type="date" id="datestart" name="datestart" required>
                                </div>
                                <div>
                                    <label for="heure">Heure: </label><input type="time" id="heure" name="heure" required>
                                </div>
                                <div>
                                    <label for="recurrence">Récurrence: </label><input type="text" id="recurrence" name="recurrence" required>
<<<<<<< HEAD
                                </div>
                                <div>
                                    <button type="submit" id="Valider">Valider</button>
                                </div>
=======
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="Valider">Save changes</button>
                            </div>
>>>>>>> ad7f091a1a9df196286c493db6ac63ebb013fae7
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="Valider">Save changes</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>