<?php
include 'book-file.php';
$getUserID = $_GET['getID'] ?? '';
$newTitle = '';
$newAuthor = '';
$newGrade = '';
$newIsRead = '';
$firstName = '';
$lastName = '';
$conn = getConnection();
//$contents = $conn->prepare('SELECT books.id, books.title, books.author_id,
//       books.grade, books.is_read, authors.firstName, authors.lastName FROM books, authors WHERE books.author_id = authors.id');
$contents = $conn->prepare('SELECT books.id, books.title, books.author_id, books.grade, books.is_read,
       authors.firstName, authors.lastName FROM books LEFT JOIN authors ON books.author_id = authors.id');
$contents->execute();
foreach ($contents as $item) {
    if ($item['id'] == $getUserID) {
        $newTitle = $item['title'];
        $newAuthor = $item['author_id'];
        $newGrade = $item['grade'];
        $newIsRead = $item['is_read'];
        $firstName = $item['firstName'];
        $lastName = $item['lastName'];
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
<body id="book-form-page">

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
                if (strlen($newTitle) <= 2 && $getUserID != '' || strlen($newTitle) >= 24 && $getUserID != '') {
                    echo '<td id="error-block" ><b>Nõutud pealkirja pikkus on 3 kuni 23 märki</b></td>';
                }
                ?>
            </tr>
        </table>

        <form id="input-form" method="post">

            <input name="id" type="hidden" value="">

            <div class="label"><label for="title">Pealkiri:</label></div>
            <div class="input"><input id="title" name="title" type="text" value="<?php echo $newTitle ?>"></div>

            <div class="label"><label for="author1">Autor 1:</label></div>
            <div class="input">
                <label><select id="author1" name="author1">
                        <option value=""></option>
                        <?php
                        $connection = getConnection();
                        $authorList = $connection->prepare('SELECT * FROM authors');
                        $authorList->execute();
                        foreach ($authorList as $element): ?>
                            <?php if ($getUserID != ''): ?>
                                <option <?= $element['id'] == $newAuthor ? 'selected="selected"' : ""; ?>
                                        value="<?= $element['id'] ?>"><?php echo $element['firstName'] . " " . $element['lastName'] ?></option>
                            <?php else: ?>
                                <option value="<?= $element['id'] ?>"><?php echo $element['firstName'] . " " . $element['lastName'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select></label>
            </div>

            <div class="label">Hinne:</div>
            <div class="input">
                <?php foreach (range(1, 5) as $grade): ?>
                    <label>
                        <input type="radio" name="grade"
                            <?= $grade === intval($newGrade) ? 'checked="checked"' : ""; ?>
                               value="<?= $grade ?>"/>
                    </label>
                    <?= $grade ?>

                <?php endforeach; ?>

            </div>

            <div class=" break">
            </div>

            <div class="label"><label for="read">Loetud:</label></div>
            <div class="input"><input id="read" name="isRead"
                                      type="checkbox" <?= $newIsRead ? 'checked="checked"' : ""; ?>/>
            </div>

            <div class="break"></div>

            <div class="label"></div>

            <div class="input button">
                <?php
                if ($getUserID == "" || strlen($newTitle) < 3 || strlen($newTitle) > 23) {
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

