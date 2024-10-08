## API Profiles
** **
### Déploiement du projet
** **

Pré-requis:
    
* utiliser php 8.3
* avoir composer installé
* renseigner les coordonnées de votre base de données dans le .env

Exécuter les commandes suivant (depuis Linux) :

``` bash 
composer install
```
``` bash
npm i
```
``` bash
php artisan migrate:refresh
```
``` bash
php artisan db:seed
```

** **
### Endpoints

#### Routes publics ne nécessitent pas d'être authentifié :
1. Route : __/api/profiles__ méthode : **GET**
   - Index des 15 premiers profiles ayants le status *actif* (info de pagination dans la réponse), l'information *status* n'est pas visible/accessible, il faut être authentifié pour qu'il soit affiché.
       

        Exemple d'appel :    
      {
         {   
           "email": "toto@gmail.com"  string requied
           "password":"password"  string requied
         }  

        Exemple de retour:  
        {
    "success": true,
    "message": "Index of Profiles",
    "additional": {
        "meta": {
            "total": 2,
            "page": 1
        },
        "links": {
            "self": "http://apiprofile.local/api/profiles?page=1",
            "next": null
        }
    },
    "data": [
        {
            "id": 2,
            "last_name": "Torp",
            "first_name": "Marianne",
            "avatar": "/tmp/fakercFsSHQ",
            "created_at": "08-08-2024 "
        },
        {
            "id": 3,
            "last_name": "Abshire",
            "first_name": "Kristina",
            "avatar": "/tmp/fakerWz0ovJ",
            "created_at": "08-08-2024 "
        },
    ]
}
     

2. Route : __/api/login__ méthode : **POST**
   - Identification avec adresse mail et mot de passe du compte utilisateur qui doit avoir le status *actif* et être de type *administrateur*.
      
     
      Exemple d'appel :    
     {   
       "email: "toto@gmail.com"  string requied
       "password":"password"  string requied
     }  
     
     Exemple de retour :    
     {
       "success": true, string
       "message": "Logged in successfully, use your Bearer token to authenticate on protected endpoints", string
       "data": {
          "token": "1|aGkG1EjRn1TyH9snLpuGyIM3jDWMkz1XTtKu9CF7d9b3272e", string
          "expiration_date": "15-06-2024 21:38:26" string
     }
    }
 _**Le token ainsi retourné sera utilisé comme Bearer Token afin d'accéder au endpoints sécurisés. Il est valable 1 heure.**_
4. Route : __/api/register__ Méthode : **POST**
   - Permet de créer un nouvel utilisateur.  
   - Le compte n'est pas actif et de type utilisateur.  
   - Ce qui ne permet pas d'accéder aux routes sécurisées avant validation, activation et passage au status administrateur.


    Exemple d'appel :  
    {  
      "name": "Wade Wilson",  string requied
      "email": "wade.wilson@yopmail.com", string requied
      "password": "password"  string requied
    }  

    Exemple de retour :  

    {
      "success": true,
      "message": "New user successfully created, need activated by admin for full features access",
      "data": {
      "user": {
      "name": "Wade Wilson",
      "email": "wade.wilson@yopmail.com",
      "password": "password",
      "user_type_id": 2
             }
           }
    }



#### Routes protégées nécessitent d'être authentifié :

1. _Route : **/api/logout**_ méthode:  **POST**
   - Supprime le token ce qui supprimer l'accès aux routes protégées

   
     Exemple de retour : 
    {
     "message": "Unauthenticated." string
    }
2. Route : **/api/profile/name** méthode : **GET**
    - Permet de rechercher un profile par son nom et prénom (insensible à la case).


    Exemple d'appel:  
    {
     "lastname": "feeney", string required
     "firstname": "linda" string required
    }

    Exemple de retour:
     {
    "success": true,
    "message": "Profile for user name = feeney linda",
    "data": {
        "resource": {
            "id": 1,
            "last_name": "Feeney",
            "first_name": "Linda",
            "avatar": "/tmp/fakerDwsvgg",
            "status": "en_attente",
            "created_at": "2024-06-16T10:02:37.000000Z",
            "updated_at": "2024-06-16T10:02:37.000000Z"
        },
        "with": [],
        "additional": []
     }
    }
3. Route : **/api/profile/create** méthode : **POST**
   - Permet de créer un nouveau profile.

    
    Exemple d'appel:  
    {
     "lastname": "Tom", string required
     "firstname": "Cruise", string required
     "status": "inactive" string required
    }

    Exemple de retour:  
    {
     "success": true,
     "message": "Profile created successfully",
     "data": {
     "new_user_data": {
     "last_name": "Tom",
     "first_name": "Cruise"
     "status": "inactif"
      }
     }
    }
- Les différents status attribuables sont :  "active", "inactive", "deleted", "pending"

4. Route : **/api/profile/edit** méthode : **PUT**
    - Permet d'éditer les données d'un profile grâce à son ID.
   

    Exemple d'appel:  
     {
      "id": 21, integer required
      "lastname": "Brad", string required
      "firstname": "Pit", string required
      "status": "actif" string required, active|inactive|deleted|pending
      }

    Exemple de retour:  
    {
     "success": true,
     "message": "Profile updated successfully",
     "data": {
     "new_datas": {
     "id": 22,
     "last_name": "Brad",
     "first_name": "Pit",
     "status": "actif"
      }
     }
    }


5. Route : **/api/profile/delete/{id}** méthode : **DELETE**
   - Permet de supprimer un profile grâce à son ID, action irréversible.

    
    Exemple d'appel:  /api/profile/delete/22

    Exemple de retour: code 204


