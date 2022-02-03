<?php
require_once 'logic.php';
protect();
include 'header.php';
$resultTeachers = filter_types();
$resultAll = filter();
?>

<div class="container">
    <div class="row">
        <form action="courses.php" method="get">
            <label>Фильтрация результата поиска</label>
            <div class="mb-3 mt-3">
                <label>По Цене:</label>
                <input type="number" name="cost" placeholder="Цена" value="<?php echo isset($arBindsAll['cost']) ? $arBindsAll['cost'] : ''; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Фильтрация по преподавателям:</label>
                <select name="teacher_name" class="form-control">
                    <option value="">Выберите преподававтеля</option>
                    <?php if (count($resultTeachers) > 0): ?>
                        <?php foreach ($resultTeachers as $item): ?>
                            <option value="<?= $item['id'] ?>" <?php echo (isset($arBindsAll['name']) && $arBindsAll['name'] === $item['id'])? "selected" : ''; ?>> <?= htmlspecialchars($item['name']) ?> </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Фильтрация по описанию программы курса:</label>
                <textarea class="form-control" placeholder="Введите характеристику студента" name="program"><?php echo isset($arBindsAll['program']) ? $arBindsAll['program'] : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label>Фильтрация по названию:</label>
                <input type="text" name="name" placeholder="Введите название" value="<?php echo isset($arBindsAll['name']) ? htmlspecialchars($arBindsAll['name']) : ''; ?>" class="form-control">
            </div>
            <input type="submit" value="Применить фильтр" class="btn btn-primary">
            <input type="submit" name="clearFilter" value="Очистить фильтр" class="btn btn-danger">
        </form>
    </div>
    <div class="row text-center mt-5">
        <?php if (count($resultAll) > 0): ?>
            <table class="table">
                <thead>
                <tr>
                    <th class="scope">Изображение</th>
                    <th class="scope">Название</th>
                    <th class="scope">Преподаватель</th>
                    <th class="scope">Описание</th>
                    <th class="scope">Цена</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($resultAll as $item): ?>
                    <tr>
                        <th scope="row"><img src="img/inc/<?= $item['img'] ?>" style="max-width: 150px;"></th>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['teacher_name']) ?></td>
                        <td><?= htmlspecialchars($item['program']) ?></td>
                        <td><?= htmlspecialchars($item['cost']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</div>




<?php include 'footer.php'; ?>