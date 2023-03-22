<?php

const USERNAME = 'romettony';
const PASSWORD = 'a8538b';

function getConnection() : PDO {
    $host = 'db.mkalmo.eu';

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $host, USERNAME);

    return new PDO($address, USERNAME, PASSWORD);
}
$conn = getConnection();
$ID = $_GET['getID'] ?? '';
$read = $_POST['isRead'] ?? '';

if(isset($_POST['submitButton']) && $ID == '')
{
    $stmt = $conn->prepare('INSERT INTO books (title, author_id, grade, is_read) VALUES (:title, :author1, :grade, :is_read)');
    $stmt->bindValue(':title', htmlspecialchars($_POST['title'], ENT_QUOTES));
    if ($_POST['author1'] != '' && is_numeric($_POST['author1'])) {
        $stmt->bindValue(':author1', htmlspecialchars($_POST['author1'], ENT_QUOTES));
    } else {
        $stmt->bindValue(':author1', null);
    }
    if ($_POST['grade'] != '' && is_numeric($_POST['grade'])) {
        $stmt->bindValue(':grade', htmlspecialchars($_POST['grade'], ENT_QUOTES));
    } else {
        $stmt->bindValue(':grade', 0);
    }

    if ($read) {
        $stmt->bindValue(':is_read', 1);
    } else {
        $stmt->bindValue(':is_read', 0);
    }

    $stmt->execute();
    if (strlen($_POST['title']) < 3 || strlen($_POST['title']) > 23) {
        header('Location: book-add.php?getID=' . $conn->lastInsertId());
    } else {
        header('Location: index.php?new=add');
    }
}

if (isset($ID)) {
    $line = $ID;

    if (isset($_POST['submitButton']) && $ID != '' && strlen($_POST['title'] ?? '') > 2 &&
        strlen($_POST['title'] ?? '') < 24) {
        $changedLine = $conn->prepare('UPDATE books SET title = :title, author_id = :author_id, grade = :grade, is_read = :is_read WHERE id = :id');
        $changedLine->bindValue(':title', htmlspecialchars($_POST['title'], ENT_QUOTES));
        if (htmlspecialchars($_POST['author1'], ENT_QUOTES) != '' && is_numeric($_POST['author1'])) {
            $changedLine->bindValue(':author_id', htmlspecialchars($_POST['author1'], ENT_QUOTES));
        } else {
            $changedLine->bindValue(':author_id', null);
        }

        if ($_POST['grade'] != '' && is_numeric($_POST['grade'])) {
            $changedLine->bindValue(':grade', htmlspecialchars($_POST['grade'], ENT_QUOTES));
        } else {
            $changedLine->bindValue(':grade', 0);
        }
        if ($read) {
            $changedLine->bindValue(':is_read', 1);
        } else {
            $changedLine->bindValue(':is_read', 0);
        }
        $changedLine->bindValue(':id', $line);
        $changedLine->execute();
        header('Location: index.php?new=change');
    } elseif (isset($_POST['deleteButton'])) {
        $delete = $conn->prepare('DELETE FROM books WHERE id = :id');
        $delete->bindValue(':id', $line);
        $delete->execute();
        header('Location: index.php?new=delete');
    }
}
