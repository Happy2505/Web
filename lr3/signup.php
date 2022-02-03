<?php
require_once 'logic.php';
signup();
global $errors;
require_once 'header.php';

?>

<div class="col-md-5 mx-auto">

    <?php if (isset($errors)): ?>
    <?php echo '<div style="color: red;">' . array_shift($errors) . '</div>'; ?>
    <?php endif; ?>

    <form action="signup.php" method="post" name="signUpTo">
        <input type="hidden" name="action" value="signup">
        <div class="form-grou mt-3">
            <label for="email">Email (Логин)</label>
            <input type="email" name="login" id="login" class="form-control" placeholder="example@example.com" value="<?php echo @$data['login']; ?>">
        </div>
        <div class="form-group mt-3">
            <label for="full_name">ФИО</label>
            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Иванов Иван Иванович" value="<?php echo @$data['full_name']; ?>">
        </div>
        <div class="form-group mt-3">
            <label for="birthday">Дата рождения</label>
            <input type="date" name="birthday" id="birthday" class="form-control" placeholder="дд/мм/гггг" value="<?php echo @$data['birthday']; ?>">
        </div>
        <div class="form-group mt-3">
            <label for="address">Адрес(необязательно)</label>
            <input type="text" name="address" id="address" class="form-control" placeholder="Адрес" value="<?php echo @$data['address']; ?>">
        </div>
        <div class="form-group mt-3">
            <label for="interests">Интересы(необязательно)</label>
            <textarea class="form-control" placeholder="Введите свои интересы" name="interests" id="interests" style="margin-top: 0px; margin-bottom: 0px; height: 146px;"><?php echo @$data['interests'];?></textarea>
        </div>
        <div class="form-group mt-3">
            <label for="vk">Ссылка на профиль Вконтакте</label>
            <input type="url" name="vk" id="vk" class="form-control" placeholder="https://vk.com/idx" value="<?php echo @$data['vk']; ?>">
        </div>
        <div class="form-group mt-3">
            <label for="gender">Пол</label>
            <select name="gender" id="gender" class="form-control">
                <option value="" disabled="" selected="">Выберите пол</option>
                <option value="male" <?php echo (isset($data['gender']) && $data['gender'] ==='male')? "selected" : ''; ?> >Мужской</option>
                <option value="female" <?php echo (isset($data['gender']) && $data['gender'] ==='female')? "selected" : ''; ?>>Женский</option>
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="blood_type">Группа крови</label>
            <select name="blood_type" id="blood_type" class="form-control">
                <option value="" disabled="" selected="">Выберите группу крови</option>
                <option value="1" <?php echo (isset($data['blood_type']) && $data['blood_type'] === '1')? "selected" : ''; ?>>0 (I)</option>
                <option value="2" <?php echo (isset($data['blood_type']) && $data['blood_type'] === '2')? "selected" : ''; ?>>A (II)</option>
                <option value="3" <?php echo (isset($data['blood_type']) && $data['blood_type'] === '3')? "selected" : ''; ?>>B (III)</option>
                <option value="4" <?php echo (isset($data['blood_type']) && $data['blood_type'] === '4')? "selected" : ''; ?>>AB (IV)</option>
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="factor">Резус-фактор</label>
            <select name="factor" id="factor" class="form-control">
                <option value="" disabled="" selected="">Выберите резус-фактор</option>
                <option value="plus" <?php echo (isset($data['factor']) && $data['factor'] === 'plus')? "selected" : ''; ?>>Положительный (+)</option>
                <option value="minus" <?php echo (isset($data['factor']) && $data['factor'] === 'minus')? "selected" : ''; ?>>Отрицательный (-)</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Совершенно секретно" value="<?php echo @$data['password']; ?>">
        </div>
        <div class="form-group mt-3">
            <label for="password_confirm">Подтвердите пароль</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Совершенно секретно" value="<?php echo @$data['password_confirm']; ?>">
        </div>
        <div class="col mt-3">
            <button type="submit" class="w-100 btn btn-secondary" name="signUpTo">Зарегистрироваться</button>
        </div>
        <div class="form-group mt-3">
            <p class="text-center">Уже есть аккаунт? <a href="login.php">Войти в аккаунт</a></p>
        </div>
    </form>
    <!--Отображение шаблона формы регистрации.
    Данные об ошибках выводим из $signUpErrors,
    поля формы предзаполняем из $_POST с фильтрацией!-->
</div>

<?php include 'footer.php'; ?>
