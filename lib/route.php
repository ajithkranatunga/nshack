<?php
class Router
{
    function __construct()
    {
        if (isset($_GET['url'])) {
            $raw_url = $_GET['url'];
            $urlTrim = rtrim($raw_url, "/");
            /** making an array of parts of url ( seperated by / ) */
            $url = explode("/", $urlTrim);
            $controller_name = $url[0];
            if (file_exists(ABSPATH . "Controller/" . $controller_name . ".php")) {
                /**
                 * if controller file is there, mc-autoload.php will load it
                 * here the controller is actually created/instantiated
                 */
                $controller = new $controller_name();
                /**
                 * if 2 or more string phrases available in the url,
                 * pass 2nd and later strings as parameters to the action
                 */
                if (isset($url[2])) {
                    $action = $url[1];
                    /**
                     * removing 0th and 1st elements from $url array
                     */
                    array_shift($url);
                    array_shift($url);

                    /**
                     * check whether action function exists
                     */
                    if (method_exists($controller, $action)) {
                        $controller->{$action}($data = $url);
                    } else {
                        $controller = new Error();
                    }
                } else {
                    if (isset($url[1])) {

                        /**
                         * check whether the action function exists
                         */
                        if (method_exists($controller, $url[1])) {
                            /**
                             * calling the action with no parameters
                             */
                            $controller->{$url[1]}();
                        } else {
                            $controller = new Error();
                        }
                    } else {
                        /**
                         * calling to home page, if there is no action specified
                         */
                        $controller = new Home();
                    }
                }
            } else {
                /**
                 * If controller file is not found, the error/404 page is loading
                 */
                require_once(ABSPATH . "Controller/errorPag.php");
                $controller = new ErrorPage();
                return false;
            }
        } else {
            /** if url/controller is not set, load home page */
            require_once(ABSPATH . 'Controller/home.php');
            $controller = new Home();
        }
    }
}