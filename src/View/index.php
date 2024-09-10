<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <H1>Connection à une base de données</H1>
    <form action="/database/connection" method="post">
        <div>
            <label for="db-name">Nom database: </label><input type="text" id="db-name" name="db-name" required>
        </div>
        <div>
            <label for="user">Nom d'utilisateur: </label><input type="text" id="user" name="user" required>
        </div>
        <div>
            <label for="password">Mot de passe: </label><input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="type-database">Type de base: </label><input type="text" id="type-database" name="type-database" required>
        </div>
        <div>
            <label for="port">Port: </label><input type="text" id="port" name="port" required>
        </div>
        <div>
            <label for="host">URL </label><input type="text" id="host" name="host" required>
        </div>
        <div>
            <button type="submit" id="Valider">Valider</button>
        </div>
    </form>
</body>
</html>
