<?php

class Login
{
    public static function isLoggedIn()
    {
        //create and store cookie for faster User login
        if (isset($_COOKIE['SNID'])) {
            if (database::query('SELECT user_id FROM login_tokens WHERE token = :token', array(':token' => sha1($_COOKIE['SNID'])))) {
                //return the username of the user that is currently logged in
                $user_id = database::query('SELECT user_id FROM login_tokens WHERE token = :token', array(':token' => sha1($_COOKIE['SNID'])))[0]['user_id'];

                if (isset($_COOKIE['SNID2'])) {
                    return $user_id;
                } else {
                    $cstrong = True;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    database::query('DELETE FROM login_tokens WHERE  token = :token', array(':token' => sha1($_COOKIE['SNID'])));
                    database::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));

                    //cookie expires in 7 days
                    setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                    setcookie("SNID2", 'default',  time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                    return $user_id;
                }
            }
        }
        return false;
    }
}
