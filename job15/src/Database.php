<?php
namespace App;

use PDO;

class Database
{
    private static ?PDO $pdo = null;

    public static function getPdo(): ?PDO
    {
        if (self::$pdo !== null) return self::$pdo;

        // Configuration par défaut — adapte si besoin
        $host = '127.0.0.1';
        $db   = 'draft-shop';
        $user = 'admin';
        $pass = 'root';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (
            \PDOException $e
        ) {
            // Si la connexion échoue, on retourne null pour utiliser le fallback
            self::$pdo = null;
        }

        return self::$pdo;
    }
}
