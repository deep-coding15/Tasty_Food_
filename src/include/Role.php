<?php 
class Role {

    private static array $roles = [
        'visiteur' => [
            'description' => 'Utilisateur non connecté',
            'permissions' => [],
        ],
        'client' => [
            'description' => 'Client enregistré',
            'permissions' => ['acheter', 'commenter'],
        ],
        'personnel' => [
            'description' => 'Employé interne',
            'permissions' => ['gerer_commande', 'accès interne'],
        ],
        'admin' => [
            'description' => 'Administrateur du site',
            'permissions' => ['tout'],
        ],
    ];

    /**
     * Return a role for a specific position that start by 0.
     */
    public static function getRoleByIndex(int $index) : ?string {
        $keys = self::getAll();
        return $keys[$index] ?? null; //return null si index est invalie
    }

    /**
     * Return an array containing the different roles : 
     *  - visiteur
     *  - client
     *  - personnel
     *  - admin
     */
    public static function getAll(): array{
        return array_keys(self::$roles);
    }

    /**
     * Return a name of a role in a specific position
     * @param position : the position in an array of the roles
     */
    public static function getRoleName(int $position):string{
        $roles = self::getAll();
        return $roles[$position] ?? 'visiteur';
    }

    /**
     * Return true or false if a role exists or not. 
     * This is the roles that exists : 
     *  - visiteur
     *  - client
     *  - personnel
     *  - admin
     */
    public static function isValid(string $role):bool {
        return array_key_exists($role, self::$roles);
    }

    /**
     * Return a description of a @param role that exists : 
     *  - visiteur
     *  - client
     *  - personnel
     *  - admin
     */
    public static function getDescription(string $role) : ?string{
        return self::$roles[$role]['description'] ?? null;
    }

    /**
     * Return an array of permission for a @param role that exists : 
     *  - visiteur
     *  - client
     *  - personnel
     *  - admin
     */
    public static function getPermissions(string $role) : ?string{
        return self::$roles[$role]['permissions'] ?? [];
    }
}