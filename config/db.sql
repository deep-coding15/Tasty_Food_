-- TABLE utilisateur
CREATE TABLE IF NOT EXISTS utilisateur (
    id_utilisateur INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    img_profil VARCHAR(255) DEFAULT 'profile_default.jpg' CHECK (
        img_profil LIKE '%.jpg' OR
        img_profil LIKE '%.jpeg' OR
        img_profil LIKE '%.png' OR
        img_profil LIKE '%.gif' OR
        img_profil LIKE '%.svg'
    ),
    email VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(20) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- TABLE clients
CREATE TABLE IF NOT EXISTS clients (
    id_client INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    id_utilisateur INT UNSIGNED NOT NULL,
    CONSTRAINT fk_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_client_utilisateur (id_utilisateur),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS roles (
    id_role TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_role VARCHAR(30) NOT NULL UNIQUE,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- TABLE personnel
CREATE TABLE IF NOT EXISTS personnel (
    id_personnel INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    matricule INT UNSIGNED NOT NULL UNIQUE,
    id_role TINYINT UNSIGNED NOT NULL,
    id_utilisateur INT UNSIGNED NOT NULL,
    CONSTRAINT fk_personnel_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    CONSTRAINT fk_personnel_role FOREIGN KEY (id_role) REFERENCES roles(id_role),
    INDEX idx_personnel_utilisateur (id_utilisateur),
    INDEX idx_personnel_role (id_role),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   deleted_at DATETIME DEFAULT NULL
);


INSERT INTO roles (nom_role, description) VALUES
('serveur', 'Personnel chargé du service en salle'),
('cuisinier', 'Prépare les plats en cuisine'),
('livreur', 'Assure les livraisons à domicile'),
('admin', 'Administrateur de la plateforme');

CREATE TABLE IF NOT EXISTS moyens_paiement (
    id_paiement TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type_paiement VARCHAR(30) NOT NULL UNIQUE,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO moyens_paiement (type_paiement, description) VALUES
('carte', 'Paiement par carte bancaire'),
('espece', 'Paiement en espèces'),
('en ligne', 'Paiement en ligne via application');

-- TABLE livreur
CREATE TABLE IF NOT EXISTS livreur (
    id_livreur INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT UNSIGNED NOT NULL,
    CONSTRAINT fk_livreur_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_livreur_utilisateur (id_utilisateur),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- TABLE serveur
CREATE TABLE IF NOT EXISTS serveur (
    id_serveur INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_personnel INT UNSIGNED NOT NULL,
    CONSTRAINT fk_serveur_personel FOREIGN KEY (id_personnel) REFERENCES 	personnel(id_personnel) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_serveur_personnel (id_personnel),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- TABLE table_restaurant
CREATE TABLE IF NOT EXISTS table_restaurant (
    numero_tab INT UNSIGNED PRIMARY KEY,
    nbre_place TINYINT UNSIGNED NOT NULL CHECK (nbre_place > 0),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- TABLE plats
CREATE TABLE IF NOT EXISTS plats (
    id_plat INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_plat VARCHAR(100) NOT NULL,
    img_plats VARCHAR(255) DEFAULT 'plats_default.jpg' CHECK (
    	img_plats LIKE '%.jpg' OR
    	img_plats LIKE '%.jpeg' OR
    	img_plats LIKE '%.png' OR
    	img_plats LIKE '%.gif' OR
    	img_plats LIKE '%.svg'
    ),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,

    prix_plats DECIMAL(10,2) NOT NULL CHECK (prix_plats >= 0),
    type_plats TINYINT UNSIGNED NOT NULL,

    INDEX idx_nom_plat (nom_plat),
    INDEX idx_type_plats (type_plats), 

    CONSTRAINT fk_tp_plat FOREIGN KEY (type_plats)
        REFERENCES type_plat(id_type_plat) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE plats
ADD CONSTRAINT fk_type_plat
FOREIGN KEY (type_plats)
REFERENCES type_plat(id_type_plat)
ON DELETE CASCADE
ON UPDATE CASCADE;

INSERT INTO `plats` (`id_plat`, `nom_plat`, `description`, `img_plats`, `created_at`, `updated_at`, `deleted_at`, `prix_plats`, `type_plats`) VALUES
(1, 'Tajine Poulet', 'Le tajine de poulet est une spécialité marocaine savoureuse à base de cuisses de poulet mijotées avec des oignons, des citrons confits, des olives vertes et des épices comme le curcuma et le gingembre. Ce plat sucré-salé est un incontournable des grandes tablées marocaines, à déguster avec du pain traditionnel ou de la semoule.', 'tajine_poulet.jpg', '2025-07-04 17:43:39', '2025-07-07 16:34:54', NULL, 85.50, 2),
(2, 'Burger Maison', 'Un pain moelleux garni d’un steak haché juteux, accompagné de fromage fondant, de tranches de tomate fraîche, de salade croquante et d’une sauce maison savoureuse. Le tout grillé à la perfection pour un plaisir garanti à chaque bouchée.', 'burger.jpg', '2025-07-04 17:43:39', '2025-07-07 07:30:01', NULL, 60.00, 1),
(3, 'Poulet Yassa', 'Un plat emblématique de la cuisine sénégalaise, le poulet yassa est préparé avec des morceaux de poulet marinés longuement dans un mélange de citron, d’oignons, de moutarde et d’épices. Le tout est mijoté jusqu’à obtenir une sauce onctueuse et acidulée, souvent accompagné de riz blanc.\r\n\r\n\r\n', 'poulet_yassa.jpg', '2025-07-04 17:43:39', '2025-07-07 16:33:38', NULL, 12.50, 2),
(4, 'Sushi Maki', 'Les maki sushi sont de petits rouleaux japonais composés de riz vinaigré (shari) enroulé dans une feuille d’algue nori, garnis de poisson cru, légumes ou fruits de mer. Découpés en bouchées, ils offrent une explosion de fraîcheur et de textures, parfaits pour les amateurs de cuisine japonaise authentique.', 'sushi_maki.jpg', '2025-07-04 17:43:39', '2025-07-07 16:34:08', NULL, 14.00, 3),
(5, 'Tajine Agneau', 'Ce plat traditionnel marocain est mijoté lentement dans un plat en terre cuite. Il associe de tendres morceaux d’agneau à des légumes fondants et un mélange d’épices comme le cumin, le gingembre, la cannelle et le curcuma. Le tajine d’agneau est un plat riche, parfumé et réconfortant, souvent servi avec de la semoule ou du pain.', 'tajine_agneau.jpg', '2025-07-04 17:43:39', '2025-07-07 16:34:34', NULL, 13.80, 2);


CREATE TABLE If NOT EXISTS type_plat (
    id_type_plat INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
    type_plat_nom VARCHAR(64) NOT NULL,
    UNIQUE idx_unique_nom_type_pla (type_plat_nom)
);

INSERT INTO `type_plat`(`type_plat_nom`) VALUES 
    ('Accompagnements'),
    ('Desserts'),
    ('Entrees'),
    ('Plat de résistance'),
    ('Boissons');

-- TABLE ingredients
CREATE TABLE IF NOT EXISTS ingredients (
    id_ingr INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_ingr VARCHAR(100) NOT NULL,
    type_ing VARCHAR(50) NOT NULL,
    img_ingr VARCHAR(255) DEFAULT 'ingr_default.jpg' CHECK (
        img_ingr LIKE '%.jpg' OR
        img_ingr LIKE '%.jpeg' OR
        img_ingr LIKE '%.png' OR
        img_ingr LIKE '%.gif' OR
        img_ingr LIKE '%.svg'
    ),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,

    INDEX idx_nom_ingr (nom_ingr),
    INDEX idx_type_ing (type_ing)
);

-- TABLE repas
CREATE TABLE IF NOT EXISTS repas (
    id_repas INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_repas VARCHAR(100) NOT NULL,
    prix_repas DECIMAL(10,2) NOT NULL CHECK (prix_repas >= 0),
    INDEX idx_repas_nom (nom_repas),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   deleted_at DATETIME DEFAULT NULL
);

-- TABLE plat_ingredient (N-N)
CREATE TABLE IF NOT EXISTS plat_ingredient (
    id_plat INT UNSIGNED NOT NULL,
    id_ingr INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_plat, id_ingr),

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   deleted_at DATETIME DEFAULT NULL,
    CONSTRAINT fk_pi_plat FOREIGN KEY (id_plat)
        REFERENCES plats(id_plat) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_pi_ingr FOREIGN KEY (id_ingr)
        REFERENCES ingredients(id_ingr) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_pi_plat (id_plat),
    INDEX idx_pi_ingr (id_ingr)
);


CREATE TABLE IF NOT EXISTS plat_repas (
    id_plat INT UNSIGNED NOT NULL,
    id_repas INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_plat, id_repas),
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   deleted_at DATETIME DEFAULT NULL,

    CONSTRAINT fk_pr_plat FOREIGN KEY (id_plat)
        REFERENCES plats(id_plat)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    CONSTRAINT fk_pr_repas FOREIGN KEY (id_repas)
        REFERENCES repas(id_repas)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    INDEX idx_pr_plat (id_plat),
    INDEX idx_pr_repas (id_repas)
);

-- TABLE reservation
CREATE TABLE IF NOT EXISTS reservation (
    id_reservat INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date_reservat DATE NOT NULL,
    date_command DATE DEFAULT CURRENT_DATE,
    nbperson TINYINT UNSIGNED NOT NULL CHECK (nbperson > 0),
    repas_choisi VARCHAR(100),
    heure_arrivee TIME,
    quantite_repas INT UNSIGNED NOT NULL DEFAULT 1 CHECK (quantite_repas >= 1),
    id_paiement TINYINT UNSIGNED NOT NULL,
    numero_tab INT UNSIGNED,
    commentaire TEXT DEFAULT NULL,
    id_utilisateur INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,
    
    CONSTRAINT fk_reservation_utilisateur FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    CONSTRAINT fk_reservation_table FOREIGN KEY (numero_tab)
        REFERENCES table_restaurant(numero_tab) ON DELETE SET NULL,
    CONSTRAINT fk_reservation_paiement FOREIGN KEY (id_paiement)
        REFERENCES moyens_paiement(id_paiement),
    
    INDEX idx_reserv_utilisateur (id_utilisateur),
    INDEX idx_reserv_tab (numero_tab),
    INDEX idx_reserv_date (date_reservat),
    INDEX idx_reserv_command (date_command),
    INDEX idx_reserv_paiement (id_paiement)
);


-- TABLE livraison
CREATE TABLE IF NOT EXISTS livraison (
    numero_liv INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date_liv DATE NOT NULL DEFAULT CURRENT_DATE,
    heure_liv TIME DEFAULT CURRENT_TIME,
    lieu_liv VARCHAR(255) NOT NULL,
    id_reservat INT UNSIGNED UNIQUE NOT NULL,
    id_livreur INT UNSIGNED NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,

    CONSTRAINT fk_livraison_reservation FOREIGN KEY (id_reservat) REFERENCES reservation(id_reservat),
    CONSTRAINT fk_livraison_livreur FOREIGN KEY (id_livreur) REFERENCES livreur(id_livreur),
    
    INDEX idx_liv_reserv (id_reservat),
    INDEX idx_liv_livreur (id_livreur),
    INDEX idx_liv_date (date_liv)
);
