<?php
session_start();
if (empty($_SESSION)) {
    exit;
}

include("funcs.php");

$pdo  = db_connect();

// 入力内容の取得($_SESSIONから主キーも含む)
$id = $_SESSION["id"];
$lid = htmlspecialchars($_SESSION["lid"], ENT_QUOTES, "UTF-8");
$lpw = htmlspecialchars($_SESSION["lpw"], ENT_QUOTES, "UTF-8");
$name = htmlspecialchars($_SESSION["name"], ENT_QUOTES, "UTF-8");
$mail = htmlspecialchars($_SESSION["mail"], ENT_QUOTES, "UTF-8");
$sex = $_SESSION["sex"];
$grade = htmlspecialchars($_SESSION["grade"], ENT_QUOTES, "UTF-8");
$height = htmlspecialchars($_SESSION["height"], ENT_QUOTES, "UTF-8");
$weight = htmlspecialchars($_SESSION["weight"], ENT_QUOTES, "UTF-8");
$bmi = htmlspecialchars($_SESSION["bmi"], ENT_QUOTES, "UTF-8");


// データの追加
$sql = "UPDATE BMI SET 
u_id=:lid,u_pw=:lpw,name=:name,mail=:mail,sex=:sex,grade=:grade,height=:height,weight=:weight,bmi=:bmi,dt=NOW() 
WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->bindParam(":lid", $lid);
$stmt->bindParam(":lpw", $lpw);
$stmt->bindParam(":name", $name);
$stmt->bindParam(":mail", $mail);
$stmt->bindParam(":sex", $sex);
$stmt->bindParam(":grade", $grade);
$stmt->bindParam(":height", $height);
$stmt->bindParam(":weight", $weight);
$stmt->bindParam(":bmi", $bmi);


$status = $stmt->execute();

// セッションデータの破棄
$_SESSION = array();
session_destroy();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    // 正常にSQLが実行された場合は以下表示
    echo "正常に変更完了しました。";
    echo "<a href='login.php'>ログイン画面へ</a>";
}
