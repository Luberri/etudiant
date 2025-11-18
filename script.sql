CREATE DATABASE IF NOT EXISTS gestion_scolarite;
USE gestion_scolarite;

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ETU VARCHAR(50),
    nom VARCHAR(100),
    prenom VARCHAR(100),
    dtn DATE
);

CREATE TABLE filiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE promotion (
    idProm INT AUTO_INCREMENT PRIMARY KEY,
    idFiliere INT,
    FOREIGN KEY (idFiliere) REFERENCES filiere(id)
);

CREATE TABLE inscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    DateInscription DATE,
    idEtudiant INT,
    semestre VARCHAR(20),
    idPromo INT,
    FOREIGN KEY (idEtudiant) REFERENCES etudiant(id),
    FOREIGN KEY (idPromo) REFERENCES promotion(idProm)
);

CREATE TABLE session (
    idSession INT AUTO_INCREMENT PRIMARY KEY,
    date DATE
);

CREATE TABLE avancement (
    idAvancement INT AUTO_INCREMENT PRIMARY KEY,
    idEtudiant INT,
    semestre VARCHAR(20),
    idSession INT,
    FOREIGN KEY (idEtudiant) REFERENCES etudiant(id),
    FOREIGN KEY (idSession) REFERENCES session(idSession)
);

CREATE TABLE option (
    idOption INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE matiere (
    idMatiere INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150),
    UE VARCHAR(50)
);

CREATE TABLE credit (
    idCredit INT AUTO_INCREMENT PRIMARY KEY,
    idMatiere INT,
    idOption INT,
    semestre VARCHAR(20),
    credit INT,
    ensembleOptionnel INT NULL,
    FOREIGN KEY (idMatiere) REFERENCES matiere(idMatiere),
    FOREIGN KEY (idOption) REFERENCES option_(idOption)
);

CREATE TABLE note (
    idNote INT AUTO_INCREMENT PRIMARY KEY,
    idAvancement INT,
    idMatiere INT,
    note DECIMAL(5,2),
    FOREIGN KEY (idAvancement) REFERENCES avancement(idAvancement),
    FOREIGN KEY (idMatiere) REFERENCES matiere(idMatiere)
);

CREATE TABLE rattrapage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idAvancement INT,
    idMatiere INT,
    noteRattrapage DECIMAL(5,2),
    FOREIGN KEY (idAvancement) REFERENCES avancement(idAvancement),
    FOREIGN KEY (idMatiere) REFERENCES matiere(idMatiere)
);
