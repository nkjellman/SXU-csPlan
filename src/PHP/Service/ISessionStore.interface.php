<?php
interface ISessionStore
{
        function Add($key, $value);
        function IsAuthenticated();
}
