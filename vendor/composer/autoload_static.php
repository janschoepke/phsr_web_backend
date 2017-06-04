<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite9fcd2453b0b05dfa228efedf683fad2
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Yaml\\' => 23,
            'Symfony\\Component\\Validator\\' => 28,
            'Symfony\\Component\\Translation\\' => 30,
            'Symfony\\Component\\Finder\\' => 25,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Component\\Console\\' => 26,
            'Symfony\\Component\\Config\\' => 25,
            'Slim\\Views\\' => 11,
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Symfony\\Component\\Validator\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/validator',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Symfony\\Component\\Finder\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/finder',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Symfony\\Component\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/config',
        ),
        'Slim\\Views\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/php-view/src',
        ),
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Propel' => 
            array (
                0 => __DIR__ . '/..' . '/propel/propel/src',
            ),
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'DB\\Base\\Group' => __DIR__ . '/../..' . '/src/models/DB/Base/Group.php',
        'DB\\Base\\GroupMailings' => __DIR__ . '/../..' . '/src/models/DB/Base/GroupMailings.php',
        'DB\\Base\\GroupMailingsQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/GroupMailingsQuery.php',
        'DB\\Base\\GroupQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/GroupQuery.php',
        'DB\\Base\\GroupVictims' => __DIR__ . '/../..' . '/src/models/DB/Base/GroupVictims.php',
        'DB\\Base\\GroupVictimsQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/GroupVictimsQuery.php',
        'DB\\Base\\Mailing' => __DIR__ . '/../..' . '/src/models/DB/Base/Mailing.php',
        'DB\\Base\\MailingQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/MailingQuery.php',
        'DB\\Base\\User' => __DIR__ . '/../..' . '/src/models/DB/Base/User.php',
        'DB\\Base\\UserGroups' => __DIR__ . '/../..' . '/src/models/DB/Base/UserGroups.php',
        'DB\\Base\\UserGroupsQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/UserGroupsQuery.php',
        'DB\\Base\\UserMailings' => __DIR__ . '/../..' . '/src/models/DB/Base/UserMailings.php',
        'DB\\Base\\UserMailingsQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/UserMailingsQuery.php',
        'DB\\Base\\UserQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/UserQuery.php',
        'DB\\Base\\UserVictims' => __DIR__ . '/../..' . '/src/models/DB/Base/UserVictims.php',
        'DB\\Base\\UserVictimsQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/UserVictimsQuery.php',
        'DB\\Base\\Victim' => __DIR__ . '/../..' . '/src/models/DB/Base/Victim.php',
        'DB\\Base\\VictimMailings' => __DIR__ . '/../..' . '/src/models/DB/Base/VictimMailings.php',
        'DB\\Base\\VictimMailingsQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/VictimMailingsQuery.php',
        'DB\\Base\\VictimQuery' => __DIR__ . '/../..' . '/src/models/DB/Base/VictimQuery.php',
        'DB\\Group' => __DIR__ . '/../..' . '/src/models/DB/Group.php',
        'DB\\GroupMailings' => __DIR__ . '/../..' . '/src/models/DB/GroupMailings.php',
        'DB\\GroupMailingsQuery' => __DIR__ . '/../..' . '/src/models/DB/GroupMailingsQuery.php',
        'DB\\GroupQuery' => __DIR__ . '/../..' . '/src/models/DB/GroupQuery.php',
        'DB\\GroupVictims' => __DIR__ . '/../..' . '/src/models/DB/GroupVictims.php',
        'DB\\GroupVictimsQuery' => __DIR__ . '/../..' . '/src/models/DB/GroupVictimsQuery.php',
        'DB\\Mailing' => __DIR__ . '/../..' . '/src/models/DB/Mailing.php',
        'DB\\MailingQuery' => __DIR__ . '/../..' . '/src/models/DB/MailingQuery.php',
        'DB\\Map\\GroupMailingsTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/GroupMailingsTableMap.php',
        'DB\\Map\\GroupTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/GroupTableMap.php',
        'DB\\Map\\GroupVictimsTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/GroupVictimsTableMap.php',
        'DB\\Map\\MailingTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/MailingTableMap.php',
        'DB\\Map\\UserGroupsTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/UserGroupsTableMap.php',
        'DB\\Map\\UserMailingsTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/UserMailingsTableMap.php',
        'DB\\Map\\UserTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/UserTableMap.php',
        'DB\\Map\\UserVictimsTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/UserVictimsTableMap.php',
        'DB\\Map\\VictimMailingsTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/VictimMailingsTableMap.php',
        'DB\\Map\\VictimTableMap' => __DIR__ . '/../..' . '/src/models/DB/Map/VictimTableMap.php',
        'DB\\User' => __DIR__ . '/../..' . '/src/models/DB/User.php',
        'DB\\UserGroups' => __DIR__ . '/../..' . '/src/models/DB/UserGroups.php',
        'DB\\UserGroupsQuery' => __DIR__ . '/../..' . '/src/models/DB/UserGroupsQuery.php',
        'DB\\UserMailings' => __DIR__ . '/../..' . '/src/models/DB/UserMailings.php',
        'DB\\UserMailingsQuery' => __DIR__ . '/../..' . '/src/models/DB/UserMailingsQuery.php',
        'DB\\UserQuery' => __DIR__ . '/../..' . '/src/models/DB/UserQuery.php',
        'DB\\UserVictims' => __DIR__ . '/../..' . '/src/models/DB/UserVictims.php',
        'DB\\UserVictimsQuery' => __DIR__ . '/../..' . '/src/models/DB/UserVictimsQuery.php',
        'DB\\Victim' => __DIR__ . '/../..' . '/src/models/DB/Victim.php',
        'DB\\VictimMailings' => __DIR__ . '/../..' . '/src/models/DB/VictimMailings.php',
        'DB\\VictimMailingsQuery' => __DIR__ . '/../..' . '/src/models/DB/VictimMailingsQuery.php',
        'DB\\VictimQuery' => __DIR__ . '/../..' . '/src/models/DB/VictimQuery.php',
        'src\\services\\ResponseService' => __DIR__ . '/../..' . '/src/services/ResponseService.php',
        'src\\services\\TokenService' => __DIR__ . '/../..' . '/src/services/TokenService.php',
        'src\\services\\UserService' => __DIR__ . '/../..' . '/src/services/UserService.php',
        'src\\services\\VictimService' => __DIR__ . '/../..' . '/src/services/VictimService.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite9fcd2453b0b05dfa228efedf683fad2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite9fcd2453b0b05dfa228efedf683fad2::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite9fcd2453b0b05dfa228efedf683fad2::$prefixesPsr0;
            $loader->classMap = ComposerStaticInite9fcd2453b0b05dfa228efedf683fad2::$classMap;

        }, null, ClassLoader::class);
    }
}
