<?php

// Statuses
define('OK', 1);
define('ERROR', -1);
 
function main(array $args) : array
{
    // SMTP arguments
    if (!isset($args['smtp_server'])) {
        return wrap(['error' => 'Please supply smtp_server argument.']);
    }

    if (!isset($args['smtp_port'])) {
        return wrap(['error' => 'Please supply smtp_port argument.']);
    }

    if (!isset($args['smtp_username'])) {
        return wrap(['error' => 'Please supply smtp_username argument.']);
    }

    if (!isset($args['smtp_password'])) {
        return wrap(['error' => 'Please supply smtp_password argument.']);
    }

    // Email message argument
    if (!isset($args['subject'])) {
        return wrap(['error' => 'Please supply subject argument.']);
    }

    if (!isset($args['sender_email'])) {
        return wrap(['error' => 'Please supply sender_email argument.']);
    }

    if (!isset($args['sender_name'])) {
        return wrap(['error' => 'Please supply sender_name argument.']);
    }

    if (!isset($args['recipient_email'])) {
        return wrap(['error' => 'Please supply recipient_email argument.']);
    }

    if (!isset($args['recipient_name'])) {
        return wrap(['error' => 'Please supply recipient_name argument.']);
    }

    // Template variables
    if (!isset($args['template'])) {
        return wrap(['error' => 'Please supply template argument.']);
    }

    if (!isset($args['variables'])) {
        return wrap(['error' => 'Please supply variables argument.']);
    }

    // Send the message
    $result = send($args);
 
    return wrap(['response' => $result, 'version' => 1]);
}

function wrap(array $args) : array
{
    return ["body" => $args];
}

function send(array $args): array
{
    // Templates part
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => '/tmp',
    ]);

    $templateNameHTML = $args['template'] . '.html';
    $templateNameTXT = $args['template'] . '.txt';

    if (!file_exists(__DIR__ . '/templates/' . $templateNameHTML)) {
        return ['status' => ERROR, 'result' => 'template (HTML) does not exist'];
    }
    if (!file_exists(__DIR__ . '/templates/' . $templateNameTXT)) {
        return ['status' => ERROR, 'result' => 'template (TXT) does not exist'];
    }

    // Render tempalates
    $variables = (array)json_decode(base64_decode($args['variables']));

    $html = $twig->render($templateNameHTML, $variables);
    $txt = $twig->render($templateNameTXT, $variables);

    // Email part
    $transport = (new Swift_SmtpTransport($args['smtp_server'], $args['smtp_port']))
        ->setUsername($args['smtp_username'])
        ->setPassword($args['smtp_password']);

    $mailer = new Swift_Mailer($transport);

    $message = (new Swift_Message($args['subject']))
        ->setFrom([$args['sender_email'] => $args['sender_name']])
        ->setTo([$args['recipient_email'] => $args['recipient_name']])
        ->addPart($txt, 'text/plain')
        ->addPart($html, 'text/html');

    $result = $mailer->send($message);

    return ['status' => OK, 'result' => $result];
}
