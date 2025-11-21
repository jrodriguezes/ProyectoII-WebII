<?php
require_once __DIR__ . '/../config/db.php';

function verifyEmail(string $uid, string $token): void
{
    $conn = getConnection();

    if (!$uid || !$token) {
        exit('Enlace inválido');
    }

    $hash = hash('sha256', $token);

    $sql = "SELECT id, status, verify_token_hash, verify_token_expires_at 
            FROM users 
            WHERE id='$uid'";
    $res = $conn->query($sql);
    if ($res->num_rows === 0) {
        exit('Usuario no encontrado');
    }

    $user = $res->fetch_assoc();

    if ($user['status'] !== 'pending') {
        header('Location: /login?already=1', true, 303);
        exit;
    }

    if ($user['verify_token_hash'] !== $hash || strtotime($user['verify_token_expires_at']) < time()) {
        exit('El enlace es inválido o ha expirado');
    }

    // Activar usuario
    $update = "UPDATE users 
               SET status='active', 
                   email_verified_at=NOW(), 
                   verify_token_hash=NULL, 
                   verify_token_expires_at=NULL 
               WHERE id='$uid'";
    $conn->query($update);

    echo "<h2>Cuenta verificada correctamente ✅</h2>
          <a href='/login'>Ir al login</a>";
}
