CREATE DATABASE IF NOT EXISTS application;
USE application;

-- Utilisateur
CREATE TABLE Utilisateur (
   IDUtilisateur VARCHAR(255) PRIMARY KEY,
   date_invitationUtil DATE NOT NULL,
   nomUtil VARCHAR(255) NOT NULL,
   prenomUtil VARCHAR(255),
   emailUtil VARCHAR(255) NOT NULL UNIQUE,
   mot_de_passeUtil VARCHAR(255) NOT NULL,
   roleUtil VARCHAR(50) NOT NULL CHECK(roleUtil IN ('ADMIN', 'GESTIONNAIRE', 'CONSULTATION')),
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Invitation
CREATE TABLE Invitation (
   id VARCHAR(255) PRIMARY KEY,
   email VARCHAR(255) NOT NULL UNIQUE,
   token VARCHAR(255) NOT NULL UNIQUE,
   date_envoi DATE NOT NULL,
   is_used BOOLEAN DEFAULT FALSE
);

-- Formateur
CREATE TABLE Formateur (
   IDFormateur VARCHAR(255) PRIMARY KEY,
   nomFormateur VARCHAR(255) NOT NULL,
   prenomFormateur VARCHAR(255),
   emailFormateur VARCHAR(255) NOT NULL UNIQUE
);

-- Jour férié
CREATE TABLE JourFerie (
   IDJour_ferie VARCHAR(255) PRIMARY KEY,
   dateJourFerie DATE NOT NULL,
   nomJourFerie VARCHAR(255) NOT NULL,
   date_debutJourFerie DATE NOT NULL,
   date_finJourFerie DATE NOT NULL
);

-- Formation
CREATE TABLE Formation (
   IDFormation VARCHAR(255) PRIMARY KEY,
   IDFormateur VARCHAR(255) NOT NULL,
   actifFormation BOOLEAN NOT NULL DEFAULT 1,
   date_debutFormation DATE NOT NULL,
   date_finFormation DATE NOT NULL,
   nomFormation VARCHAR(255) NOT NULL,
   numeroFormation VARCHAR(255),
   etatFormation VARCHAR(50) NOT NULL CHECK(etatFormation IN ('VALIDEE', 'EN_COURS_DE_VALIDATION')),
   titre_proFormation VARCHAR(255),
   niveauFormation VARCHAR(255),
   nb_stagiaires_previsionFormation VARCHAR(255),
   groupe_rattachementFormation VARCHAR(255),
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY(IDFormateur) REFERENCES Formateur(IDFormateur)
);

-- Interruption
CREATE TABLE Interruption (
   IDInterruption VARCHAR(255) PRIMARY KEY,
   IDFormation VARCHAR(255) NOT NULL,
   date_debutInterruption DATE NOT NULL,
   date_finInterruption DATE NOT NULL,
   motifInterruption VARCHAR(255) NOT NULL,
   FOREIGN KEY(IDFormation) REFERENCES Formation(IDFormation)
);

-- Période en entreprise
CREATE TABLE PeriodeEntreprise (
   IDPeriodeEntreprise VARCHAR(255) PRIMARY KEY,
   IDFormation VARCHAR(255) NOT NULL,
   date_debutPeriodeEntreprise DATE NOT NULL,
   date_finPeriodeEntreprise DATE NOT NULL,
   FOREIGN KEY(IDFormation) REFERENCES Formation(IDFormation)
);
