<!-- ログインしているかチェックする関数化している。してない場合はエラー表示 -->
<?php
session_start();
$name = $_SESSION['name'];
$id = $_SESSION['id'];

include("funcs.php");
loginCheck();
$pdo  = db_connect();

$msg = 'こんにちは' . htmlspecialchars($name, \ENT_QUOTES, 'UTF-8') . 'さん';

//表示データを取得する
$sql = "SELECT * FROM BMI WHERE id = :id";



$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は指定の1レコードを取得
    // fetch()関数でSQLで取得したレコードを取得できる
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

$_SESSION["height"] = $record["height"];
$_SESSION["weight"] = $record["weight"];
$_SESSION["bmi"] = $record["bmi"];


// $_SESSION["sex"] = $record["sex"];
?>

<!-- 処理結果の表示 -->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>index</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>
    <header style='background-color: gray;'><?= $msg ?><br>登録時基本情報</header>
    <div class="container">
        <table class="table table-striped">

            <thead>
                <tr>
                    <!-- <th>ログインID</th>
                    <th>パスワード</th>
                    <th>名前</th>
                    <th>MAIL</th> -->
                    <th>性別</th>
                    <th>学年</th>
                    <th>身長</th>
                    <th>体重</th>
                    <th>BMI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- <th scope="row"><?php echo $record["u_id"]; ?></th>
                    <td><?php echo $record["u_pw"]; ?> </td>
                    <td><?php echo $record["name"]; ?> </td>
                    <td> <?php echo $record["mail"]; ?></td> -->
                    <td> <?php echo $record["sex"]; ?></td>
                    <td><?php echo $record["grade"]; ?></td>
                    <td><?php echo $record["height"]; ?>cm </td>
                    <td><?php echo $record["weight"]; ?>kg </td>
                    <td><?php echo $record["bmi"]; ?></td>

                </tr>
            </tbody>
        </table>
    </div>

    <? echo "<a href=idUpdate.php?id=" . $id . ">基本情報を変更する </a>"  ?>

    <h6>食事内容をアップロード</h6>
    <form action="create_file.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <div>
                メモ<input type="text" name=" memo">
            </div>

            <div>
                <input type="file" name="upfile" accept="image/*" capture="camera">
            </div>
            <div>
                <button>submit</button>
            </div>
        </fieldset>
    </form>
    <!-- <form action="new_weight_register.php" method="POST">
        <table>
            <tr>
                <td>身長</td>
                <td><input type="number" name="newHeight" size="10" value="000.0" step="0.5">cm</td>
            </tr>
            <tr>
                <td>体重</td>
                <td><input type="number" name="newWeight" size="10" value="00.0" step="0.1">kg</td>
            </tr>

        </table>
        <button type="submit" class="btn btn-primary">確認する</button>

    </form> -->

    <button class="btn btn-warning" onclick="location.href='logout.php'">ログアウト</button>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>