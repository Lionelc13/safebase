<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <H1>SafeBase</H1>

    <br>
    <br>
    <form action="/ClientDB" method="post">
        <h1>Enregistrer une nouvelle DB</h1>
        <div>
            <label for="type">type de db : </label>
            <input type="text" name="type" id="type">
        </div>
        <div>
            <label for="host">hôte : </label>
            <input type="text" name="host" id="host">
        </div>
        <div>
            <label for="port">port : </label>
            <input type="text" name="port" id="port">
        </div>
        <div>
            <label for="db_name">nom de la base de données : </label>
            <input type="text" name="db_name" id="db_name">
        </div>
        <div>
            <label for="username">user : </label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="used_type">type d'utilisation : </label>
            <input type="text" name="used_type" id="used_type">
        </div>
        <div>
            <label for="password">mot de passe : </label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">enregistrer une DB </button>
    </form>
    <br>
    <br>
    <form action="/Backup" method="post">
        <h1>créer un backup avec infos de la DB</h1>
        <div>
            <label for="type">type de db : </label>
            <input type="text" name="type" id="type">
        </div>
        <div>
            <label for="host">hôte : </label>
            <input type="text" name="host" id="host">
        </div>
        <div>
            <label for="port">port : </label>
            <input type="text" name="port" id="port">
        </div>
        <div>
            <label for="db_name">nom de la base de données : </label>
            <input type="text" name="db_name" id="db_name">
        </div>
        <div>
            <label for="username">user : </label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">mot de passe : </label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">enregistrer un backup </button>
    </form>

    <br>
    <br>
    <form action="/Backup" method="post">
        <h1>créer un backup avec juste l'id de la DB</h1>
        <!-- <div>
            <label for="dbId">Id de la db : </label>
            <input type="text" name="dbId" id="dbId">
        </div> -->
        <!-- creér un select option avec les données des DB en enregistrées -->
        <div>
            <label for="dbId">Sélectionner la Base à Backup : </label>
            <select name="dbId" id="dbId">
                <?php foreach ($DBs as $DB) : ?>
                    <option value=<?= $DB['id'] ?>><?= $DB['nom'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <button type="submit">enregistrer un backup </button>
    </form>


</body>

</html>