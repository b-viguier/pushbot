# Pushbot
Hipchat bot for deployments

## Qu'est ce que c'est ?
Pushbot est un (très) petit bot Hipchat pour superviser les déploiements.

## Comment est ce qu'on l'utilise depuis Hipchat ?
La commande `/pushbot` vous lister la liste des commandes qu'il supporte.

### Mise En Production
`/pushbot MEP service-6play-middleware`

### Terminer une MEP
`/pushbot done service-6play-middleware`

### Annuler une MEP
`/pushbot cancel service-6play-middleware`

### Demander l'état des MEP
`/pushbot status`

## Est ce que pusbot s'occupe du déploiement pour moi ?
Absolument **pas**, il est juste là pour enregistrer qui fait quoi,
et veiller à ce que deux personnes n'essayent pas de faire la même chose en même temps!

## Comment l'installer ?
`composer install`
La configuration par défaut enregistre n'enregistrera pas l'état des MEP d'une commande à l'autre, ce qui a peu d'intérêt.
Pour cela, il faut créer un fichier de configuration avec le mode de persistence que vous souhaitez (fichier, redis…).
Dans `app/config/config.php`
```php
<?php

use M6\Pushbot;

return [
    'persister' => new Pushbot\Deployment\Pool\Persister\Redis('tcp://localhost:6379', 'pushbot'),
];
```

Il existe deux points d'entrées
* CLI: `bin/pushbot user <command>`.
* Web: `web/index.php` avec une requête identique au [webhook de Hipchat](https://www.hipchat.com/docs/apiv2/webhooks#room_message).

## Comment contribuer ?
Ne pas hésiter à faire un ticket pour proposer une idée, signaler un problème, ou directement une PR.

## Mais diantre, pourquoi ça n'utilise pas de Framework ?
Parce que c'était plus intéressant de faire sans :smile:. Mais ça peut changer…

## TODO

* [ ] Un dictionnaire de *synonyme* pour les noms de projets.
* [ ] Une commande `kick` pour annuler enlever quelqu'un d'autre d'une file d'attente.
* [ ] Améliorer la persistence des données pour éviter les *race conditions* et permettre un usage *multi room*
* [ ] Créer une configuration dans le `deployer` avec un vrai nom de domaine fourni par BCS.
* [ ] Plus de tests…
* [ ] Améliorer le *graphisme* des réponses
* [ ] …
