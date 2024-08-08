<!DOCTYPE html>
<?php
    // Load our links db
    $db = new SQLite3('links.db');

    // Load settings from settings db
    // For content like website title and description. (Yes, !Settings is a cursed var name)
    $results = $db->query('SELECT * FROM `!Settings`');
    $settingsDB = $results->fetchArray();

    // Build a string of the current host url. We sadly need this just for the <meta> tag.
    $sourceLink = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylen.css">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <title><?= $settingsDB['title'] ?></title>
    <? // Imbed tag for discord and etc. ?>
    <meta property="og:title" content="<?= $settingsDB['title'] ?>">
    <meta property="og:image" content="<?= $sourceLink ?>/icon.png">
    <meta property="og:description" content="<?= $settingsDB['metaDescription'] ?>">
    <meta name="theme-color" content="#7eb900">
</head>
<body>
    <?php 
        // Func to render our lists into boxes
        function genrateList($catagory, $db) {
            // We randomly order the query so no special treatment is given to one link over another.
            $results = $db->query('SELECT * FROM '.$catagory.' ORDER BY RANDOM()');
            while ($row = $results->fetchArray()) {
                // This check for music is a little backwards, but with this in this order, we guarantee there is no weirdness
                if (str_starts_with($catagory, 'music')) {
                    $parts = isset($row['link']) && !empty($row['link']) ? parse_url($row['link']) : ['host' => ''];
                    $row['tags'] = implode(' / ', json_decode($row['tags'], true));
                    echo "
                        <h3><img src=\"icons/".$row['username'].".png\"> ".$row['title']."</h3>
                        <a href=\"".$row['link']."\">".$parts['host']."</a> | <a href=\"".$row['serviceLink']."\">".$row['service']."</a><br>
                        <i>".$row['tags']."</i><br>
                        ".$row['description']."
                        <hr>";

                } else {
                    // process  our link into parts to be reused for things.
                    $parts = parse_url($row['link']);
                    //Hotfix: ugly hack to remove www prefix from websites that include them
                    //BUG: No error checking on this, if you don't put a http url into the db, it will brake.
                    $hostname = explode('.', str_replace('www.', '', $parts['host']))[0];
                    // now we have our link from the db, print it
                    // WARNING: description can and will print raw html.
                    // Means you can do formatting like <b>, <i> and <span> but also means you can do <script>...
                    echo "
                    <h3><img src=\"icons/".$hostname.".png\"> ".$row['title']."</h3>
                    <a href=\"".$row['link']."\">".$parts['host']."</a><br>
                    ".$row['description']."
                    <hr>";
                }
            }
        }

        // Func to render the column, where genrateList() will generate link lists into.
        function genrateColumn($column, $db) {
            $results = $db->query('SELECT * FROM `!MainMenu` WHERE column == '.$column.' ORDER BY row');
            while ($row = $results->fetchArray()) {
                // Sort / fix missing content
                $icon    = isset($row['icon'])   && !empty($row['icon'])   ? $row['icon']   : 'TBD';
                $title   = isset($row['title'])  && !empty($row['title'])  ? $row['title']  : 'Under construction';
                $content = isset($row['dbList']) && !empty($row['dbList']) ? $row['dbList'] : 'Under construction';

                // Print content
                echo "<div class=\"box\"><h2><img src=\"icons/".$icon.".gif\"> ".$title."</h2>";
                if ($content != 'Under construction') {
                    genrateList($content, $db);
                } else {
                    echo 'Under construction';
                }
                echo "</div>";
            }
        }
    ?>
    <? // Main site starts here ?>
    <div class="title">
        <img src="icon.png" width="48" height="48"> <h1><?= $settingsDB['title'] ?></h1>
        <div class="titleContent">
            <? // Render description from DB. WARNING: this can and will print raw html. ?>
            <?= $settingsDB['description'] ?><br>
            <a href="mailto:<?= $settingsDB['email'] ?>?subject=<?= $settingsDB['emailSubject'] ?>">Get on this list</a> | 
            <a href="https://github.com/MobCat/LinkDir">Steal this code and host it yourself. please.</a>
        </div>
    </div>
<br>
    <? // Draw our columns in the center of the screen, with data loaded from the db. ?>
    <div class="container">
        <?php // Inside our centered content "container". print the columns
        $results = $db->query("SELECT DISTINCT column FROM `!MainMenu`");
        while ($row = $results->fetchArray()) {
            echo '<div class="column">';
                genrateColumn($row['column'], $db);
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>