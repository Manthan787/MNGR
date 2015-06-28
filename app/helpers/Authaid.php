<?php

class AuthAid
{
    public static function getPosition($roleID)
    {
        if ($roleID == 1) {
            return 'Administrator';
        } else if ($roleID == 2) {
            return 'Teacher';
        } else if ($roleID == 3) {
            return 'Accountant';
        }
    }

    public static function getName($user) {
        return $user->firstname.' '.$user->lastname;
    }
}

