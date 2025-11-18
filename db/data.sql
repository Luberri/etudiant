INSERT INTO pilote (nom, prenom) VALUES
('Loeb', 'Sébastien'),
('Ogier', 'Sébastien'),
('Evans', 'Elfyn'),
('Neuville', 'Thierry'),
('Tänak', 'Ott'),
('Rovanperä', 'Kalle'),
('Breen', 'Craig'),
('Fourmaux', 'Adrien');

-- Données pour la table copilote
INSERT INTO copilote (nom, prenom) VALUES
('Elena', 'Daniel'),
('Ingrassia', 'Julien'),
('Martin', 'Scott'),
('Wydaeghe', 'Martijn'),
('Järveoja', 'Martin'),
('Halttunen', 'Jonne'),
('Nagle', 'Paul'),
('Coria', 'Alexandre');

-- Données pour la table categorie
INSERT INTO categorie (nom_categorie) VALUES
('R5'),
('R4'),
('M12'),
('M10'),
('M11');

-- Données pour la table poste
INSERT INTO poste (type_poste) VALUES
('Départ'),
('Arrivée'),
('Contrôle horaire'),
('Ravitaillement'),
('Assistance');

-- Données pour la table epreuves_speciales
INSERT INTO epreuves_speciales (nom, distance) VALUES
('ES1 - Col de Turini', 14.90),
('ES2 - La Bollène-Vésubie', 23.25),
('ES3 - Peïra-Cava', 27.68),
('ES4 - La Cabanette', 15.97),
('ES5 - Entrevaux', 17.50);

-- Données pour la table equipage
INSERT INTO equipage (id_pilote, id_copilote, id_categorie, numero_equipage) VALUES
(1, 1, 1, 1),  -- Loeb/Elena en R5
(2, 2, 1, 2),  -- Ogier/Ingrassia en R5
(3, 3, 2, 3),  -- Evans/Martin en R4
(4, 4, 3, 4),  -- Neuville/Wydaeghe en M12
(5, 5, 4, 5),  -- Tänak/Järveoja en M10
(6, 6, 5, 6),  -- Rovanperä/Halttunen en M11
(7, 7, 1, 7),  -- Breen/Nagle en R5
(8, 8, 2, 8);  -- Fourmaux/Coria en R4

-- Données pour la table resultat_epreuve
INSERT INTO resultat_epreuve (id_equipage, id_epreuve, temps, penalite, abandon) VALUES
-- ES1 résultats
(1, 1, '00:08:45', 0, FALSE),
(2, 1, '00:08:52', 0, FALSE),
(3, 1, '00:09:15', 10, FALSE),
(4, 1, '00:09:32', 0, FALSE),
(5, 1, '00:09:18', 0, FALSE),
-- ES2 résultats
(1, 2, '00:13:22', 0, FALSE),
(2, 2, '00:13:45', 0, FALSE),
(3, 2, '00:14:12', 0, FALSE),
(4, 2, NULL, 0, TRUE),  -- Abandon
(5, 2, '00:14:05', 20, FALSE),
-- ES3 résultats
(1, 3, '00:16:45', 0, FALSE),
(2, 3, '00:16:52', 0, FALSE),
(3, 3, '00:17:25', 0, FALSE),
(5, 3, '00:17:15', 0, FALSE),
-- ES4 résultats
(1, 4, '00:09:12', 0, FALSE),
(2, 4, '00:09:25', 0, FALSE),
(3, 4, '00:09:45', 5, FALSE),
(5, 4, '00:09:38', 0, FALSE),
-- ES5 résultats
(1, 5, '00:10:35', 0, FALSE),
(2, 5, '00:10:42', 0, FALSE),
(3, 5, '00:11:05', 0, FALSE),
(5, 5, '00:10:58', 0, FALSE);