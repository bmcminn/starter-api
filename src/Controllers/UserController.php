<?php

namespace App\Controllers;


use App\Logger;
use Pecee\SimpleRouter\SimpleRouter as Route;
use RedBeanPHP\Facade as R;
use RedBean\RedBean_SimpleModel;


class UserController {


    public static function register() {

        $req = request();
        $res = [
            'success' => true,
        ];


        $errors = validate($_POST, [
            'username'          => 'required',
            'email'             => 'required|email',
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password',
        ]);


        if (!empty($errors)) {
            response()->json([
                'success' => false,
                'error'   => $errors->firstOfAll(),
            ]);
            exit;
        }


        $body = only($_POST, [ 'username', 'email', 'password' ]);


        $body = filter_var_array($body, [
            'username'  => FILTER_SANITIZE_STRING,
            'email'     => FILTER_SANITIZE_EMAIL,
            'password'  => FILTER_SANITIZE_STRING,
        ]);


        try {
            $user = R::dispense('user');

            $password = trim($body['password']);

            $user->password = hash_password($password);
            $user->email    = $body['email'];
            $user->username = $body['username'];

            $id = R::store($user);

            Logger::debug('user id', $id);

        // TODO: setup custom exceptions for models https://www.php.net/manual/en/language.exceptions.extending.php
        } catch(\UserExistsException $err) {
            $res['success']   = false;
            $res['error']     = $err->getMessage();
        }
        // } catch(\Exception $err) {
        //     $res['success']   = false;
        //     $res['error']     = $err->getMessage();
        // }


       return response()->json($res);

   }



    public static function login() {

        $req = request();
        $res = [
            'success' => true,
        ];


        $errors = validate($_POST, [
            'username'          => 'required_unless:email',
            'email'             => 'required_unless:username|email',
            'password'          => 'required|min:8',
        ]);


        if (!empty($errors)) {
            response()->json([
                'success' => false,
                'error'   => $errors->firstOfAll(),
            ]);
            exit;
        }


        $body = only($_POST, [ 'username', 'email', 'password' ]);


        $body = filter_var_array($body, [
            'username'  => FILTER_SANITIZE_STRING,
            'email'     => FILTER_SANITIZE_EMAIL,
            'password'  => FILTER_SANITIZE_STRING,
        ]);


        try {
            $user = R::dispense('user');

            $password = trim($body['password']);

            $user->password = hash_password($password);
            $user->email    = $body['email'];
            $user->username = $body['username'];

            $id = R::store($user);

            Logger::debug('user id', $id);

        // TODO: setup custom exceptions for models https://www.php.net/manual/en/language.exceptions.extending.php
        } catch(\UserExistsException $err) {
            $res['success']   = false;
            $res['error']     = $err->getMessage();
        }
        // } catch(\Exception $err) {
        //     $res['success']   = false;
        //     $res['error']     = $err->getMessage();
        // }


       return response()->json($res);

   }


}