Cas d'utilisation : Ajouter une formation
Acteurs :

    Gestionnaire

    (Admin, ayant aussi les droits du gestionnaire)

------------------------------------------------------------------------------------------------------------------

Préconditions :

    L'utilisateur est connecté et possède le rôle Gestionnaire ou Administrateur

    Le système est disponible

------------------------------------------------------------------------------------------------------------------

Flux principal :
-------------------------


    Le gestionnaire accède à l’interface « Ajouter une formation »

    Le système affiche un formulaire de création de formation

    Le gestionnaire saisit les informations suivantes :

        Nom de la formation

        État (validée ou en cours de validation)

        Titre professionnel éventuel

        Niveau (ministère du Travail)

        Nombre de stagiaires prévisionnel

        Groupe de rattachement (grn)

        Formateur

        Date de début et date de fin

        Périodes en entreprise (0 ou plusieurs)

        Interruptions (congés éventuels)

    Le gestionnaire valide le formulaire

    Le système vérifie la validité des données :

        Dates cohérentes (début < fin)

        Champs obligatoires remplis

    Le système enregistre la formation en base de données

    Le système affiche un message de confirmation

    Le planning est mis à jour automatiquement

--------------------------------------------------------------------------------------------------------------------------

Flux alternatifs :
------------------
A1 — L’utilisateur annule la création :

    À tout moment, le gestionnaire peut annuler l’ajout

    Le système retourne à la liste des formations sans enregistrer quoi que ce soit

A2 — Données incomplètes ou erronées :

    Étape 5 : Si des champs sont vides ou invalides (ex. date de fin < date de début)

    Le système affiche un message d’erreur et met en évidence les champs concernés

    Retour à l’étape 3 pour correction

A3 — Problème technique (ex. base de données indisponible) :

    Étape 6 : Si une erreur survient à l’enregistrement

    Le système affiche un message d’erreur : « Une erreur est survenue, veuillez réessayer »

    L’utilisateur peut réessayer ou annuler (retour au flux A1)
    
A4 - Pas Assez de stagiaire pour la formation : La formation ne démarre pas

---------------------------------------------------------------------------------------------------------------------------------------

Postconditions (résultat attendu) :
-----------------------------------

    La formation est enregistrée dans le système

    Elle apparaît dans le planning général (diagramme de Gantt)

    Les utilisateurs autorisés peuvent la consulter
