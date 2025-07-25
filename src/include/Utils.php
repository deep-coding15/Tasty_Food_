<?php
require_once __DIR__ . "/../../config/config.php";
class Utils
{
    /* public static function redirect(string $path = __DIR__ . '/../../index.php', int $status = 200){
        //http_response_code($status); // Indique au navigateur le code retourne
        header("Location: " . $path, true, $status);
        exit;
    } */

    /**
     * Summary of redirect
     * @param string $path chemin de l'adresse a specifiée a partir du projet
     * @param int $status
     * @return never
     */
    public static function redirect(string $path = BASE_URL . '/index.php', int $status = 302): void
    {
        if (!headers_sent()) {
            header("Location: " . $path, true, $status);
            exit;
        } else {
            echo "<script>window.location.href = '$path';</script>";
            exit;
        }
    }

    public static function statusResponse(int $status = 500)
    {
        http_response_code($status);
    }
}
