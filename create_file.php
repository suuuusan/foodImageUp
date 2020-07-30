<?php
session_start();
include("funcs.php");
loginCheck();
$pdo  = db_connect();



// 受け取ったデータを変数に入れる
$memo = $_POST['memo'];



// ここからファイルアップロード&DB登録の処理を追加しよう！！！

if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
    $uploadFileName = $_FILES['upfile']['name'];
    $tempPathName = $_FILES['upfile']['tmp_name'];
    $fileDirectoryPath = 'upload/';

    $extention = pathinfo($uploadFileName, PATHINFO_EXTENSION);
    $uniqueName = date('YmdHis') . md5(session_id()) . "." . $extention;
    $fileNameToSave = $fileDirectoryPath . $uniqueName;
}


if (is_uploaded_file($tempPathName)) {
    if (move_uploaded_file($tempPathName, $fileNameToSave)) {
        chmod($fileNameToSave, 0644);
        $img = '<img src ="' . $fileNameToSave . '">';
    } else {
        exit('Error:アップロードできませんでした');
    }
} else {
    exit('Error:画像がありません');
}


$sql = 'INSERT INTO 
  food_table(id, memo,  image, created_at, updated_at) 
  VALUES(NULL, :memo, :image, sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    header("Location:index.php");
    exit();
}
