
**lien aide formatage de text Markdown**

> > https://support.zendesk.com/hc/fr/articles/4408846544922-Formatage-de-texte-avec-Markdown

## installer Symfony

`composer create-project symfony/skeleton nomDuProjet`


## installer Symfony complet


``composer create-project symfony/website-skeleton nomDuProjet
``

## Servir son application avec WAMPP

>>dans wampp\apache\conf\extra\httpd-vhosts.conf

```
<VirtualHost *:80>
    ServerName symfony.localhost

    DocumentRoot "C:/xampp/apps/symfony/public"
    DirectoryIndex index.php

    <Directory "C:/xampp/apps/symfony/public">
        Require all granted

        FallbackResource /index.php
    </Directory>
</VirtualHost>
```

Virtualhost 80: port écoute tout le http
ServerName: Nom du serveur (nom de domaine ou ip)
DocumentRoot: chemin absolu du dossier du projet ou il y a la page index.php (front controlleur)
DirectoryIndex: nom du fichier principal (front-controlleur)

<Directory>: dit a apache que tous les appels vers notre appli seront redirigés par défaut vers index.php



>>dans C:\Windows\System32\drivers\etc\hosts

```
127.0.0.1  symfony.localhost
```

ouvrir ce fichier avec les droits admin

on rajoute l ip de wamp (machine locale)
on ajoute le nom de domaine vers lequel on veut rediriger

# installer Twig

```
composer req twig
```


# Commandes



liste des commandes


```
php bin/console
```

# installer profiler

```
composer req debug --dev
```
ou je sais pas trop

``
composer req profiler --dev
``


ce bundle ne sera pas intallé en prod



liste des routes


```
php bin/console debug:router
```



```
php bin/console debug:router --env=prod --show-controllers
```


# installer MakerBundle

```
composer require --dev symfony/maker-bundle
```

on l installe en dev pour ne pas l avoir en production

> générer une classe de controleur en ligne de cmd avec maker:


```
php bin/console make:controller
```



pour rediriger utiliser la classe RedirectResponse avec return $this->redirectToRoute ($url) en interne 
$this->redirect(url) en externe (n importe quel site)


# Doctrine


!!!!! le namespace des entités doit être tout en haut du script


# Maker

```
composer req maker --dev
```


# Maker -> entités



pour créer une entité ou mettre à jour:

```
php bin/console make:entity
```


pas besoin de renseigner id

echap _> `CTRL C`


pour associer une entité a une autre:

```
php bin/console make:entity NomEntityExistante
```

il faut ajouter une propriété qui correspond a l'autre table a associer
et ajouter  le nom de la table a lier 
faire `?` pour voir les != associations

Field type: relation


# Maker -> controleur + crud + formulaire + vues


crée un controleur et les routes et méthodes de crud + les formulaires + les vues


```
php bin/console make:crud
```





# Maker -> controleur



pour créer une controleur:

```
php bin/console make:controller
```


# Maker -> Migration



Pour générer les migrations, il faut lancer la commande :

```
php bin/console make:migration
```
Cette commande crée une migration qui portera le nom Version{YYYYMMDDHHMMSS}.php



Pour exécuter les migrations, il faut lancer la commande :

```
php bin/console doctrine:migrations:migrate
```

Par défaut, cette commande jouera toutes les migrations depuis la dernière qui a été exécutée.


``php bin/console doctrine:migrations:status
``

apparement pour générer un fichier de migration
``php bin/console doctrine:migrations:diff
``


# créer utilisateur complet

``php bin/console make:user
``

# créer systeme authentification

``php bin/console make:auth
``

ca crée un formulaire de login, et le security controller (route login/logout)



# créer un systeme pour créer des utilisateurs

``make:registration-form
``

test 123456

Tobal azerty



# Maker -> Form



Pour générer des formulaires, il faut lancer la commande :

```
php bin/console make:form
```


# flashyBundle

``
composer require mercuryseries/flashy-bundle`
``

``$this->flashy->success('Event created!', 'http://your-awesome-link.com');``


import dans le twig base

dans le head

  Load Flashy default CSS 
    <link rel="stylesheet" href="{{ asset('bundles/mercuryseriesflashy/css/flashy.css') }}">


juste avant la fin du body
      Flashy depends on jQuery 
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Load Flashy default JavaScript -->
    <script src="{{ asset('bundles/mercuryseriesflashy/js/flashy.js') }}"></script>
    <!-- Include Flashy default partial -->
    {{ include('@MercurySeriesFlashy/flashy.html.twig') }}
    
    ne pas oublier d injecter la classe en parametre du controleur
    

dump() => affiche une variable pour débuguer

dd() => affiche et stop le script

ne pas utiliser en production


# xdebug

``
composer req debug --dev`
``

# logger en production

``
composer req logger
``
les fichiers de log sont dans var/log

dev.log et prod.log

# lancer un serveur de log


``
php bin/console server:dump --format=html > public/dump.html
``




## creer un voter


``php bin/console make:voter
``



- on configure le voter

- on utilise is-granted dans twig avec en parametre la permission et l'objet pour cacher les boutons

- on 








---------------------------------- methode bundle + univorleans ---------------------


make:user   make:auth    make:registration-form

dans le Security/ LoginFormAthentificate bien rediriger vers l acceuil dans la méthode onAuthentifictionSuccess


dans translation.yaml modifier la langue par défaut


# verifier les prerequis du serveur pour une bonne utilisation de symfony


``symfony check:requirements``



# installer Mailer 


``composer r symfony/mailer``


# installer sendgrid

``composer r sendgrid-mailer``




# formater date en francais twig


``composer require twig/intl-extra``

puis utiliser |format_datetime(locale='fr',pattern="EEEE dd MMMM YYYY") dans twig


# styliser les emails


pour utiliser le css

``composer require twig/extra-bundle twig/cssinliner-extra``


pour le positionnement (le css ne marche pas ilfaut utiliser des tableaux comme avant)

``composer require twig/extra-bundle twig/inky-extra``

pour le responsive, il faut telecharger un fichier et l ajouter au template

decommenter xsl ds php.ini

