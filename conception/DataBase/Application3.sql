CREATE DATABASE IF NOT EXISTS application;
USE application;

-- Table : Utilisateur
CREATE TABLE Utilisateur (
   id VARCHAR(36) PRIMARY KEY,
   nom VARCHAR(100) NOT NULL,
   prenom VARCHAR(100),
   email VARCHAR(150) NOT NULL UNIQUE,
   mot_de_passe VARCHAR(255) NOT NULL,
   date_invitation DATE NOT NULL,
   role VARCHAR(30) NOT NULL CHECK (role IN ('ADMIN', 'GESTIONNAIRE', 'CONSULTATION')),
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table : Invitation (inscription par invitation uniquement)
CREATE TABLE Invitation (
   id VARCHAR(36) PRIMARY KEY,
   email VARCHAR(150) NOT NULL UNIQUE,
   token VARCHAR(255) NOT NULL UNIQUE,
   date_envoi DATE NOT NULL,
   is_used BOOLEAN DEFAULT FALSE
);

-- Table : Formateur
CREATE TABLE Formateur (
   id VARCHAR(36) PRIMARY KEY,
   nom VARCHAR(100) NOT NULL,
   prenom VARCHAR(100),
   email VARCHAR(150) NOT NULL UNIQUE
);

-- Table : JourFerie
CREATE TABLE JourFerie (
   id VARCHAR(36) PRIMARY KEY,
   date DATE NOT NULL,
   nom VARCHAR(150) NOT NULL
);

-- Table : Formation
CREATE TABLE Formation (
   id VARCHAR(36) PRIMARY KEY,
   formateur_id VARCHAR(36) NOT NULL,
   actif BOOLEAN NOT NULL DEFAULT TRUE,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   nom VARCHAR(150) NOT NULL,
   numero VARCHAR(100),
   etat VARCHAR(30) NOT NULL CHECK (etat IN ('VALIDEE', 'EN_COURS_DE_VALIDATION')),
   titre_pro VARCHAR(150),
   niveau VARCHAR(100),
   nb_stagiaires_prevision VARCHAR(50),
   groupe_rattachement VARCHAR(100),
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   FOREIGN KEY (formateur_id) REFERENCES Formateur(id)
);

-- Table : Interruption
CREATE TABLE Interruption (
   id VARCHAR(36) PRIMARY KEY,
   formation_id VARCHAR(36) NOT NULL,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   motif VARCHAR(150) NOT NULL,
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (formation_id) REFERENCES Formation(id)
);

-- Table : PeriodeEntreprise
CREATE TABLE PeriodeEntreprise (
   id VARCHAR(36) PRIMARY KEY,
   formation_id VARCHAR(36) NOT NULL,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (formation_id) REFERENCES Formation(id)
);
