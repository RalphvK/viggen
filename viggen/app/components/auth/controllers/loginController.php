<?php

    class loginController {

        public static function login($request)
        {
            if (auth::loggedIn()) {

                return json_file([
                    'message' => 'Already logged in.',
                ], 'success');

            } else {

                $user = auth::checkCredentials($_POST['email'], $_POST['password']);

                // if user object is returned
                if ($user) {
                    if (auth::loginSession($user)) {
                        return json_file([
                            'message' => 'Logged in as '.$user->email,
                        ], 'success');
                    }
                }
                // else
                return json_file([
                    'error' => 'invalid_credentials',
                    'error_message' => 'Invalid credentials.'
                ], 'error');

            }
        }

        public static function logout($request)
        {
            auth::logoutSession();
            return redirect::relative('/login');
        }

    }