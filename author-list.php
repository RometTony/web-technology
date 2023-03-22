<?php
include 'author-file.php';

$conn = getConnection();
$contents = $conn->prepare('SELECT * FROM authors');
$contents->execute();
$coding = $_GET['new'] ?? '';
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>Author List</title>
</head>
<body id="author-list-page">

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

                <td class="title-class">Eesnimi</td>
                <td class="author-class">Perekonnanimi</td>
                <td>Hinne</td>
            </tr>
            <?php foreach ($contents as $item): ?>
                <tr>
                    <td>
                        <a href="author-add.php?getID=<?php echo $item['id']?>"><?= $item['firstName'] ?></a>

                    </td>
                    <td><?= $item['lastName'] ?></td>

                    <td>
                        <?php
                        $i = 0;
                        $j = 5;
                        while ($item['grade'] > $i){
                            echo "<span class=span-full>&#9733;</span>";
                            $i++;
                        }
                        while ($i < $j){
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
