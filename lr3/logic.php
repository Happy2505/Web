<?php
require_once 'db.php';


session_start();

global $arBinds;
global $data;
global $errors;


function protect()
{
    if (!isset($_SESSION['loggedUser'])) {
        header('Location: login.php');
        exit;
    }
}




function filter_types()
{
    $pdo = dbConnect();
    $sqlTeachers = "SELECT teachers.id, teachers.name from `teachers`";
    $arBindsTeachers = [];
    $stmtTeachers = $pdo->prepare($sqlTeachers);
    $resultTeachers = $stmtTeachers->execute($arBindsTeachers);
    $resultTeachers = $pdo->query($sqlTeachers)->fetchAll(PDO::FETCH_ASSOC);
    return $resultTeachers;
}

function filter()
{
    global $arBinds;
    $arBinds = [];
    $pdo = dbConnect();
    $sqlALL = "SELECT courses.id, courses.img, courses.name, courses.program, courses.cost, courses.id_teacher, teachers.name as 'teacher_name'
    FROM `courses`
    JOIN `teachers` ON courses.id_teacher = teachers.id";


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
    return $resultAll;
}

function checkPassword($pwd)
{
    $errors = array();

    if (strlen($pwd) < 6) {
        $errors[] = "Password too short!";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "Password must include at least one number!";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "Password must include at least one letter!";
    }
    if (empty($errors)) {
        return true;
    }

}

function checkEmail($email)
{
    $errors = array();

    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
        $errors[] = "Bad email!";
    }
    if (empty($errors)) {
        return true;
    }
}


function signup()
{
    $pdo = dbConnect();
    global $data;
    global $errors;
    $data = $_POST;
    $userdata = [];
    if (isset($data['signUpTo'])) {
        $errors = array();

        if (!isset($data['login'])) {
            $errors[] = 'Введите логин!';
        } else {
            if (checkEmail($data['login'])) {
                $userdata['login'] = $data['login'];
            } else {
                $errors[] = 'Неверный формат почты!';
            }

        }
        if (!isset($data['full_name'])) {
            $errors[] = 'Введите ФИО!';
        } else {
            $userdata['full_name'] = $data['full_name'];
        }

        if (!isset($data['birthday'])) {
            $errors[] = 'Введите дату рождения!';
        } else {
            $userdata['birthday'] = $data['birthday'];
        }

        if (!isset($data['address'])) {
            $errors[] = 'Введите адрес!';
        } else {
            $userdata['address'] = $data['address'];
        }

        if (isset($data['interests'])) {
            $userdata['interests'] = $data['interests'];
        }

        if (!isset($data['vk'])) {
            $errors[] = 'Введите ссылку на свой профиль VK!';
        } else {
            $userdata['vk'] = $data['vk'];
        }

        if (!isset($data['gender'])) {
            $errors[] = 'Выберите пол!';
        } else {
            $userdata['gender'] = $data['gender'];
        }

        if (!isset($data['blood_type'])) {
            $errors[] = 'Укажите группу крови!';
        } else {
            $userdata['blood_type'] = $data['blood_type'];
        }

        if (!isset($data['factor'])) {
            $errors[] = 'Укажите резус-фактор!';
        } else {
            $userdata['factor'] = $data['factor'];
        }

        if (!isset($data['password'])) {
            $errors[] = 'Введите пароль!';
        } else {
            if ($data['password'] == $data['password_confirm']) {
                if (checkPassword($data['password'])) {
                    $userdata['password'] = $_POST["password"];
                    $userdata['password'] = password_hash($userdata['password'], PASSWORD_DEFAULT);
                } else {
                    $errors[] = 'Пароль не соответствует правилам!';
                }
            } else {
                $errors[] = 'Пароли не совпадают!';
            }

        }
        if (!isset($data['password_confirm'])) {
            $errors[] = 'Введите пароль еще раз!';
        }


        if (empty($errors)) {
            $sql_test = "SELECT COUNT(*) FROM `USERS` WHERE login = ?";
            $result = $pdo->prepare($sql_test);
            $result->execute([$userdata['login']]);

            $number_of_rows = $result->fetchColumn();
            if ($number_of_rows == 0) {
                $sql = "INSERT INTO `users` (`login`, `password`, `full_name`, `birthday`, `address`, `gender`, `interests`, `vk`, `blood_type`, `factor`)
        VALUES (:login, :password, :full_name, :birthday, :address, :gender, :interests, :vk, :blood_type, :factor)";
                $query = $pdo->prepare($sql);
                $res = $query->execute($userdata);
                header('Location: login.php');
            } else {
                $errors[] = 'Пользователь с таким логином уже существует';
            }
        }
    }
}

function signin()
{
    $pdo = dbConnect();
    global $data;
    global $errors;
    $data = $_POST;
    $userdata = [];
    if (isset($data['loginTo'])) {

        $errors = array();
        if (!isset($data['login'])) {
            $errors[] = 'Введите логин!';
        } else {
            $userdata['login'] = $data['login'];
        }

        if (!isset($data['password'])) {
            $errors[] = 'Введите пароль!';
        } else {
            $userdata['password'] = $data['password'];
        }

        if (empty($errors)) {
            $sql_count = "SELECT * FROM `USERS` WHERE `login` = ?";
            $query = $pdo->prepare($sql_count);
            $query->execute([$userdata['login']]);
            $query_array = $query->fetch(PDO::FETCH_ASSOC);
            if (!empty($query_array)) {
                if (password_verify($userdata['password'], $query_array['password'])) {
                    $_SESSION['loggedUser'] = $userdata['login'];
                    header('Location: index.php');
                    exit;
                } else {
                    $errors[] = 'Неверный пароль!';
                }
            } else {
                $errors[] = 'Такого логина не существует!';
            }
        }

    }
}
