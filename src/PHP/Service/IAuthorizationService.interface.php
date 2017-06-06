<?php
interface IAuthorizationService
{
    function Login($user, $pass, PDO &$pdo);
    function Logout();
    function IsValidSession();
}
