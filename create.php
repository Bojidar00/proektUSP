<!DOCTYPE html>
<html>
    <head>
        <title>Page</title>
    </head>

<body>
<?php

$host= 'localhost';
$dbUser= 'root'; 
$dbPass= ''; 

if(!$dbConn=mysqli_connect($host, $dbUser, $dbPass)) {
 die('Не може да се осъществи връзка със сървъра.');
}
 $sql = 'CREATE Database avtomobili';
 if (!$queryResource=mysqli_query($dbConn,$sql))
 {
    die ('Грешка при създаване на базата данни: ');
 }
 
 include "config.php";

 $sql2 ="CREATE TABLE koli
 (
   id_kola   INTEGER AUTO_INCREMENT NOT NULL ,
   id_model  INTEGER NOT NULL ,
   snimka    VARCHAR (60),
   PRIMARY KEY (id_kola)
 )  ENGINE=INNODB DEFAULT CHARSET=utf8;
 ";
    $result = mysqli_query($dbConn,$sql2);
    if(!$result)
    die('Грешка при създаване на таблица koli.');
    echo "Таблицa koli е създадена!"; 

    $sql3 ="CREATE TABLE ekstri
    ( ekstra VARCHAR (50) , id_ekstra INTEGER AUTO_INCREMENT NOT NULL,
    PRIMARY KEY ( id_ekstra)
    )   ENGINE=INNODB DEFAULT CHARSET=utf8;
 ";
    $result = mysqli_query($dbConn,$sql3);
    if(!$result)
    die('Грешка при създаване на таблица ekstri.');
    echo "Таблицa ekstri е създадена!"; 

    $sql4 ="CREATE TABLE koli_ekstri
    (
      id_kola   INTEGER NOT NULL ,
      id_ekstra INTEGER NOT NULL
   
    )  ENGINE=INNODB DEFAULT CHARSET=utf8;
 ";
    $result = mysqli_query($dbConn,$sql4);
    if(!$result)
    die('Грешка при създаване на таблица koli_ekstri.');
    echo "Таблицa koli_ekstri е създадена!"; 

    $sql5 ="CREATE TABLE marka
    ( marka VARCHAR (30) , id_marka INTEGER AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id_marka)
    )  ENGINE=INNODB DEFAULT CHARSET=utf8;
 ";
    $result = mysqli_query($dbConn,$sql5);
    if(!$result)
    die('Грешка при създаване на таблица marka.');
    echo "Таблицa marka е създадена!"; 

    $sql6 ="CREATE TABLE model
    (
      model    VARCHAR (30) ,
      id_model INTEGER AUTO_INCREMENT NOT NULL ,
      id_marka INTEGER NOT NULL,
      PRIMARY KEY (id_model)
    )  ENGINE=INNODB DEFAULT CHARSET=utf8;
 ";
    $result = mysqli_query($dbConn,$sql6);
    if(!$result)
    die('Грешка при създаване на таблица model.');
    echo "Таблицa model е създадена!"; 


    $sql7 ="ALTER TABLE koli_ekstri ADD CONSTRAINT id_ekstra FOREIGN KEY ( id_ekstra ) REFERENCES ekstri ( id_ekstra ) ;
 ";
    $result = mysqli_query($dbConn,$sql7);
    if(!$result)
    die('Грешка при създаване fkey.');
    echo "fkey е създаден!"; 

    $sql8 ="ALTER TABLE koli_ekstri ADD CONSTRAINT id_kola FOREIGN KEY ( id_kola ) REFERENCES koli ( id_kola ) ;
 ";
    $result = mysqli_query($dbConn,$sql8);
    if(!$result)
    die('Грешка при създаване fkey.');
    echo "fkey е създаден!"; 

    $sql9 ="ALTER TABLE model ADD CONSTRAINT id_marka FOREIGN KEY ( id_marka ) REFERENCES marka ( id_marka ) ;
 ";
    $result = mysqli_query($dbConn,$sql9);
    if(!$result)
    die('Грешка при създаване fkey.');
    echo "fkey е създаден!"; 

    $sql10 ="ALTER TABLE koli ADD CONSTRAINT id_model FOREIGN KEY ( id_model ) REFERENCES model ( id_model ) ;
    ";
       $result = mysqli_query($dbConn,$sql10);
       if(!$result)
       die('Грешка при създаване fkey.');
       echo "fkey е създаден!"; 
    ?>

    </body>
    </html>