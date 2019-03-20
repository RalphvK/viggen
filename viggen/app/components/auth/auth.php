<?php

    class auth {

        static protected $user;

        /**
         * protect a route
         *
         * @param boolean $redirect - controls whether to redirect, or to return a json response with status code 403 (used for api routes)
         * @return boolean returns true when authenticated
         */
        static public function protect($redirect = true, $roles = null)
        {
            if (self::loggedIn()) {
                if (!$roles) {
                    return true;
                } else {
                    // get user
                    $user = self::sessionUser();
                    // update session
                    self::updateSession($user);
                    // look for match
                    foreach ($roles as $key => $role) {
                        if (self::hasRole($user, $role)) {
                            return true;
                        }
                    }
                    // if none found
                    http_response_code(403);
                    echo json_file([
                        'error' => 'unauthorized',
                        'error_message' => 'You have insufficient permissions.'
                    ], 'error');
                    exit;
                }
            } else {
                if ($redirect) {
                    redirect::relative($_ENV['ROUTE_LOGIN']);
                } else {
                    http_response_code(403);
                    echo json_file([
                        'error' => 'unauthorized',
                        'error_message' => 'You are not logged in.'
                    ], 'error');
                    exit;
                }
            }
        }

        static public function checkCredentials($email, $password)
        {
            $user = ORM::for_table('users')->where('email', $email)->find_one();
            if ($user) {
                if (crypto::checkPassword($password, $user->password)) {
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * set session variables for login
         *
         * @param object $user - ORM object
         * @return boolean $_SESSION['loggedIn']
         */
        static public function loginSession($user)
        {
            // setting session variables
            $_SESSION['loggedIn'] = true;
            $_SESSION['userID'] = $user->id;
            $_SESSION['name'] = $user->name;
            // setting last login
            $user->last_login = self::timestamp();
            $user->save();
            // returning saved value
            return $_SESSION['loggedIn'];
        }

        static public function updateSession($user)
        {
            self::$user = $user;
            $_SESSION['userID'] = $user->id;
            $_SESSION['name'] = $user->name;
        }

        static public function logoutSession()
        {
            session_unset();
            session_destroy();
        }

        static public function sessionUser()
        {
            if (self::loggedIn()) {
                if (is_object(self::$user)) {
                    return self::$user;
                } else {
                    self::$user = ORM::for_table('users')->find_one($_SESSION['userID']);
                    return self::$user;
                }
            } else {
                return false;
            }
        }

        static public function loggedIn()
        {
            if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * register new user
         *
         * @param string $name
         * @param string $email - must be unique
         * @param string $password - unhashed password string
         * @return void
         */
        static public function register($name, $email, $password)
        {
            // check if email is unique
            if (!self::isUnique('email', $email)) {
                throw new Exception('Email address already registered.');
                return false;
            }
            // else register new user
            $user = ORM::for_table('users')->create();
            $user->name = $name;
            $user->email = $email;
            $user->password = crypto::hash($password);
            $user->save();
            $user->id = $user->id();
            return $user;
        }

        static public function isUnique($field, $value)
        {
            if (ORM::for_table('users')->where($field, $value)->count() > 0) {
                return false;
            } else {
                return true;
            }
        }

        static public function timestamp()
        {
            return date("Y-m-d H:i:s");
        }

        /**
         * check if user has role
         *
         * @param ORM $user
         * @param string $role
         * @return boolean
         */
        static public function hasRole($role, $user = null)
        {
            if (!$user) {
                // get user from DB
                $user = self::sessionUser();
            }
            $roles = self::getRoles($user);
            if (self::roleInArray($roles, $role)['exists'] == true) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * add role to user
         *
         * @param ORM $user
         * @param string $role
         * @return ORM - user object
         */
        static public function addRole($user, $role)
        {
            $roles = self::getRoles($user);
            if (self::roleInArray($user, $role)) {
                return $user;
            } else {
                $roles[] = $role; // add new role
                return self::setRoles($user, $roles);
            }
        }

        /**
         * remove role from user
         *
         * @param ORM $user
         * @param string $role
         * @return ORM - user object
         */
        static public function removeRole($user, $role)
        {
            $roles = self::getRoles($user);
            $element = self::roleInArray($user, $role);
            if (!$element) {
                return $user;
            } else {
                unset($roles[$element['key']]);
                return self::setRoles($user, $roles);
            }
        }

        static public function getRoles($user)
        {
            if ($user->roles) {
                return json_decode($user->roles, true); // to array
            } else {
                return []; // return empty array
            }
        }

        static public function setRoles($user, $array)
        {
            $user->roles = json_encode($array);
            return $user;
        }

        static public function roleInArray($roles, $role)
        {
            if (in_array($role, $roles)) {
                return [
                    'exists' => true,
                    'key' => array_search($role, $roles)
                ];
            } else {
                return false;
            }
        }

    }