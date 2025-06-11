# ApplicationPlanning


## 🧱 Travail restant

### 🔐 **Rôles et sécurité**

* Configuration dans `security.yaml` :
  * Rôles : `ROLE_ADMIN`, `ROLE_GESTIONNAIRE`, `ROLE_CONSULTANT`
  * Redirection après login selon rôle
* Restrictions des routes :
  * Exemple : seules les personnes avec `ROLE_ADMIN` peuvent créer ou supprimer des formations
* Affichage conditionnel dans le menu selon le rôle

🎨 **Design / Layout**

* Base `base.html.twig` utilisée pour tous les templates
* Intégration Bootstrap (si utilisée)
* Uniformisation des formulaires

### 🧭 **Navigation**

* Création d’un menu global dynamique (navbar) avec :
  * Accès au planning
  * Accès au profil
  * Accès à l'administration (si admin)
  * Déconnexion

📅 **Planning**

* Création du **controller `PlanningController`**
* Affichage du planning **hebdomadaire** via un tableau
* Intégration de **Frappe Gantt.js** pour une vue interactive :
  * Zoom dynamique
  * Barres distinctes pour formations et périodes en entreprise
  * Affichage des jours fériés
* Prise en compte des **périodes entreprise** liées à chaque formation
* Liste des semaines calculée dynamiquement avec `DateHelper`

### 🔄 **Connexion / Inscription**

* Système d’authentification complet (en cours ou à ajouter si non fait)
* Fixtures de test avec 3 utilisateurs (1 par rôle)

### 🧪 **Librairie de gestion de dates (`DateHelper`)**

* Déjà entamée, mais à compléter/tester :
  * ✅ Obtenir le numéro de semaine ISO
  * ✅ Premier jour de la semaine
  * ✅ Premier jour du mois
  * ❌ Prochain jour travaillé
  * ❌ Liste des mois entre deux dates
  * ❌ Liste des semaines entre deux dates

### ✅ Tests / Déploiement

* Fixtures de test
* Tests manuels de toutes les pages
* Possibilité d’intégrer des tests automatisés (non prioritaire)

🧪 Utilisateurs de test à créer

| Rôle        | Email                | Mot de passe | Accès                       |
| ------------ | -------------------- | ------------ | ---------------------------- |
| Admin        | [admin@test.com]()      | admin123     | Toutes les fonctionnalités  |
| Gestionnaire | [gestion@test.com]()    | gestion123   | Gestion planning, formations |
| Consultant   | [consultant@test.com]() | consult123   | Lecture seule                |



## ✅ Fonctionnalités déjà implémentées

### 📘 **Entités / Données**

* `Formation` avec nom, dates, nombre de stagiaires
* `PeriodeEntreprise` (stage), reliée à une formation
* `JourFerie` pour exclure automatiquement certains jours
* `Utilisateur` avec profil (nom, prénom, email, mot de passe)

### 👤 **Profil utilisateur**

* Page de modification du profil (`ProfilController`, `ProfilType`)
* Changement d'email, nom, prénom, mot de passe
* Mot de passe modifiable mais facultatif

### 🧰 **Formulaires Symfony**

* Formulaire d’ajout / édition de formations
* Formulaire pour périodes en entreprise
* Formulaire pour jours fériés
* Formulaire profil utilisateur
