<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create database</title>
</head>
<body>
    <H1>Ajout d'une base de données</H1>
    <form action="/database/create" method="post">
        <div>
            <label for="name">Nom database: </label><input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="user">Nom d'utilisateur: </label><input type="text" id="user" name="user" required>
        </div>
        <div>
            <label for="password">Mot de passe: </label><input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="type">Type de base de données :</label>
            <select name="type" id="type">
                <option value="1">mysql</option>
                <option value="2">pgsql</option>
            </select>
        </div>

        <div>
            <label for="port">Port: </label><input type="text" id="port" placeholder="default or port number" name="port" required>
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
