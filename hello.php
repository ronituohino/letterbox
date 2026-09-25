<!DOCTYPE html>
<html>
    <head>
        <title>My Letterbox</title>
    </head>
    <body>
        The server is running on <?php echo php_uname("s"); ?>. <br />

        This page has been visited <?php
          $db = new PDO("sqlite:" . __DIR__ . "/db.sqlite");
          $db->exec("CREATE TABLE IF NOT EXISTS visits (
              id INTEGER PRIMARY KEY,
              unique_id TEXT UNIQUE
          )");
          $db->exec("CREATE TABLE IF NOT EXISTS letters (
              id INTEGER PRIMARY KEY,
              letter TEXT
          )");

          $unique_id = uniqid();
          $insert = $db->prepare("INSERT INTO visits (unique_id) VALUES (:unique_id)");
          $insert->execute(['unique_id' => $unique_id]);

          $count = $db->query("SELECT COUNT(*) FROM visits")->fetchColumn();
          echo $count;
        ?> times. <br />

        <?php date_default_timezone_set("Europe/Helsinki"); if((int)date("H") >= 9 && (int)date("H") <= 17): ?>
          <form action="letter.php" method="post">
            <label for="letter">Write me a public letter!</label>
            <input name="letter" id="letter" type="text">

            <button type="submit">Submit</button>
          </form>
        <?php else: ?>
          Letterbox is only open during business hours (9 - 17 @Helsinki time)
        <?php endif; ?> 

        <?php
          $letters = $db->query("SELECT letter FROM letters WHERE letter IS NOT NULL ORDER BY id DESC");
          foreach ($letters as $row) {
            echo '<p>' . htmlspecialchars($row['letter'], ENT_QUOTES, 'UTF-8') . '</p>';
          }
        ?>
    </body>
</html>
