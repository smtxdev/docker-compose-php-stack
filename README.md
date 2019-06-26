# docker-compose stack for PHP-Projects


## Install

```
composer init # if you not have a composer.json
# Add `scripts` and `extra` infos as mentioned below then execute:
composer require smtxdev/docker-compose-php-stack:dev-master
```

Add these lines to your root composer.json to define the install-location of this package (otherwise this package will not work correctly). Composer will install everything to the `vendor` folder. The following post-install-script (post-autoload-dump) will copy all files to your desired location. You can install and update this package normaly like every other package but do not use this package from the `vendor` folder. Only from the directory you configured in `docker-install-dir`.

```
"scripts": {
    "post-autoload-dump": [
        "SmtXDev\\DockerComposePhpStack\\Installer::install"
    ]
},
"extra": {
    "docker-install-dir": "./docker"
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
    "scripts": {
        "post-autoload-dump": [
            "SmtXDev\\DockerComposePhpStack\\Installer::install"
        ]
    },
    "extra": {
        "docker-install-dir": "./docker"
    }
}
```

## Usage / Start the stack

```
cd docker
docker-compose up -d
```
