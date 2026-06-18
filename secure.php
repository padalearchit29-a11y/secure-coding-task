<?php
require_once __DIR__ . '/db.PHP';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo '<h1>Login Error</h1>';
    echo '<p>Please provide both username and password.</p>';
    exit;
}

$stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
$stmt->bind_param('ss', $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<h1>Login Successful!</h1>';
    echo '<p>Welcome, ' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . '.</p>';
} else {
    echo '<h1>Invalid Credentials</h1>';
    echo '<p>Please try again.</p>';
}
?>