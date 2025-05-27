CREATE DATABASE IF NOT EXISTS application;
USE application;

CREATE TABLE JourFerie(
   IDJour_ferie VARCHAR(255) ,
   dateJourFerie DATE NOT NULL,
   nomJourFerie VARCHAR(255)  NOT NULL,
   date_debutJourFerie DATE NOT NULL,
   date_finJourFerie DATE NOT NULL,
   PRIMARY KEY(IDJour_ferie)
);

CREATE TABLE Utilisateur(
   IDUtilisateur VARCHAR(255) ,
   date_invitationUtil DATE NOT NULL,
   nomUtil VARCHAR(255)  NOT NULL,
   prenomUtil VARCHAR(255) ,
   emailUtil VARCHAR(255)  NOT NULL,
   mot_de_passeUtil VARCHAR(255)  NOT NULL,
   roleUtil VARCHAR(255)  NOT NULL,
   PRIMARY KEY(IDUtilisateur)
);

CREATE TABLE Formateur(
   IDFormateur VARCHAR(255) ,
   nomFormateur VARCHAR(255)  NOT NULL,
   prenomFormateur VARCHAR(255) ,
   emailFormateur VARCHAR(255)  NOT NULL,
   PRIMARY KEY(IDFormateur)
);

CREATE TABLE Formation(
   IDFormation VARCHAR(255) ,
   formateur_IDFormation VARCHAR(255) ,
   actifFormation BOOLEAN NOT NULL,
   date_debutFormation DATE NOT NULL,
   date_finFormation DATE NOT NULL,
   nomFormation VARCHAR(255)  NOT NULL,
   numeroFormation VARCHAR(255)  NOT NULL,
   etatFormation VARCHAR(255)  NOT NULL,
   titre_proFormation VARCHAR(255)  NOT NULL,
   niveauFormation VARCHAR(255)  NOT NULL,
   nb_stagiaires_previsionFormation VARCHAR(255)  NOT NULL,
   groupe_rattachementFormation VARCHAR(255)  NOT NULL,
   IDFormateur VARCHAR(255)  NOT NULL,
   PRIMARY KEY(IDFormation, formateur_IDFormation),
   FOREIGN KEY(IDFormateur) REFERENCES Formateur(IDFormateur)
);

CREATE TABLE Interruption(
   IDInterruption VARCHAR(255) ,
   IDformation_idInterruption VARCHAR(255) ,
   date_debutInterruption DATE NOT NULL,
   date_finInterruption DATE NOT NULL,
   motifInterruption VARCHAR(255)  NOT NULL,
   IDFormation VARCHAR(255)  NOT NULL,
   formateur_IDFormation VARCHAR(255)  NOT NULL,
   PRIMARY KEY(IDInterruption, IDformation_idInterruption),
   FOREIGN KEY(IDFormation, formateur_IDFormation) REFERENCES Formation(IDFormation, formateur_IDFormation)
);

CREATE TABLE PeriodeEntreprise(
   IDPeriodeEntreprise VARCHAR(255) ,
   IDformation_idPeriodeEntreprise VARCHAR(255) ,
   date_debutPeriodeEntreprise DATE NOT NULL,
   date_finPeriodeEntreprise VARCHAR(255)  NOT NULL,
   IDFormation VARCHAR(255)  NOT NULL,
   formateur_IDFormation VARCHAR(255)  NOT NULL,
   PRIMARY KEY(IDPeriodeEntreprise, IDformation_idPeriodeEntreprise),
   FOREIGN KEY(IDFormation, formateur_IDFormation) REFERENCES Formation(IDFormation, formateur_IDFormation)
);
