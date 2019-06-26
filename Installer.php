<?php

declare(strict_types=1);

namespace SmtXDev\DockerComposePhpStack;

use Composer\Script\Event;

class Installer
{
    const PACKAGE_NAME = 'smtxdev/docker-compose-php-stack';

    /**
     * Installs (copies) the package-files to the desired location.
     *
     * @param Event $event
     * @return void
     */
    public static function install(Event $event): void
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $extra = $event->getComposer()->getPackage()->getExtra();

        $skipFiles = [
            '.git',
            '.gitignore',
            '.editorconfig',
            'README.md',
            'Installer.php',
            'composer.json',
            'composer.lock',
            '.env.sample',
            'config/mail.conf.sample',
            'config/mysql.cnf.sample',
            'config/nginx.conf.sample',
            'config/php.ini.sample',
            'config/vhost.conf.sample',
        ];

        $rename = [
            'config/mail.conf.sample' => 'mail.conf',
            'config/mysql.cnf.sample' => 'mysql.cnf',
            'config/nginx.conf.sample' => 'nginx.conf',
            'config/php.ini.sample' => 'php.ini',
            'config/vhost.conf.sample' => 'vhost.conf',
            '.env.sample' => '.env',
        ];

        if (isset($extra['docker-install-dir']) && strlen((string)$extra['docker-install-dir'])) {
            static::copy($vendorDir . '/' . static::PACKAGE_NAME, $extra['docker-install-dir'], [
                'skip' => $skipFiles,
                'rename' => $rename,
            ]);
        }
    }


    /**
     * Copies files from $src to $dst
     *
     * @param string $src
     * @param string $dst
     * @param array $options Array with key `skip` and/or `rename`.
     * @return void
     */
    private static function copy($src, $dst, $options = []): void
    {
        $skip = isset($options['skip']) ? $options['skip'] : [];
        $rename = isset($options['rename']) ? $options['rename'] : [];

        $dir = opendir($src);
        if (!is_dir($dst)) {
            mkdir($dst, 0775, true);
        }
        while (($file = readdir($dir))) {
            if (($file != '.' ) && ( $file != '..' )) {
                $fileRelative = str_replace(static::PACKAGE_NAME . '/', '', strstr($src .'/'. $file, static::PACKAGE_NAME));
                if (is_dir($src . '/' . $file)) {
                    if (in_array($fileRelative, $skip)) {
                        continue;
                    }
                    static::copy($src .'/'. $file, $dst .'/'. $file, $options);
                }
                else {
                    if (in_array($fileRelative, array_keys($rename))) {
                        $new = $rename[$fileRelative];
                        if (!file_exists($dst .'/'. $new)) {
                            copy($src .'/'. $file, $dst .'/'. $new);
                            continue;
                        }
                    }

                    if (in_array($fileRelative, $skip)) {
                        continue;
                    }
                    copy($src .'/'. $file, $dst .'/'. $file);
                }
            }
        }
        closedir($dir);
    }
}
