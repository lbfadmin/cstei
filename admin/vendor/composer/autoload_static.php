<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2ed8dc49189a0d5910b5d48d6e5acd4d
{
    public static $files = array (
        '2fb9d6f23c8e8faefc193a4cde0cab4f' => __DIR__ . '/..' . '/joomla/string/src/phputf8/utf8.php',
        'e6851e0ae7328fe5412fcec73928f3d9' => __DIR__ . '/..' . '/joomla/string/src/phputf8/ord.php',
        'd9ad1b7c85c100a18c404a13824b846e' => __DIR__ . '/..' . '/joomla/string/src/phputf8/str_ireplace.php',
        '62bad9b6730d2f83493d2337bf61519d' => __DIR__ . '/..' . '/joomla/string/src/phputf8/str_pad.php',
        'c4d521b8d54308532dce032713d4eec0' => __DIR__ . '/..' . '/joomla/string/src/phputf8/str_split.php',
        'fa973e71cace925de2afdc692b861b1d' => __DIR__ . '/..' . '/joomla/string/src/phputf8/strcasecmp.php',
        '0c98c2f1295d9f4d093cc77d5834bb04' => __DIR__ . '/..' . '/joomla/string/src/phputf8/strcspn.php',
        'a52639d843b4094945115c178a91ca86' => __DIR__ . '/..' . '/joomla/string/src/phputf8/stristr.php',
        '73ee7d0297e683c4c2e7798ef040fb2f' => __DIR__ . '/..' . '/joomla/string/src/phputf8/strrev.php',
        'd55633c05ddb996e0005f35debaa7b5b' => __DIR__ . '/..' . '/joomla/string/src/phputf8/strspn.php',
        '944e69d23b93558fc0714353cf0c8beb' => __DIR__ . '/..' . '/joomla/string/src/phputf8/trim.php',
        '31264bab20f14a8fc7a9d4265d91ee98' => __DIR__ . '/..' . '/joomla/string/src/phputf8/ucfirst.php',
        '05d739a990f75f0c44ebe1f032b33148' => __DIR__ . '/..' . '/joomla/string/src/phputf8/ucwords.php',
        '4292e2fa66516089e6006723267587b4' => __DIR__ . '/..' . '/joomla/string/src/phputf8/utils/ascii.php',
        '87465e33b7551b401bf051928f220e9a' => __DIR__ . '/..' . '/joomla/string/src/phputf8/utils/validation.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\DependencyInjection\\' => 38,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
        'J' => 
        array (
            'Joomla\\String\\Tests\\' => 20,
            'Joomla\\String\\' => 14,
            'Joomla\\Input\\Tests\\' => 19,
            'Joomla\\Input\\' => 13,
            'Joomla\\Filter\\' => 14,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\DependencyInjection\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dependency-injection',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Joomla\\String\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/string/Tests',
        ),
        'Joomla\\String\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/string/src',
        ),
        'Joomla\\Input\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/input/Tests',
        ),
        'Joomla\\Input\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/input/src',
        ),
        'Joomla\\Filter\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/filter/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2ed8dc49189a0d5910b5d48d6e5acd4d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2ed8dc49189a0d5910b5d48d6e5acd4d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
