CREATE DATABASE rallye;
\c rallye;

-- Table des pilotes
CREATE TABLE pilote(
   id SERIAL PRIMARY KEY,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL
);

-- Table des copilotes
CREATE TABLE copilote(
   id SERIAL PRIMARY KEY,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL
);

-- Table des catégories
CREATE TABLE categorie(
   id SERIAL PRIMARY KEY,
   nom_categorie VARCHAR(50) NOT NULL
);

-- Table des postes
CREATE TABLE poste(
   id SERIAL PRIMARY KEY,
   type_poste VARCHAR(50) NOT NULL
);

-- Table des épreuves spéciales
CREATE TABLE epreuves_speciales(
   id SERIAL PRIMARY KEY,
   nom VARCHAR(100) NOT NULL,
   distance DECIMAL(10,2) NOT NULL
);

-- Table des équipages (liaison pilote-copilote)
CREATE TABLE equipage(
   id SERIAL PRIMARY KEY,
   id_pilote INTEGER NOT NULL,
   id_copilote INTEGER NOT NULL,
   id_categorie INTEGER NOT NULL,
   numero_equipage INTEGER UNIQUE NOT NULL,
   FOREIGN KEY(id_pilote) REFERENCES pilote(id),
   FOREIGN KEY(id_copilote) REFERENCES copilote(id),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id),
   UNIQUE(id_pilote, id_copilote)
);

-- Table des temps d'équipages sur les épreuves
CREATE TABLE resultat_epreuve(
   id SERIAL PRIMARY KEY,
   id_equipage INTEGER NOT NULL,
   id_epreuve INTEGER NOT NULL,
   temps TIME,
   penalite INTEGER DEFAULT 0,
   abandon BOOLEAN DEFAULT FALSE,
   FOREIGN KEY(id_equipage) REFERENCES equipage(id),
   FOREIGN KEY(id_epreuve) REFERENCES epreuves_speciales(id),
   UNIQUE(id_equipage, id_epreuve)
);