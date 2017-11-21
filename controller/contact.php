<?php
//manage form php
//$text= '<h3>contact form</h3>';



$content = 'contact form';
function saveFeedback($dbConnection, array $feedback)
{
    if (!isset($feedback['email']) || !isset($feedback['phone']) || !isset($feedback['message'])) {
        return false;
    }

    $feedback['ip_address'] = $_SERVER['REMOTE_ADDR'];

    $sql = 'INSERT INTO feedback (email, phone, message, ip_address) VALUES (?, ?, ?, ?)';
    $stmt = mysqli_prepare($dbConnection, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        'ssss',
        $feedback['email'],
        $feedback['phone'],
        $feedback['message'],
        $feedback['ip_address']
    );
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}
if ($_POST) {
    $feedback = [
        'email' => requestPost('email'),
        'phone' => requestPost('phone'),
        'message' => requestPost('message'),
    ];

    saveFeedback($dbConnection, $feedback);
}