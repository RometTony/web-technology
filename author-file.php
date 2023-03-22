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

if(isset($_POST['submitButton']) && $ID == '')
{
    $stmt = $conn->prepare('INSERT INTO authors (firstName, lastName, grade) VALUES (:firstName, :lastName, :grade)');
    $stmt->bindValue(':firstName', htmlspecialchars($_POST['firstName'], ENT_QUOTES));
    $stmt->bindValue(':lastName', htmlspecialchars($_POST['lastName'], ENT_QUOTES));
    if ($_POST['grade'] != '' && is_numeric($_POST['grade'])) {
        $stmt->bindValue(':grade', htmlspecialchars($_POST['grade'], ENT_QUOTES));
    } else {
        $stmt->bindValue(':grade', 0);
    }
    $stmt->execute();
    if (strlen($_POST['firstName']) < 1 ||
        strlen($_POST['firstName']) > 21 ||
        strlen($_POST['lastName']) < 2 || strlen($_POST['lastName']) > 22) {
        header('Location: author-add.php?getID=' . $conn->lastInsertId());
    } else {
        header('Location: author-list.php?new=add');
    }
}

if (isset($ID)) {
    $line = $ID;

    if (isset($_POST['submitButton']) && $ID != '' &&
        strlen($_POST['firstName'] ?? '') >= 1 &&
        strlen($_POST['firstName'] ?? '') < 22 &&
        strlen($_POST['lastName'] ?? '') > 1 &&
        strlen($_POST['lastName'] ?? '') < 23)
    {
        $changedLine = $conn->prepare('UPDATE authors SET firstName = :firstName, lastName = :lastName, grade = :grade WHERE id = :id');
        $changedLine->bindValue(':firstName', htmlspecialchars($_POST['firstName'], ENT_QUOTES));
        $changedLine->bindValue(':lastName', htmlspecialchars($_POST['lastName'], ENT_QUOTES));
        if ($_POST['grade'] != '' && is_numeric($_POST['grade'])) {
            $changedLine->bindValue(':grade', htmlspecialchars($_POST['grade'], ENT_QUOTES));
        } else {
            $changedLine->bindValue(':grade', 0);
        }
        $changedLine->bindValue(':id', $line);
        $changedLine->execute();
        header('Location: author-list.php?new=change');
    }
    elseif (isset($_POST['deleteButton'])) {
        $delete = $conn->prepare('DELETE FROM authors WHERE id = :id');
        $delete->bindValue(':id', $line);
        $delete->execute();
        header('Location: author-list.php?new=delete');
    }
}
