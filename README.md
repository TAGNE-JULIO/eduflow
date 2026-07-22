<div align="center">
  <img src="public/application-images/skuul-logo.png" alt="Logo Skuul" width="120" />
  <h1>🎓 Skuul - Système Intégré de Gestion Scolaire (ERP)</h1>
  <p>Une solution logicielle complète, moderne et performante pour la gestion numérisée des établissements scolaires.</p>
</div>

---

## 📖 Introduction

**Skuul** est un Système de Gestion Scolaire (ERP - Enterprise Resource Planning) complet et robuste, développé avec le puissant framework **Laravel (PHP)**, la technologie réactive **Livewire**, et l'élégance de **Tailwind CSS**. 

Ce système a pour vocation de numériser intégralement l'infrastructure des écoles (primaires, secondaires, lycées, etc.) en gérant chaque aspect du cycle de vie académique : de la gestion des admissions à la facturation des frais de scolarité, en passant par les évaluations, les emplois du temps et la communication.

Doté d'une interface utilisateur (UI) premium, moderne et parfaitement responsive (adaptable sur PC, tablettes et smartphones), Skuul réduit la fracture entre l'administration, le corps enseignant, les parents et les élèves grâce à des tableaux de bord interactifs et des processus hautement optimisés.

---

## 🎯 Public Cible

Cette application s'adresse principalement aux :
- **Écoles Maternelles, Primaires et Secondaires** souhaitant se moderniser.
- **Lycées et Instituts d'Enseignement Supérieur** nécessitant une plateforme fiable pour les notes, les emplois du temps, et la gestion des paiements.
- **Directeurs, Fondateurs et Administrateurs Scolaires** ayant pour but d'éliminer la paperasse, d'automatiser les tâches chronophages et de centraliser les bases de données de l'établissement.

---

## 🎭 Acteurs du Système et Leurs Fonctionnalités

Le cœur de **Skuul** repose sur un contrôle d'accès basé sur les rôles (RBAC) extrêmement précis. L'application déploie 7 acteurs principaux disposant de fonctionnalités sur mesure.

### 1. 👑 Le Super-Administrateur (Fondateur / Directeur Général)
Il possède le plus haut niveau d'autorisation et contrôle l'infrastructure racine de l'application.
* **Configuration Globale de l'École** : Paramétrage du profil de l'école (nom, logo, informations de contact).
* **Supervision Systémique** : Gestion totale des autres administrateurs, blocage ou déblocage des comptes utilisateurs en un clic.
* **Structuration Temporelle** : Création et définition des Années Académiques et configuration des Semestres (Trimestres/Semestres).

### 2. 👨‍💼 L'Administrateur Scolaire (Secrétariat / Proviseur)
Il est le moteur des opérations quotidiennes de l'école.
* **Gestion des Utilisateurs** : Création, modification et suppression des profils (Enseignants, Élèves, Parents, Comptables).
* **Structure Académique** : Création des Classes, affectation des Sections, et regroupement des niveaux (Class Groups).
* **Admissions** : Traitement des candidatures (acceptation, rejet, ou mise en attente des postulants).
* **Progression des Élèves** : Gestion cruciale des promotions en fin d'année scolaire, gestion des redoublements, et traitement des remises de diplômes (Graduations).
* **Ingénierie du Curriculum** : Création des matières (Subjects) et affectation stratégique des enseignants à ces matières selon les classes.
* **Communication Interne** : Création et diffusion de notes d'information (Notices) visibles sur les tableaux de bord des autres acteurs.

### 3. 👩‍🏫 L'Enseignant (Professeur)
Il est l'artisan de la pédagogie et de l'évaluation continue.
* **Syllabus et Ressources** : Création et gestion du programme de cours (Syllabi) pour guider les élèves au fil du semestre.
* **Gestion du Temps** : Consultation de son emploi du temps personnalisé (Timetables) et suivi des créneaux horaires attribués.
* **Évaluations et Examens** :
  * Création d'examens et définition des plages horaires d'évaluation (Exam Slots).
  * Saisie rapide et sécurisée des notes des élèves (Exam Records).
  * Génération instantanée des fiches de résultats (Tabulation Sheets) pour évaluer la performance globale de la classe.

### 4. 👨‍👩‍👧 Le Parent d'Élève (Tuteur)
Il est le garant de l'accompagnement éducatif et financier de l'enfant à domicile.
* **Suivi Pédagogique** : Grâce au module "Result Checker", le parent peut consulter en direct les notes et bulletins de ses enfants rattachés, sans se déplacer à l'école.
* **Transparence Financière** : Consultation des factures scolaires (Fee Invoices) et accès complet à l'historique des paiements de scolarité (Fee Invoice Records).
* **Veille Informative** : Réception et lecture des notes d'information importantes envoyées par l'administration.

### 5. 🧑‍🎓 L'Élève / Étudiant
L'utilisateur au centre du processus éducatif.
* **Environnement Académique** : Accès à son emploi du temps personnel, consultation du programme des matières (Syllabi), et visionnage de ses informations de classe.
* **Résultats Sécurisés** : Vérification des notes d'examen et des relevés de fin de semestre via le module de consultation de résultats (Result Checker).
* **Facturation** : Transparence sur sa situation financière grâce à la consultation de ses factures et des soldes restants à payer.

### 6. 💵 Le Comptable (Administration Financière)
Il est le pilier financier assurant la santé économique de l'établissement.
* **Architecture Tarifaire** : Création et définition des différentes catégories de frais (ex: Inscription, Scolarité, Cantine, Transport).
* **Facturation Automatisée** : Génération de factures (Fee Invoices) personnalisées par élève ou groupées par classe entière.
* **Paiements et Recouvrements** : Enregistrement des paiements reçus (partiels ou complets), émission de reçus officiels, et suivi rigoureux des impayés.

### 7. 📝 Le Postulant (Candidat)
Un utilisateur externe souhaitant s'inscrire ou inscrire son enfant.
* **Dossier de Candidature** : Soumission numérique de ses informations pour rejoindre l'établissement.
* **Suivi de Dossier** : Accès à un tableau de bord restreint permettant uniquement de suivre le statut de son dossier (En cours, Approuvé, Rejeté).

---

## 🚀 Feuille de Route (Roadmap) : Pistes d'Améliorations Majeures

Bien que Skuul soit déjà très complet, voici une vision ambitieuse pour rendre l'application encore plus incontournable. L'implémentation de ces fonctionnalités décuplera la valeur du système :

### 🌟 Pour les Administrateurs :
1. **Module de Ressources Humaines (RH) et Paie** : 
   - Automatiser le calcul des salaires des professeurs et du staff administratif.
   - Gérer les fiches de paie, les demandes de congés et le pointage numérique.
2. **Tableau de Bord Analytique et Décisionnel (Business Intelligence)** :
   - Intégrer des graphiques dynamiques (ex: Chart.js) pour visualiser l'évolution des effectifs, le taux de réussite global par matière, et les flux de trésorerie mensuels.
3. **Gestion des Stocks et Actifs (Inventory Management)** :
   - Tracer le matériel scolaire (ordinateurs, laboratoires, livres de la bibliothèque).

### 🌟 Pour les Enseignants et la Pédagogie :
1. **Devoirs et E-learning (LMS Intégré)** :
   - Permettre aux professeurs de publier des devoirs en ligne que les élèves pourront rendre directement via la plateforme.
2. **Appel Numérique (Suivi des Présences)** :
   - Registre d'appel dématérialisé avec alerte SMS ou e-mail automatique envoyée aux parents en cas d'absence injustifiée.
3. **Carnet de Correspondance / Discipline** :
   - Consigner le comportement, les encouragements, les blâmes ou avertissements directement sur le dossier numérique de l'élève.

### 🌟 Pour les Parents et les Élèves :
1. **Passerelle de Paiement en Ligne** :
   - Intégration de Stripe, PayPal ou de solutions Mobile Money (ex: Orange Money, Wave) pour payer la scolarité directement en ligne, depuis chez soi.
2. **Messagerie Sécurisée (Chat Parent-Professeur)** :
   - Un système de messagerie interne permettant aux parents et professeurs d'échanger sans partager leurs numéros de téléphone privés.
3. **Notifications Push / Web** :
   - Alertes en temps réel sur le navigateur ou le téléphone à chaque nouvelle note publiée, nouvel examen programmé, ou paiement enregistré.

### 🌟 Améliorations Techniques du Système :
1. **Application Mobile Compagnon (API REST)** :
   - Développer l'API pour permettre la création d'une application mobile Skuul (Android & iOS).
2. **Architecture Multi-Tenante (SaaS)** :
   - Permettre à une seule instance du serveur de gérer simultanément des dizaines d'écoles différentes, ouvrant la voie à une commercialisation sous forme d'abonnement.

---

## 🛠️ Stack Technologique & Guide d'Installation

- **Backend / Logique Serveur** : Laravel 10 (PHP 8.1+)
- **Frontend / Réactivité** : Blade, Livewire 3, Alpine.js
- **Design System** : Tailwind CSS (Thème moderne "Slate/Indigo", effet Glassmorphism, UI ultra soignée)
- **Base de Données** : MySQL (ou MariaDB)

### 💻 Installation Rapide (Environnement de Développement)

Ouvrez votre terminal et suivez ces instructions pour lancer le projet :

```bash
# 1. Cloner le projet depuis GitHub
git clone https://github.com/yungifez/skuul.git

# 2. Installer les dépendances backend et frontend
composer install
npm install

# 3. Préparer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données (Assurez-vous que MySQL est actif et éditez le .env)
php artisan migrate
# Remplir la base avec les pays, villes et états (prend quelques minutes)
php artisan db:seed --class=WorldSeeder
# Insérer les rôles, les paramètres par défaut et les faux utilisateurs pour tester
php artisan db:seed 

# 5. Démarrer les serveurs locaux
php artisan serve
npm run dev
```

Une fois les serveurs lancés, ouvrez votre navigateur et accédez à l'application via `http://localhost:8000`.

*Ce projet est maintenu avec passion pour révolutionner la gestion scolaire de demain.*
#   e d u f l o w  
 