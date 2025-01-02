<?php
namespace App\Controllers;

use App\Core\Database;

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($password) {
        try {
            $sql = "SELECT role, password FROM users WHERE 1";
            $result = $this->db->query($sql);

            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['role'] = $row['role'];
                    return [
                        'success' => true,
                        'role' => $row['role']
                    ];
                }
            }

            return [
                'success' => false,
                'error' => 'Contraseña incorrecta'
            ];

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [
                'success' => false,
                'error' => 'Error en la autenticación'
            ];
        }
    }

    public function logout() {
        session_destroy();
        return ['success' => true];
    }

    public function checkAuth() {
        return isset($_SESSION['role']);
    }

    public function getRole() {
        return $_SESSION['role'] ?? null;
    }
}