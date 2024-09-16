<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <H1>Création d'une tache planifiée</H1>
    <form action="/cron/create" method="post">
        <div>
            <label for="nom">Nom de la tache: </label><input type="text" id="nom" name="nom" required>
        <div>
        
            <label for="iddatabase">Type de base de données :</label>
        <select name="nom" id="type">
            <?php foreach($databases as $database){ ?>
                <option value=" <?= $database['id'] ?>"><?= $database['nom']  ?></option> 
            <?php } ?>
        </select>
        </div>



        </div>
        <div>
            <label for="iddatabase">Nom database: </label><input type="text" id="iddatabase" name="iddatabase" required>
        </div>
        <div>
            <label for="datestart">Date de démarrage </label><input type="text" id="datestart" name="datestart" required>
        </div>
        <div>
            <label for="heure">Heure: </label><input type="text" id="heure" name="heure" required>
        </div>
        <div>
            <label for="port">Port: </label><input type="text" id="port" name="port" required>
        </div>
        <div>
            <button type="submit" id="Valider">Valider</button>
        </div>
    </form>
</body>
</html>
