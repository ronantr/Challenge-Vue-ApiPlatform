# Challenge-Vue-ApiPlatform
[![Deploy](https://github.com/ronantr/Challenge-Vue-ApiPlatform/actions/workflows/deloy.yml/badge.svg?branch=main)](https://github.com/ronantr/Challenge-Vue-ApiPlatform/actions/workflows/deloy.yml)

Challenge VueJS ApiPlatform

Theatly aide pour les groupes de théâtre amateurs, comprenant des comptes utilisateurs, une gestion des événements, un système de billetterie avec QR Code, une gestion des crédits et des transactions, un bonus de fidélité et un modèle de données pour stocker les informations des utilisateurs et des événements.

## Requirements

* [Install Docker](https://docs.docker.com/get-docker/) (with [docker-compose](https://docs.docker.com/compose/install/))

## Getting Started

Make a git clone of this repository and in the created folder, run this command line :

```bash
git https://github.com/ronantr/Challenge-Vue-ApiPlatform.git
cd Challenge-Vue-ApiPlatform
docker-compose build --pull --no-cache
docker-compose up -d
cd client
npm run dev
docker compose exec php sh -c '
    set -e
    apk add openssl
    php bin/console lexik:jwt:generate-keypair
    setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
    setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
    docker compose exec php php bin/console d:d:d --force
    docker compose exec php php bin/console d:d:c
    docker compose exec php php bin/console d:s:u --force
    docker compose exec php php bin/console d:f:l --no-interaction
'
```

```
# URL
https://localhost
```

## Contributors

* **Kurunchi CHANDRA** - [kchandra77](https://github.com/kchandra77)
* **Thushanth PATHMASEELAN** - [pthushanth](https://github.com/pthushanth)
* **Stanley CRICO** - [3kezoh](https://github.com/3kezoh)
* **Ronan Trouillard** - [ronantr](https://github.com/ronantr)
