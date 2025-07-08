INSERT INTO roles (nom_role, description) VALUES
('serveur', 'Personnel chargé du service en salle'),
('cuisinier', 'Prépare les plats en cuisine'),
('livreur', 'Assure les livraisons à domicile'),
('admin', 'Administrateur de la plateforme');


INSERT INTO moyens_paiement (type_paiement, description) VALUES
('carte', 'Paiement par carte bancaire'),
('espece', 'Paiement en espèces'),
('en ligne', 'Paiement en ligne via application');


INSERT INTO utilisateur (nom, prenom, email, telephone) VALUES
('Toure', 'Fatou', 'fatou.toure@mail.com', '0600000001'),
('Benali', 'Yassine', 'yassine.benali@mail.com', '0600000002'),
('Kouadio', 'Jean', 'jean.kouadio@mail.com', '0600000003'),
('Dupont', 'Jean', 'jean.dupont@mail.com', '0612345678'),
('Martin', 'Claire', 'claire.martin@mail.com', '0654321098'),
('Durand', 'Paul', 'paul.durand@mail.com', NULL),
('Nguyen', 'Linh', 'linh.nguyen@mail.com', '0601020304'),
('Bakayoko', 'Awa', 'awa.bakayoko@mail.com', '0699988776'),
('Nana', 'Grace', 'grace.nana@mail.com', '0600000004');


INSERT INTO clients (pseudo, id_utilisateur) VALUES
('Fatou001', 1),
('YBen', 2),
('jeanjean', 3),
('clairette', 5),
('paulo', 6);


INSERT INTO personnel (matricule, id_role, id_utilisateur) VALUES
(1001, 1, 3), -- serveur
(1002, 2, 4); -- cuisinier

INSERT INTO serveur (id_personnel) VALUES
(5),
(1); -- correspond à personnel.matricule 1001


INSERT INTO livreur (id_utilisateur) VALUES
(2),
(3); -- même utilisateur que le serveur pour exemple



INSERT INTO table_restaurant (numero_tab, nbre_place) VALUES
(1, 2),
(2, 4),
(3, 6),
(4, 4),
(5, 2),
(6, 6),
(7, 4),
(8, 8);


INSERT INTO plats (nom_plat, prix_plats, type_plats) VALUES
('Pizza Margherita', 70.00, 1),
('Tajine Poulet', 85.50, 2),
('Burger Maison', 60.00, 1),
('Pizza Margherita', 8.90, 1),
('Poulet Yassa', 12.50, 2),
('Sushi Maki', 14.00, 3),
('Burger Maison', 10.50, 1),
('Tajine Agneau', 13.80, 2);


INSERT INTO ingredients (nom_ingr, type_ing) VALUES
('Tomate', 'légume'),
('Poulet', 'viande'),
('Fromage', 'produit laitier'),
('Pain', 'féculent'),
('Tomate', 'Légume'),
('Fromage', 'Laitier'),
('Poulet', 'Viande'),
('Riz', 'Céréale'),
('Oignon', 'Légume');


INSERT INTO repas (nom_repas, prix_repas) VALUES
('Menu Midi', 20.00),
('Formule Étudiante', 9.00),
('Menu Étudiant', 15.00),
('Menu Familial', 25.00),
('Menu Végétarien', 18.00);;


INSERT INTO plat_ingredient (id_plat, id_ingr) VALUES
(1, 1), -- Pizza - Tomate
(1, 3), -- Pizza - Fromage
(2, 2), -- Tajine - Poulet
(3, 3), -- Burger - Fromage
(3, 4), -- Burger - Pain
(5, 3), (5, 5),   -- Poulet Yassa: Poulet, Oignon


INSERT INTO plat_repas (id_plat, id_repas) VALUES
(1, 1), -- Pizza dans Menu Midi
(2, 1), -- Tajine dans Menu Midi
(3, 2), -- Burger dans Formule Étudiante
(4, 2),  -- Menu Familial
(1, 3), (5, 3);  -- Menu Végétarien


INSERT INTO reservation (
    date_reservat, nbperson, repas_choisi, heure_arrivee,
    quantite_repas, id_paiement, numero_tab, commentaire, id_utilisateur
) VALUES
('2025-07-04', 2, 'Menu Midi', '12:30:00', 2, 1, 1, 'Allergie aux noix', 1),
('2025-07-05', 4, 'Formule Étudiante', '13:00:00', 4, 2, 2, '', 2),
(CURDATE(), 3, 'Menu Végétarien', '19:30:00', 3, 3, 4, 3);


INSERT INTO livraison (
    date_liv, heure_liv, lieu_liv, id_reservat, id_livreur
) VALUES
('2025-07-04', '13:30:00', '12 rue des oliviers, Rabat', 1, 1),
('2025-07-05', '13:45:00', 'Université Mohamed V', 2, 1);
