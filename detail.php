<?php
session_start();

// 関数ファイルの読み込み
include("funcs.php");

// 削除データの主キーを取得
if (!isset($_GET["id"])) {
    exit;
} else {
    $id = $_GET["id"];
    $_SESSION["id"] = $id;  //主キーを$_SESSIONへ
}



// DB接続
$pdo = db_connect();


//データを取得する
$sql = "SELECT * FROM BMI WHERE id =:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch();

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
    <header style='background-color: lightgray;font-size:large;'>詳細画面</header>



    <table border="2">
        <tr>
            <td>ログインID</td>
            <td>
                <?php echo $row['u_id']; ?>
            </td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td>
                <?php echo $row['u_pw']; ?>
            </td>
        </tr>
        <tr>
            <td>名前</td>
            <td>
                <?php echo $row['name']; ?>
            </td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td>
                <?php echo $row['mail']; ?>
            </td>
        </tr>
        <tr>
            <td>性別</td>
            <td>
                <?php echo $row['sex']; ?>
            </td>
        </tr>
        <tr>
            <td>学年</td>
            <td>
                <?php echo $row['grade']; ?>
            </td>
        </tr>
        <tr>
            <td>身長</td>
            <td>
                <?php echo $row['height'] . 'cm'; ?>
            </td>
        </tr>
        <tr>
            <td>体重</td>
            <td>
                <?php echo $row['weight'] . 'kg'; ?>
            </td>
        </tr>
        <tr>
            <td>BMI</td>
            <td>
                <?php echo $row['bmi']; ?>
            </td>
        </tr>
    </table>

    <button class="btn btn-primary" onclick="location.href='masterpage.php'">一覧へ戻る</button>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>