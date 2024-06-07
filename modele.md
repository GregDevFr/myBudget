# Modèle de Données pour l'Application de Gestion de Budget Personnel

## Entités Principales

### Utilisateur (User)
Représente un utilisateur de l'application.

| Nom du Champ       | Type       | Description                                |
|--------------------|------------|--------------------------------------------|
| id                 | int        | Identifiant unique                         |
| email              | string     | Adresse email de l'utilisateur             |
| password           | string     | Mot de passe (hashé)                       |
| nom                | string     | Nom de l'utilisateur                       |
| prenom             | string     | Prénom de l'utilisateur                    |
| date_naissance     | date       | Date de naissance                          |
| date_creation      | datetime   | Date de création du compte                 |
| date_modification  | datetime   | Date de dernière modification du compte    |

### Catégorie (Category)
Représente une catégorie de dépenses ou de revenus.

| Nom du Champ       | Type       | Description                                |
|--------------------|------------|--------------------------------------------|
| id                 | int        | Identifiant unique                         |
| nom                | string     | Nom de la catégorie                        |
| type               | string     | Type de la catégorie (dépense ou revenu)   |
| utilisateur        | User       | L'utilisateur propriétaire de la catégorie |

### Tiers (ThirdParty)
Représente un tiers lié à une transaction, qu'il soit une personne morale ou physique.

| Nom du Champ | Type   | Description                                 |
|--------------|--------|---------------------------------------------|
| id           | int    | Identifiant unique                          |
| nom          | string | Nom du tiers                                |
| type         | string | Type de tiers (personne morale ou physique) |
| utilisateur  | User   | L'utilisateur propriétaire du tiers         |

### Transaction (Transaction)
Représente une transaction financière réelle (dépense ou revenu).

| Nom du Champ | Type       | Description                                  |
|--------------|------------|----------------------------------------------|
| id           | int        | Identifiant unique                           |
| montant      | decimal    | Montant de la transaction                    |
| date         | datetime   | Date de la transaction                       |
| description  | string     | Description de la transaction                |
| categorie    | Category   | Catégorie de la transaction                  |
| utilisateur  | User       | L'utilisateur propriétaire de la transaction |
| tiers        | ThirdParty | Tiers lié à la transaction                   |

### Budget Mensuel (MonthlyBudget)
Représente le budget mensuel récurrent pour un utilisateur, contenant les transactions prévues pour le mois.

| Nom du Champ       | Type       | Description                                |
|--------------------|------------|--------------------------------------------|
| id                 | int        | Identifiant unique                         |
| utilisateur        | User       | L'utilisateur propriétaire du budget       |

### Transaction Prévue (PlannedTransaction)
Représente une transaction prévue dans le cadre d'un budget mensuel.

| Nom du Champ  | Type          | Description                          |
|---------------|---------------|--------------------------------------|
| id            | int           | Identifiant unique                   |
| montant       | decimal       | Montant de la transaction prévue     |
| description   | string        | Description de la transaction prévue |
| categorie     | Category      | Catégorie de la transaction prévue   |
| budgetMensuel | MonthlyBudget | Budget mensuel associé               |
| tiers         | ThirdParty    | Tiers lié à la transaction prévue    |

## Relations entre Entités

- Un `Utilisateur` peut avoir plusieurs `Catégories`.
- Un `Utilisateur` peut avoir plusieurs `Transactions`.
- Une `Catégorie` appartient à un `Utilisateur`.
- Un `Tiers` appartient à un `Utilisateur`.
- Une `Transaction` appartient à une `Catégorie` et à un `Utilisateur`.
- Une `Transaction` peut être liée à un `Tiers`.
- Un `Utilisateur` peut avoir plusieurs `Budgets Mensuels`.
- Un `Budget Mensuel` peut avoir plusieurs `Transactions Prévues`.
- Une `Transaction Prévue` appartient à un `Budget Mensuel`, à une `Catégorie`, et peut être liée à un `Tiers`.

