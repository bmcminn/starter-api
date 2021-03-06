<?php

namespace App\Helpers;


class Mailer {


    public static function sendChangeEmail($email, $token) {

    }


    public static function sendForgotPassword($email, $token) {
    	$content = "Reset token: {$token}";
    	$headers = [
    		'from' => 'info@site.com',
    	];
    	$success = self::composeEmail($email, 'password reset', $content, $headers);
    	return $success;
    }


    private static function composeEmail(string $to, string $subject, string $content, array $headers = []) {

        // TODO: figure out some form of content composition
        $html = $content;

        mail($to, $subject, $content, $headers);
    }


}
