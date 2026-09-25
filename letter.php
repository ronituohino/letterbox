<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php
            $db = new PDO("sqlite:" . __DIR__ . "/db.sqlite");

            $letter = $_POST['letter'];
            if (is_string($letter) && strlen($letter) > 0) {
                $insert = $db->prepare("INSERT INTO letters (letter) VALUES (:letter)");
                $insert->execute(['letter' => $_POST['letter']]);
            }
            
            header('Location: /hello.php');
        ?>
    </body>
</html>