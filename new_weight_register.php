<?php
session_start();

include("funcs.php");

// 入力した値の検証、加工
$newHeight = $_POST["newHeight"];
$newWeight = $_POST["newWeight"];

// sessionの受け取り
$height = htmlspecialchars($_SESSION["height"], ENT_QUOTES, "UTF-8");
$weight = htmlspecialchars($_SESSION["weight"], ENT_QUOTES, "UTF-8");
$bmi = htmlspecialchars($_SESSION["bmi"], ENT_QUOTES, "UTF-8");

$bmi = bmi_calc($height, $weight);




// BMI計算など関数化しfuncs.phpへ
$newBmi = bmi_calc($newHeight, $newWeight);


$_SESSION["newHeight"] = $newHeight;
$_SESSION["newWeight"] = $newWeight;
$_SESSION["newBmi"] = $newBmi;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>BMI</title>
</head>

<body>
    <header style='background-color: lightgray;font-size:large;'>確認画面</header>

    <!-- 入力確認form -->
    <form action="new_weight_submit.php" method="POST">
        <table border="2">

            <td>今の身長</td>
            <td>
                <?php echo $newHeight . 'cm'; ?>
            </td>
            </tr>
            <tr>
                <td>今の体重</td>
                <td>
                    <?php echo $newWeight .
                        'kg'; ?>
                </td>
            </tr>
            <tr>
                <td>今回のBMI</td>
                <td>
                    <?php echo $newBmi; ?>
                </td>
            </tr>
            <tr>
                <td>あなたの体格</td>
                <td>
                    <? $figure=bmi_figure($newBmi); ?>
                </td>
            </tr>

        </table>

        <table border="2">
            <tr>
                <td>登録時身長</td>
                <td>
                    <?php echo $height . 'cm'; ?>
                </td>
            </tr>
            <tr>
                <td>登録時体重</td>
                <td>
                    <?php echo $weight .
                        'kg'; ?>
                </td>
            </tr>
            <tr>
                <td>登録時BMI</td>
                <td>
                    <?php echo $bmi; ?>
                </td>
            </tr>
            <tr>
                <td>あなたの体格</td>
                <td>
                    <? $figure=bmi_figure($bmi); ?>
                </td>
            </tr>

        </table>
        <button type="submit" class="btn btn-primary">入力OK</button>
    </form>
    <button class="btn btn-danger" onclick="location.href='register.php'">入力画面へ戻る</button>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>