<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coursera | Build Skills with Online Courses from Top Institutions</title>
    <link href="css/bootstrap.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="lang-navbar pt-3 pb-3 navbar-block">
        <div class="row">
            <div class="col">
                <ul class="nav">
                    <li class="nav-item ms-2">
                        <a type="button" class="btn btn-link btn-sm" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a type="button" class="btn btn-link btn-sm" href="courses.php">Фильтр</a>
                    </li>
                </ul>
            </div>
            <div class="col">
                <ul class="nav justify-content-end">
                    <?php if (isset($_SESSION['loggedUser'])) : ?>
                        <li class="nav-item ms-2 pt-1">
                            Вы авторизированы как <?php echo htmlspecialchars($_SESSION['loggedUser'])?>
                        </li>
                        <li class="nav-item ms-2 me-2">
                            <a type="button" class="btn btn-danger" href="logout.php">Выйти</a>
                        </li>
                    <?php else : ?>

                        <li class="nav-item ms-2">
                            <a type="button" class="btn btn-secondary" href="login.php">Войти в аккаунт</a>
                        </li>
                        <li class="nav-item ms-2 me-5">
                            <a type="button" class="btn btn-secondary" href="signup.php">Регистрация</a>
                        </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><b>coursera</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <button type="button" class="btn btn-primary" >Изучить</button>

                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" href="#"><b>цели</b></a></li>
                        <li><a class="dropdown-item" href="#">Пройти бесплатный курс</a></li>
                        <li><a class="dropdown-item" href="#">Получите диплом</a></li>
                        <li><a class="dropdown-item" href="#">Получите сертификат</a></li>
                        <li><a class="dropdown-item" href="#">Начните карьеру или продвинтесь по карьерной лестнице</a></li>

                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><b>темы</b></a></li>
                        <li><a class="dropdown-item" href="#">Наука о данных</a></li>
                        <li><a class="dropdown-item" href="#">Бизнес</a></li>
                        <li><a class="dropdown-item" href="#">Компьютерные науки</a></li>
                        <li><a class="dropdown-item" href="#">Информационные технологии</a></li>
                        <li><a class="dropdown-item" href="#">Изучение языков</a></li>
                        <li><a class="dropdown-item" href="#">Здоровье</a></li>
                        <li><a class="dropdown-item" href="#">Естественные и технические науки</a></li>
                        <li><a class="dropdown-item" href="#">Социальные науки</a></li>
                        <li><a class="dropdown-item" href="#">Гуманитарные науки и искусства</a></li>
                        <li><a class="dropdown-item" href="#">Математика и логика</a></li>
                    </ul>
                </li>
                <form class="d-flex">
                    <input class="form-control me-4"  type="search" placeholder="Чему вы хотите научится?" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <div class="magnifier-wrapper"><svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(-293.000000, -23.000000)"><g fill="#E1E1E1"><g transform="translate(293.000000, 22.000000)"><path d="M11.355485,11.4503883 L16.0066609,16.1015642 L15.1015642,17.0066609 L10.4503883,12.355485 C9.34711116,13.2583262 7.93681293,13.8 6.4,13.8 C2.8653776,13.8 0,10.9346224 0,7.4 C0,3.8653776 2.8653776,1 6.4,1 C9.9346224,1 12.8,3.8653776 12.8,7.4 C12.8,8.93681293 12.2583262,10.3471112 11.355485,11.4503883 Z M6.4,12.52 C9.22769792,12.52 11.52,10.2276979 11.52,7.4 C11.52,4.57230208 9.22769792,2.28 6.4,2.28 C3.57230208,2.28 1.28,4.57230208 1.28,7.4 C1.28,10.2276979 3.57230208,12.52 6.4,12.52 Z"></path></g></g></g></svg></div>
                    </button>
                </form>
            </ul>
            <span class="navbar-text">
        <a style="font-size: 14px" href="">Для организации</a>
      </span>
            <span class="navbar-text">
        <a style="font-size: 14px" href="">Для студентов</a>
      </span>
            <span class="navbar-text">
        <a style="color: blue; font-size: 14px" href="">Войти</a>
      </span>
            <span class="navbar-text">
        <button type="button" class="btn btn-primary" ><b>Присоединится бесплатно</b></button>
      </span>
        </div>
    </div>
</nav>