# API Gestion Comptes

API Laravel pour la gestion des comptes bancaires avec création automatique de clients et utilisateurs.

## Fonctionnalités

- Création de comptes avec recherche automatique de clients
- Génération automatique de numéros de compte séquentiels
- Gestion des soldes initiaux
- Authentification utilisateur avec génération de mots de passe et codes de vérification
- Événements pour notifications SMS/Email

## API Endpoints

### Créer un compte
**POST** `/api/v1/comptes`

#### Requête (Request)
```json
{
  "client_id": "uuid", // Optionnel - si fourni, recherche par client_id
  "telephone": "string", // Optionnel - si fourni, recherche par téléphone
  "email": "string", // Optionnel - si fourni, recherche par email
  "nci": "string", // Optionnel - si fourni, recherche par numéro CNI
  "titulaire": "string", // Obligatoire si client n'existe pas
  "adresse": "string", // Optionnel
  "type": "string", // Optionnel - défaut: "cheque"
  "devise": "string", // Optionnel - défaut: "FCFA"
  "soldeInitial": "number" // Optionnel - si > 0, crée une transaction de dépôt
}
```

#### Réponse de succès (Success Response)
```json
{
  "success": true,
  "message": "compte crée avec succés",
  "data": {
    "id": "uuid",
    "titulaire": "string",
    "numero_compte": "CPT000001",
    "type": "cheque",
    "devise": "FCFA",
    "date_ouverture": "2025-11-05T14:00:00.000000Z",
    "statut": "actif",
    "motif_blocage": null,
    "solde": 0,
    "created_at": "2025-11-05T14:00:00.000000Z",
    "links": {
      "self": "http://localhost:8000/api/v1/comptes/uuid",
      "update": "http://localhost:8000/api/v1/comptes/uuid",
      "delete": "http://localhost:8000/api/v1/comptes/uuid"
    }
  }
}
```

#### Réponse d'erreur (Error Response)
```json
{
  "success": false,
  "message": "erreur lors de la creation du compte",
  "data": {
    "client_id": "uuid",
    "telephone": "string",
    // ... autres données de la requête
  }
}
```

### Lister les comptes
**GET** `/api/v1/comptes`

#### Réponse de succès
```json
{
  "success": true,
  "message": "Liste des comptes récupérée avec succès",
  "data": [
    {
      "id": "uuid",
      "titulaire": "string",
      "numero_compte": "CPT000001",
      "type": "cheque",
      "devise": "FCFA",
      "date_ouverture": "2025-11-05T14:00:00.000000Z",
      "statut": "actif",
      "motif_blocage": null,
      "solde": 1000.00,
      "created_at": "2025-11-05T14:00:00.000000Z",
      "links": {
        "self": "http://localhost:8000/api/v1/comptes/uuid",
        "update": "http://localhost:8000/api/v1/comptes/uuid",
        "delete": "http://localhost:8000/api/v1/comptes/uuid"
      }
    }
  ]
}
```

## Règles métier

### Recherche de client
La recherche se fait par ordre de priorité :
1. `client_id` (si fourni)
2. `telephone` (si fourni)
3. `email` (si fourni)
4. `nci` (si fourni)

### Création automatique
- **Si client n'existe pas** : Création du client + utilisateur avec mot de passe et code générés
- **Si client existe sans utilisateur** : Création de l'utilisateur avec mot de passe et code générés
- **Si client existe avec utilisateur** : Utilisation de l'utilisateur existant

### Génération automatique
- **Mot de passe** : 10 caractères aléatoires
- **Login** : téléphone ou email ou "userXXXX"
- **Code de vérification** : 6 chiffres aléatoires
- **Numéro de compte** : "CPT" + numéro séquentiel (ex: CPT000001)
- **Statut** : "actif" par défaut
- **Date d'ouverture** : date actuelle

### Transaction initiale
Si `soldeInitial > 0`, une transaction de dépôt est créée automatiquement avec :
- Type : "depot"
- Description : "Solde initial"
- Montant : valeur de `soldeInitial`

### Sécurité
- Les mots de passe sont hashés avec bcrypt
- Tout est encapsulé dans une transaction DB (rollback en cas d'erreur)
- Événement `CompteCreated` déclenché pour les notifications

## Technologies utilisées

- Laravel 11
- PHP 8.2+
- MySQL/PostgreSQL
- UUID pour les identifiants

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
