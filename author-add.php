<?php

include 'author-file.php';
$newFirstName = '';
$newLastName = '';
$newGrade = '';
$getUserID = $_GET['getID'] ?? '';
$conn = getConnection();
$contents = $conn->prepare('SELECT * FROM authors');
$contents->execute();
foreach ($contents as $item) {
    if ($item['id'] == $getUserID) {
        $newFirstName = urldecode($item['firstName']);
        $newLastName = urldecode($item['lastName']);
        $newGrade = urldecode($item['grade']);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>Book Add</title>
</head>
<body id="author-form-page">

<div id="main">

    <nav>
        <div>

            <a href="index.php" id="book-list-link">Raamatud</a>
            <span>|</span>
            <a href="book-add.php" id="book-form-link">Lisa raamat</a>
            <span>|</span>
            <a href="author-list.php" id="author-list-link">Autorid</a>
            <span>|</span>
            <a href="author-add.php" id="author-form-link">Lisa autor</a>

        </div>

    </nav>

    <main>
        <table>
            <tr>
                <?php
                if (strlen($newFirstName) < 1 && $getUserID != '' || strlen($newFirstName) > 21 && $getUserID != '' ||
                    strlen($newLastName) < 2 && $getUserID != '' || strlen($newLastName) > 22 && $getUserID != '') {
                    echo '<td id="error-block" ><b>Eesnimi jääb 1 ja 21 tähemärgi vahele ja
 perekonnanimi jääb 2 kuni 22 tähemärgi vahele</b></td>';
                }
                ?>
            </tr>
        </table>


        <form id="input-form" method="post">

            <input name="id" type="hidden" value="">

            <div class="label"><label for="name">Eesnimi</label></div>
            <div class="input"><input id="name" name="firstName" value="<?php echo $newFirstName ?>" type="text"></div>

            <div class="label"><label for="last-name">Perekonnanimi</label></div>
            <div class="input"><input id="last-name" name="lastName" value="<?php echo $newLastName ?>" type="text"></div>
            <div class="label">Hinne:</div>
            <div class="input">
                <?php foreach (range(1, 5) as $grade): ?>

                    <label>
                        <input type="radio" name="grade"
                            <?= $grade === intval($newGrade) ? 'checked' : ""; ?>
                               value="<?= $grade ?>"/>
                    </label>
                    <?= $grade ?>

                <?php endforeach; ?>
            </div>

            <div class="break"></div>

            <div class="label"></div>

            <div class="input button">
                <?php
                if ($getUserID == "" || strlen($newFirstName) < 1 || strlen($newFirstName) > 21 ||
                    strlen($newLastName) < 2 || strlen($newLastName) > 22) {
                    echo '<input name="submitButton" type="submit" value="Salvesta">';
                } else {
                    echo '<input name="deleteButton" class="danger" type="submit" value="Kustuta">';
                    echo '<input name="submitButton" type="submit" value="Muuda">';
                }
                ?>

            </div>

        </form>
    </main>

    <footer>
        Romet Tony Jõenurm
    </footer>

</div>
</body>
</html>
