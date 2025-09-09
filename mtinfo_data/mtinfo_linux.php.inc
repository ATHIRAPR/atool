<?php
global $SESSION_TIMEOUT;
global $SYS_ID;
global $BASE_DIR;
global $UPLOAD_DIR;
global $PUBLISH_DIR;
global $CMAP_DIR;
global $PDFLIB_LICENSE_FILE;
global $DOWNLOAD_LOG_FILE;
global $DB_LOG_FILE;
global $DB_DSN;
global $TEST_WEB_SERVER;
global $OUTPUT_ENCODING;

// システム定数の定義
$SESSION_TIMEOUT = 3600 * 8; // セッションタイムアウト秒数
$SYS_ID = 2; // システムID
$SYSTEM_NAME = 'informationmanager';
             
// PDFファイルを格納するディレクトリの絶対パス
$BASE_DIR = '/www/informationmanager/mtinfo_data';

// その他のパス
$UPLOAD_DIR = $BASE_DIR . '/upload';
$PUBLISH_DIR = $BASE_DIR . '/publish';
$CMAP_DIR = $BASE_DIR . '/cmap';
$PDFLIB_LICENSE_FILE = $BASE_DIR . '/pdflib_license.txt';
$DOWNLOAD_LOG_FILE = $BASE_DIR . '/pdf_download.log';
$DB_LOG_FILE = $BASE_DIR . '/db_error.log';

// MSSQL Server 接続設定
//$DB_USER = 'IM_USER';
//$DB_PWD = '66$Bc95F$fEd#797';
//$DB_NAME = 'MTINFO';

// MSSQL Server 接続設定
$DB_USER = 'localdb';
$DB_PWD = 'localdb';
$DB_NAME = 'localdb';

$DB_SERVER = 'sqlserver';

$DB_DSN = "dblib:host=$DB_SERVER;database=$DB_NAME";

// 検証機IPアドレス or ホスト名
$TEST_WEB_SERVER = '10.236.144.125';

// 出力エンコード
$OUTPUT_ENCODING = 'UTF-8';

// PDF共通パスワード
$PDF_PWD = 'omsc2004';
?>
