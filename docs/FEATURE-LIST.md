Site E-commerce de vente de moules en silicone personnalisés.

Features générales:
- Gestion des utilisateurs
    - Inscription -> Need username/pwd (+ confirmation + hash)/email
    - Connexion
    - Déconnexion
- Page d'accueil affichant tous les produits (derniers ajouts ? Meilleurs ventes ?) du site et qui redirige vers le détail du produit une fois cliqué
    - Possibilité de filtrer les articles affichés
    - Recherche via mot clé
- Création d'une fiche produit. (admin)
- Consultation d'une fiche produit
- Modification d'une fiche produit. (admin)  
- Suppression d'une fiche produit. (admin)
- faire une commande (panier + paiement + livraison ?)



Features détaillées :
** PAGE D'ACCUEIL **
inspiré de https://www.etsy.com/fr/shop/FreakyKawaiiMolds?ref=simple-shop-header-name&listing_id=984475594

- Menu header
- Bandeau de présentation

- main : affiche la photo principale de tous les produits
- sur le côté: filtre par catégorie + soldes ?
- Barre de recherche sur le nom de l'article ("Select * from products where name LIKE '%...%' ?")

- Favoris
    - Gestion avec Ajax ?  
    - Si l'admin n'en a pas besoin : gestion avec localstorage ?

** Inscription **
username / pwd / email obligatoires.
On vérifie que le username et/ou l'email ne sont pas déjà présents en base.

** Modifier le profil utilisateur **
- Uploader un avatar / image
    - MEDIA
    - nom du fichier
    - extension
    - url

- adresse
- modifier email 
- modifier mdp (ancien mdp > nouveau mdp + confirmation)


** Page d'aminsitration **
- Modifier la page " A propos " du site.
- Créer un nouvel article
    - ajout des principales infos (nom, description, version, prix ...)
    - Ajout des photos + définir une photo principale (gérer le cas où aucune photo n'est uploadée ?)
- Supprimer un article
- Masquer un article ?
- Modifier un article
- Supprimer un user ? (RGPD. Penser à rediriger les user_id vers un "faux" user)


** Page d'accueil **
- Filtrer les produits
- Rechercher un produit (sur le nom et le tag ?)


** Consultation de produit **
- Voir les photos / descriptions et tout
- sélection de la version
- commande (création d'un order ...)


