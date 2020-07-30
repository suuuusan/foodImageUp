<?php
session_start();
if (empty($_SESSION)) {
    exit;
}

include("funcs.php");

$pdo  = db_connect();

$newHeight = $_SESSION["newHeight"];
$newWeight = $_SESSION["newWeight"];
$newBmi = $_SESSION["newBmi"];

// データの追加
$sql = "INSERT INTO newBMI_table (id, newHeight, newWeight, newBMI, created_at)
VALUES (null,:newHeight, :newWeight, :newBMI, sysdate() ";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":newHeight", $newHeight);
$stmt->bindParam(":newWeight", $newWeight);
$stmt->bindParam(":newBMI", $newBMI);

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
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    header('Location:login.php');
}
