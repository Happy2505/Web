<?php
require_once 'db.php';
global $pdo;

$sqlALL = "SELECT courses.id, courses.img, courses.name, courses.program, courses.cost, courses.id_teacher, teachers.name as 'teacher_name'
    FROM `courses`
    JOIN `teachers` ON courses.id_teacher = teachers.id";

$arBindsAll = [];


$sqlTeachers = "SELECT teachers.id, teachers.name from `teachers`";
$arBindsTeachers = [];
$stmtTeachers = $pdo->prepare($sqlTeachers);
$resultTeachers = $stmtTeachers->execute($arBindsTeachers);
$resultTeachers = $pdo->query($sqlTeachers)->fetchAll(PDO::FETCH_ASSOC);


if (!key_exists('clearFilter', $_GET)) {
    if (count($_GET) > 0) {
        $first = true;
        $sqlALL .= " WHERE";
        if (isset($_GET['teacher_name']) && ($teacher_name = $_GET['teacher_name'])) {
            if (!$first) $sqlALL .= " AND";
            $sqlALL .= " courses.id_teacher = :teacher_name";
            $arBindsAll['teacher_name'] = $_GET['teacher_name'];
            $first = false;
        }
        if (isset($_GET['cost']) && ($cost = $_GET['cost'])) {
            if (!$first) $sqlALL .= " AND";
            $sqlALL .= " courses.cost = :cost";
            $arBindsAll['cost'] = $_GET['cost'];
            $first = false;
        }

        if (isset($_GET['program']) && ($program = $_GET['program'])) {
            if (!$first) $sqlALL .= " AND";
            $sqlALL .= " courses.program LIKE CONCAT('%',:program,'%')";
            $arBindsAll['program'] = $_GET['program'];
            $first = false;
        }
        if (isset($_GET['name']) && ($name = $_GET['name'])) {
            if (!$first) $sqlALL .= "AND";
            $sqlALL .= " courses.name LIKE CONCAT('%',:name,'%')";
            $arBindsAll['name'] = $_GET['name'];
            $first = false;
        }
    }
}

$stmtAll = $pdo->prepare($sqlALL); //подготавливаем
$stmtAll->execute($arBindsAll);//расп
$resultAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC); //выполняем
