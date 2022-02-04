<?php
require_once 'logic.php';
signin();
global $errors;
require_once 'header.php';

?>

<div class="col-md-5 mx-auto">
    <?php if (isset($errors)): ?>
        <?php echo '<div style="color: red;">' . array_shift($errors) . '</div>'; ?>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="hidden" name="action" value="signin">
        <div class="form-group mt-3">
            <label for="email">Email (Логин)</label>
            <input type="email" name="login" class="form-control" placeholder="example@example.com" value="<?php echo htmlspecialchars(@$data['login']); ?>">
        </div>
        <div class="form-group mt-3">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="**********">
        </div>
        <div class="col mt-3">
            <button type="submit" class="w-100 btn btn-secondary" name="loginTo">Войти</button>
        </div>
        <div class="form-group mt-3">
            <p class="text-center">Ещё нет аккаунта? <a href="signup.php">Зарегистрируйтесь</a></p>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
