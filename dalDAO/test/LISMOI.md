# Installation de la librairie de test phpunit (obligatoire)
Pour exécuter les tests, il faut d'en un premier temps installer la librairie phpunit. 

À exécuter qu'une seule fois (par projet). 

Le tout doit être exécuté en **root** :

1. Vous rendre dans le dossier **lib**

2. `curl -L -o phpunit.phar https://phar.phpunit.de/phpunit-12.5.4.phar`

3. `chmod +x phpunit.phar`

4. `apt-get install php-dom php-mbstring php-xml php-xmlwriter`

5. En tapant `./phpunit.phar --version`, vous devriez voir le message de la version et non un message indiquant qu'il manque des dépendances.

6. Pour fermer la session root : `exit`

---
# Exécution des tests
Pour exécuter les tests, il faut être à la **racine du projet** (dossier dal) tout en étant connecté avec votre utilisateur normal.

Ensuite en ligne de commande:

1. Pour rouler une seule classe de test : `lib/phpunit.phar test/models/...`
2. Pour rouler tous les tests : `lib/phpunit.phar test/`

---
# Pour votre info
Les erreurs soulignées en rouge dans les classes de tests sont du à l'incapacité de l'extension Intelephense à chercher 
dans une archive phar. Les tests fonctionnent sans problème malgré l'apparence d'erreurs. Si ça vous énerve, ouvrez les 
paramètres (ctrl+,), cherchez pour "intelephense references exclude" et ajoutez \*\*/test/\*\* dans les éléments à exclure.

Si vous faites cette manipulation, il faut repartir par la suite VSC.

