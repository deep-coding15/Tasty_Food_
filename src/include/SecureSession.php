<?php

/* enum Role {
    case VISITEUR;
    case CLIENT;
    case PERSONNEL;
    case ADMINISTRATEUR;
} */
class SecureSession
{
    //private Role $role;
    //Durée d'inactivité maximale avant expiration (expiration)
    private int $timeOutLastActivity = 0;
    private int $timeOutCreated = 0;
    /**
     * Stocke la date/heure de la dernière activité (clic, chargement de page, etc.)
     * Sert à expirer automatiquement la session après inactivité
     *  @var int
     */
    private const TIMEOUT_LAST_ACTIVITY_NUMBER_OF_MINUTES = 15; 
    /**
     * Stocke la date/heure de création de la session.
     * Sert à savoir quand l’ID de session a été généré pour éventuellement le régénérer périodiquement
     * @var int
     */
    private const TIMEOUT_CREATED_NUMBER_OF_MINUTES = 10; 
    private const MINUTES = 60;
    public function __construct(int $timeOutLastActivity = self::TIMEOUT_LAST_ACTIVITY_NUMBER_OF_MINUTES, int $timeOutCreated = self::TIMEOUT_CREATED_NUMBER_OF_MINUTES)
    {
        //convertit les minutes en secondes
        $this->timeOutLastActivity = $timeOutLastActivity * self::MINUTES;
        $this->timeOutCreated = $timeOutCreated * self::MINUTES;

        //Démarre une session sécurisée avec des options strictes
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                // Empêche l'accès au cookie de session via JavaScript (protège contre les attaques XSS)
                'cookie_httponly' => true,

                // Refuse toute session avec un identifiant invalide ou deviné (protège contre les attaques de session fixation)
                'use_strict_mode' => true,

                // Envoie le cookie de session uniquement via HTTPS si le site est en HTTPS (protège contre l'interception du cookie)
                'cookie_secure' => isset($_SERVER['HTTPS']),
            ]);

        }
        $this->handleSessionSecurity();
    }

    private function handleSessionSecurity(): void{
        //1. Vérifie l'inactivité (timeout)
        if(null !== ($this->get('LAST_ACTIVITY')) && (time() - $this->get('LAST_ACTIVITY')) > $this->timeOutLastActivity){
            //Si l'utilisateur est inactif trop longtemps, on detruit la session
            $this->destroy();
            //header("Location: homepage.php?expired=1");//Redirige k'utilisateur vers la page de connexion
            //exit;
        }
        else{
            //Sinon, on met à jour le temps de derniere connexion
            $this->set('LAST_ACTIVITY', time());
        }

        //2. Regenere l'identifiant de session de façon périodique (ici toutes les 5 minutes)
        if(null == ($this->get('CREATED'))){
            $this->set('CREATED', time());
        }
        else if((time() - $this->get('CREATED')) > $this->timeOutCreated){
            session_regenerate_id(true); //Change l'ID de session pour eviter le vol de session
            $this->set('CREATED', time()); //Réinitialise le temps de création
        }

        //3. Vérification de connexion
        /* if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        } */
       //$_SESSION['LOGIN'] = "";
       $this->set('ROLE', 'administrateur');
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    
    // Détruit complètement la session
    public function destroy(): void
    {
        $_SESSION = [];
        /**
         * Supprime toutes les variables enregistrées dans $_SESSION
         * Mais ne détruit pas encore le fichier de session.
         */
        session_unset();
        /**
         * Détruit la session en cours côté serveur (le fichier de session est supprimé).
         * Le navigateur gardera encore le cookie PHPSESSID, 
         * mais il ne correspondra à aucune session active, 
         * donc l'utilisateur est considéré comme déconnecté.
         */
        session_destroy();
    }
}
