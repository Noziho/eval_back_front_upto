<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use DB_Connect;

class RoleManager
{
    public const TABLE = "ndmp22_role";

    public static function getAll (): array {
        $roles = [];

        $query = DB_Connect::dbConnect()->query("SELECT * FROM " . self::TABLE);
        if ($query) {

            foreach ($query->fetchAll() as $value) {
                $roles[] = (new Role())
                    ->setId($value['id'])
                    ->setRoleName($value['role_name'])
                    ;
            }
        }
        return $roles;
    }

    public static function getRolesByUserId(User $user): array
    {
        $roles = [];
        $query = DB_Connect::dbConnect()->query("
            SELECT * FROM ndmp22_role WHERE id IN (SELECT role_fk FROM ndmp22_user WHERE id = {$user->getId()});
        ");

        if($query){
            foreach($query->fetchAll() as $roleData) {
                $roles[] = (new Role())
                    ->setId($roleData['id'])
                    ->setRoleName($roleData['role_name'])
                ;
            }
        }

        return $roles;
    }

}