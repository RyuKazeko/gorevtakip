<?php
// Hata ayıklama modunu aç
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once 'conn.php';

// Google OAuth yapılandırmasını yükle
$config = require_once 'google_config.php';

// Google istemcisini oluştur
$client = new Google\Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);

// Hata ayıklama için
echo "Callback sayfası başladı.<br>";
echo "Kod: " . (isset($_GET['code']) ? $_GET['code'] : 'Kod yok') . "<br>";

// Gelen kodu işle
if (isset($_GET['code'])) {
    try {
        echo "Kod alındı, token alınıyor...<br>";
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        echo "Token alındı: " . json_encode($token) . "<br>";

        $client->setAccessToken($token);

        // Google Kullanıcı Bilgisi Servisini oluştur
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Google'dan kullanıcı bilgilerini al
        $email = $google_account_info->email;
        $name = $google_account_info->name;
        $picture = $google_account_info->picture;

        echo "Kullanıcı bilgileri alındı: $email, $name<br>";

        // Kullanıcının veritabanında olup olmadığını kontrol et
        $checkUser = $conn->prepare("SELECT * FROM users WHERE mail = ?");
        $checkUser->bind_param("s", $email);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            // Kullanıcı zaten var, oturum oluştur
            $userData = $result->fetch_assoc();

            // Oturum başlat
            session_start();
            $_SESSION['currentLogin'] = $userData;
            $_SESSION['mail'] = $email;
            $_SESSION['id'] = $userData['id'];
            $_SESSION['role'] = $userData['role'];


            echo "Kullanıcı bulundu, oturum başlatıldı. Rol: " . $userData['role'] . "<br>";

            // Rolüne göre yönlendir
            if ($userData['role'] == 'admin') {
                echo "Admin sayfasına yönlendiriliyor...";
                header("Location: ../views/admin.php");
            } else {
                echo "Kullanıcı sayfasına yönlendiriliyor...";
                header("Location: ../views/user.php");
            }
        } else {
            // Kullanıcı yoksa, hata mesajı göster ve giriş sayfasına yönlendir
            echo "Bu e-posta adresi sistemde kayıtlı değil. Sadece kayıtlı kullanıcılar giriş yapabilir.<br>";
            echo "Giriş sayfasına yönlendiriliyor...";

            // 3 saniye bekleyip giriş sayfasına yönlendir
            header("Refresh: 3; URL=../views/login.html?error=not_registered");
            exit();
        }
    } catch (Exception $e) {
        echo "HATA: " . $e->getMessage() . "<br>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }

    exit();
} else {
    // Kod yoksa giriş sayfasına geri dön
    echo "Kod bulunamadı, giriş sayfasına yönlendiriliyor...";
    header('Location: ../views/login.html?error=no_code');
    exit();
}
