# docker-compose stack for PHP-Projects


## Install

```
composer init # if you not have a composer.json
composer config repositories.repo-name vcs https://github.com/smtxdev/docker-compose-php-stack.git
composer require smtxdev/docker-compose-php-stack:dev-master
```

Add these lines to define the install-location of this package (highly recommend otherwise this package will be installed into `vendor` and you don't want your docker stack in the `vendor` folder):

```
"extra": {
    "installer-types": ["project"],
    "installer-paths": {
        "./docker/": ["smtxdev/docker-compose-php-stack"]
    }
}
```

Full-Example `composer.json`

```
{
    "require": {
        "smtxdev/docker-compose-php-stack": "dev-master"
    },
    "repositories": {
        "repo-name": {
            "type": "vcs",
            "url": "https://github.com/smtxdev/docker-compose-php-stack.git"
        }
    },
    "extra": {
        "installer-types": ["project"],
        "installer-paths": {
            "./docker/": ["smtxdev/docker-compose-php-stack"]
        }
    }
}
```

## Usage / Start the stack

```
cd docker
cp .env.sample .env
docker-compose up -d
```
