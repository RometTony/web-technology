DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS authors;
CREATE TABLE books (id INTEGER PRIMARY KEY AUTO_INCREMENT, title VARCHAR(255), author_id INTEGER, grade integer, is_read bool);
CREATE TABLE authors (id INTEGER PRIMARY KEY AUTO_INCREMENT, firstName VARCHAR(255), lastName VARCHAR(255), grade integer);

SELECT books.id, books.title, books.author_id, books.grade, books.is_read,
       authors.firstName, authors.lastName FROM books LEFT JOIN authors ON books.author_id = authors.id;