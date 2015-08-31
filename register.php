<?php
require_once 'core/init.php';


if (input::exists()) {
    if (token::check(input::get('token'))) {
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => TRUE,
                'max' => 50,
                'min' => 2,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => TRUE,
                'min' => 6,
                'match' => 'password_again'
            ),
            'password_again' => array(
                'required' => TRUE
            ),
            'name' => array(
                'required' => TRUE,
                'min' => 8,
                'max' => 50
            )
        ));
        if ($validate->passed()) {
            $user= new user;
            $salt=  Hash::salt(32);
            try{$user->create('users', array(
                'username'=>  input::get('username'),
                'password'=> Hash::make(input::get('password'),$salt),
                'name'=>  input::get('name'),
                'email'=>  input::get('email'),
                'DOB'=>  input::get('DOB'),
                'pic'=>  input::get('pic'),
                'salt'=>$salt,
                'bio'=>  input::get('bio')
            ));
            session::flash('success', 'your registeration is complete!!');
            header("location: index.php");}  catch (Exception $e){
    die($e->getMessage());
            }
        } else {
            print_r($validate->errors());
        }
    }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="POST">
            <div class="field">
                <label for="username">username</label>
                <input type="text" name="username" placeholder="username" id="username" value="<?php echo escape(input::get('username')) ?>"autocomplete="on">
            </div>
            <div class="field">
                <label for="password">password</label>
                <input type="password" name="password" placeholder="password" id="password" value=""autocomplete="off">
            </div>
            <div class="field">
                <label for="password_again">password again</label>
                <input type="password" name="password_again" placeholder="password" id="password_again" value=""autocomplete="off">
            </div> 
            <div class="field">
                <label for="name">name</label>
                <input type="text" name="name" placeholder="full name" id="name" value="<?php echo escape(input::get('name')) ?>"autocomplete="on">
            </div>
            <div class="field">
                <label for="email">email</label>
                <input type="email" name="email" placeholder="email" id="email" value="<?php echo escape(input::get('email')) ?>"autocomplete="on">
            </div>
            <div class="field">
                <label for="DOB">DOB</label>
                <input type="date" name="DOB" placeholder="full name" id="DOB" value="<?php echo escape(input::get('DOB')) ?>"autocomplete="on">
            </div>
            <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
            <input type="submit" value="register">
        </form>

    </body>
</html>
