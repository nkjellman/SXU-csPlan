<?php
require_once PROJECT_ROOT . 'db.connection.properties.php';
require_once PROJECT_ROOT . 'PHP/Service/AuthorizationService.class.php';
require_once PROJECT_ROOT . 'PHP/Service/MockAuthenticationService.class.php';
require_once PROJECT_ROOT . 'PHP/Service/AuthenticationService.class.php';
require_once PROJECT_ROOT . 'PHP/Service/SessionStore.class.php';
require_once PROJECT_ROOT . 'PHP/Service/UserService.class.php';
require_once PROJECT_ROOT . 'PHP/Service/CourseService.class.php';
require_once 'Container.class.php';

/**
 * Class to be able to easily test things by grabbing instances of classes. Make sure you have your db.connection.properties is in project root.
 *
 */
class DI
{
    /**
     * Initializes all objects in container
     * @return Container
     */
    public static function RegisterTypes()
    {
        //new AuthenticationService("csmaster1.cs.local", "cs.local"), new SessionStore();
        $container = new Container();
        return $container->Register("IAuthorizationService", new AuthorizationService(new MockAuthenticationService(),new SessionStore()))
                         ->Register("IUserService", new UserService())
                         ->Register("ICourseService", new CourseService())
                         ->Register("PDO", new PDO(SQL_TYPE.':host='.HOST.';dbname='.SCHEMA, USER, PASS));
    }
}
