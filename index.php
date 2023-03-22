<?php
include 'book-file.php';

$newAuthorId = '';
$connection = getConnection();
//$contents = $connection->prepare('SELECT books.id, books.title, books.author_id, books.grade, books.is_read,
//       authors.firstName, authors.lastName FROM books, authors WHERE books.author_id = authors.id');
$contents = $connection->prepare('SELECT books.id, books.title, books.author_id, books.grade, books.is_read,
       authors.firstName, authors.lastName FROM books LEFT JOIN authors ON books.author_id = authors.id');
$contents->execute();
$coding = $_GET['new'] ?? '';


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>Book List</title>
    <script src="book.js" defer></script>
</head>
<body id="book-list-page">

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
                if ($coding == 'add') {
                    echo '<td id="message-block" ><b>Lisatud!</b></td>';
                } elseif ($coding == 'change') {
                    echo '<td id="message-block" ><b>Muudetud!</b></td>';
                } elseif ($coding == 'delete') {
                    echo '<td id="message-block" ><b>Kustutatud!</b></td>';
                }
                ?>
            </tr>
        </table>
        <table>
            <tr id="list">

                <td class="title-class">Pealkiri</td>
                <td class="author-class">Autorid</td>
                <td>Hinne</td>

                <td class="break header-line"></td>
            </tr>
            <?php foreach ($contents as $item): ?>
                <tr>
                    <td>
                        <a href="book-add.php?getID=<?php echo $item['id'] ?>"><?= $item['title'] ?></a>

                    </td>
                    <td>
                        <?= $item['firstName'] . " " . $item['lastName'] ?>
                    </td>

                    <td>
                        <?php
                        $i = 0;
                        $j = 5;
                        while ($item['grade'] > $i) {
                            echo "<span class=span-full>&#9733;</span>";
                            $i++;
                        }
                        while ($i < $j) {
                            echo "<span>&#9734;</span>";
                            $j--;
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </main>

    <footer>
        Romet Tony Jõenurm

    </footer>
</div>
</body>
</html>

