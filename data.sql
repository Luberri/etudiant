INSERT INTO etudiant (ETU, nom, prenom, dtn) VALUES
('ETU001', 'Rakoto', 'Jean', '2002-01-15'),
('ETU002', 'Randria', 'Miora', '2001-11-02'),
('ETU003', 'Rasolo', 'Kevin', '2002-05-20'),
('ETU004', 'Andriam', 'Fara', '2003-03-30'),
('ETU005', 'Rakotondr', 'Tiana', '2002-07-12');
INSERT INTO filiere (nom) VALUES ('Informatique');

INSERT INTO promotion (idFiliere) VALUES (1);
INSERT INTO option_ (nom) VALUES ('Développement');
-- SEMESTRE 1
INSERT INTO matiere (nom, UE) VALUES
('INF101 : Programmation procédurale', 'INF101'),
('INF104 : HTML et Introduction au Web', 'INF104'),
('INF107 : Informatique de Base', 'INF107'),
('MTH101 : Arithmétique et nombres', 'MTH101'),
('MTH102 : Analyse mathématique', 'MTH102'),
('ORG101 : Techniques de communication', 'ORG101');

INSERT INTO credit (idMatiere, idOption, semestre, credit) VALUES
(1, 1, 'S1', 7),
(2, 1, 'S1', 5),
(3, 1, 'S1', 4),
(4, 1, 'S1', 4),
(5, 1, 'S1', 6),
(6, 1, 'S1', 4);

-- SEMESTRE 2
INSERT INTO matiere (nom, UE) VALUES
('INF102 : Bases de données relationnelles', 'INF102'),
('INF103 : Administration système', 'INF103'),
('INF105 : Maintenance matériel et logiciel', 'INF105'),
('INF106 : Compléments de programmation', 'INF106'),
('MTH103 : Calcul Vectoriel et Matriciel', 'MTH103'),
('MTH105 : Probabilité et Statistique', 'MTH105');

INSERT INTO credit (idMatiere, idOption, semestre, credit) VALUES
(7, 1, 'S2', 5),
(8, 1, 'S2', 5),
(9, 1, 'S2', 4),
(10, 1, 'S2', 6),
(11, 1, 'S2', 6),
(12, 1, 'S2', 4);

-- SEMESTRE 3
INSERT INTO matiere (nom, UE) VALUES
('INF201 : Programmation orientée objet', 'INF201'),
('INF202 : Bases de données objets', 'INF202'),
('INF203 : Programmation système', 'INF203'),
('INF208 : Réseaux informatiques', 'INF208'),
('MTH201 : Méthodes numériques', 'MTH201'),
('ORG201 : Bases de gestion', 'ORG201');

INSERT INTO credit (idMatiere, idOption, semestre, credit) VALUES
(13, 1, 'S3', 6),
(14, 1, 'S3', 6),
(15, 1, 'S3', 4),
(16, 1, 'S3', 6),
(17, 1, 'S3', 4),
(18, 1, 'S3', 4);

-- SEMESTRE 4 (Option Développement)
INSERT INTO matiere (nom, UE) VALUES
('INF204 : Système d information géographique', 'INF204'),
('INF205 : Système d information', 'INF205'),
('INF206 : Interface Homme/Machine', 'INF206'),
('INF207 : Eléments d algorithmique', 'INF207'),
('INF210 : Mini-projet de développement', 'INF210'),
('MTH204 : Géométrie', 'MTH204'),
('MTH205 : Equations différentielles', 'MTH205'),
('MTH206 : Optimisation', 'MTH206'),
('MTH203 : MAO', 'MTH203');

-- Crédits (S4)
INSERT INTO credit (idMatiere, idOption, semestre, credit) VALUES
(19, 1, 'S4', 6),
(20, 1, 'S4', 6),
(21, 1, 'S4', 6),
(22, 1, 'S4', 6),
(23, 1, 'S4', 10),
(24, 1, 'S4', 4),
(25, 1, 'S4', 4),
(26, 1, 'S4', 4),
(27, 1, 'S4', 4);


INSERT INTO inscription (DateInscription, idEtudiant, semestre, idPromo) VALUES
('2025-01-10', 1, 'S1', 1),
('2025-01-10', 2, 'S1', 1),
('2025-01-10', 3, 'S1', 1),
('2025-01-10', 4, 'S1', 1),
('2025-01-10', 5, 'S1', 1);


INSERT INTO session (date) VALUES
('2025-03-20'),
('2025-06-25'),
('2025-10-15');

INSERT INTO avancement (idEtudiant, semestre, idSession) VALUES
(1, 'S1', 1),
(2, 'S1', 1),
(3, 'S1', 1),
(4, 'S1', 1),
(5, 'S1', 1);

INSERT INTO avancement (idEtudiant, semestre, idSession) VALUES
(1, 'S2', 2),
(2, 'S2', 2),
(3, 'S2', 2),
(4, 'S2', 2),
(5, 'S2', 2);
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(6, 7, 14.5),
(6, 8, 13.0),
(6, 9, 12.0),
(6, 10, 15.0),
(6, 11, 14.0),
(6, 12, 13.5);
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(7, 7, 12.5),
(7, 8, 11.0),
(7, 9, 14.0),
(7, 10, 13.5),
(7, 11, 15.0),
(7, 12, 12.0);
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(8, 7, 15.5),
(8, 8, 14.0),
(8, 9, 13.0),
(8, 10, 16.0),
(8, 11, 14.5),
(8, 12, 15.0);
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(9, 7, 11.5),
(9, 8, 12.0),
(9, 9, 10.0),
(9, 10, 13.0),
(9, 11, 12.5),
(9, 12, 11.0);
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(10, 7, 13.0),
(10, 8, 14.5),
(10, 9, 12.5),
(10, 10, 15.0),
(10, 11, 13.0),
(10, 12, 14.0);


-- Avancement pour S3
INSERT INTO avancement (idEtudiant, semestre, idSession) VALUES
(1, 'S3', 3),
(2, 'S3', 3);

-- Avancement pour S4
INSERT INTO avancement (idEtudiant, semestre, idSession) VALUES
(1, 'S4', 3),
(2, 'S4', 3);

-- Notes pour S3 (étudiant 1 et 2)
-- idMatiere pour S3 : 13 à 18
-- Étudiant 1 (idAvancement = 11)
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(11, 13, 15.0),
(11, 14, 14.5),
(11, 15, 13.0),
(11, 16, 16.0),
(11, 17, 14.0),
(11, 18, 15.5);

-- Étudiant 2 (idAvancement = 12)
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(12, 13, 14.0),
(12, 14, 13.5),
(12, 15, 12.0),
(12, 16, 15.0),
(12, 17, 13.5),
(12, 18, 14.0);

-- Notes pour S4 (étudiant 1 et 2)
-- idMatiere pour S4 : 19 à 27
-- Étudiant 1 (idAvancement = 13)
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(13, 19, 15.0),
(13, 20, 14.5),
(13, 21, 13.0),
(13, 22, 16.0),
(13, 23, 15.5),
(13, 24, 14.0),
(13, 25, 13.5),
(13, 26, 15.0),
(13, 27, 14.0);

-- Étudiant 2 (idAvancement = 14)
INSERT INTO note (idAvancement, idMatiere, note) VALUES
(14, 19, 14.0),
(14, 20, 13.5),
(14, 21, 12.0),
(14, 22, 15.0),
(14, 23, 14.5),
(14, 24, 13.0),
(14, 25, 12.5),
(14, 26, 14.0),
(14, 27, 13.5);
