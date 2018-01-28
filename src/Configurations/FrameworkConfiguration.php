<?php

    namespace Eskirex\Component\Framework\Configurations;

    use Eskirex\Component\Config\Config;
    use Eskirex\Component\Framework\Exceptions\InvalidArgumentException;

    class FrameworkConfiguration
    {
        const APPLICATION_DIR       = 'application';

        const CONFIG_DIR            = 'config';

        const PUBLIC_DIR            = 'public';

        const RESOURCE_DIR          = 'resource';

        const STORAGE_DIR           = 'storage';

        const TEMP_DIR              = 'temp';

        const TEMPLATE_DIR          = 'template';

        const APPLICATION_NAMESPACE = 'Application';

        const COMMANDS_NAMESPACE    = 'Commands';

        const CONTROLLERS_NAMESPACE = 'Controllers';

        const LIBRARIES_NAMESPACE   = 'Libraries';

        const MODELS_NAMESPACE      = 'Models';

        public static $baseDir;

        public static $applicationDir;

        public static $configDir;

        public static $publicDir;

        public static $resourceDir;

        public static $storageDir;

        public static $tempDir;

        public static $templateDir;

        public static $commandsDir;

        public static $commandsNamespace;

        public static $controllersDir;

        public static $controllersNamespace;

        public static $librariesDir;

        public static $librariesNamespace;

        public static $modelsDir;

        public static $modelsNamespace;


        public function __construct(array $data)
        {
            if (!isset($data['base_dir']) || !is_dir($data['base_dir'])) {
                throw new InvalidArgumentException('Invalid base dir');
            }

            $baseDir = $data['base_dir'];
            $applicationDir = $baseDir . DS . ($data['application_dir'] ?? self::APPLICATION_DIR) . DS;
            $configDir = $baseDir . DS . ($data['config_dir'] ?? self::CONFIG_DIR) . DS;
            $publicDir = $baseDir . DS . ($data['public_dir'] ?? self::PUBLIC_DIR) . DS;
            $resourceDir = $baseDir . DS . ($data['resource_dir'] ?? self::RESOURCE_DIR) . DS;
            $storageDir = $baseDir . DS . ($data['storage_dir'] ?? self::STORAGE_DIR) . DS;
            $tempDir = $baseDir . DS . ($data['temp_dir'] ?? self::TEMP_DIR) . DS;
            $templateDir = $baseDir . DS . ($data['template_dir'] ?? self::TEMPLATE_DIR) . DS;

            $commandsDir = $applicationDir . DS . self::COMMANDS_NAMESPACE . DS;
            $commandsNamespace = self::APPLICATION_NAMESPACE . "\\" . self::COMMANDS_NAMESPACE . "\\";

            $controllersDir = $applicationDir . self::CONTROLLERS_NAMESPACE . DS;
            $controllersNamespace = self::APPLICATION_NAMESPACE . "\\" . self::CONTROLLERS_NAMESPACE . "\\";

            $librariesDir = $applicationDir . self::LIBRARIES_NAMESPACE . DS;
            $librariesNamespace = self::APPLICATION_NAMESPACE . "\\" . self::LIBRARIES_NAMESPACE . "\\";

            $modelsDir = $applicationDir . self::MODELS_NAMESPACE . DS;
            $modelsNamespace = self::APPLICATION_NAMESPACE . "\\" . self::MODELS_NAMESPACE . "\\";

            if (!is_dir($applicationDir)) {
                throw new InvalidArgumentException('Not exist application dir');
            }
            if (!is_dir($configDir)) {
                throw new InvalidArgumentException('Not exist config dir');
            }
            if (!is_dir($publicDir)) {
                throw new InvalidArgumentException('Not exist public dir');
            }
            if (!is_dir($resourceDir)) {
                throw new InvalidArgumentException('Not exist resource dir');
            }
            if (!is_dir($storageDir)) {
                throw new InvalidArgumentException('Not exist storage dir');
            }
            if (!is_dir($tempDir)) {
                throw new InvalidArgumentException('Not exist temp dir');
            }
            if (!is_dir($templateDir)) {
                throw new InvalidArgumentException('Not exist template dir');
            }
            if (!is_dir($commandsDir)) {
                throw new InvalidArgumentException('Not exist commands dir');
            }
            if (!is_dir($controllersDir)) {
                throw new InvalidArgumentException('Not exist controllers dir');
            }
            if (!is_dir($librariesDir)) {
                throw new InvalidArgumentException('Not exist libraries dir');
            }
            if (!is_dir($modelsDir)) {
                throw new InvalidArgumentException('Not exist models dir');
            }

            self::$baseDir = $baseDir;
            self::$applicationDir = $applicationDir;

            Config::configure([
                'dir' => $configDir
            ]);
            self::$configDir = $configDir;

            self::$publicDir = $publicDir;
            self::$resourceDir = $resourceDir;
            self::$storageDir = $storageDir;
            self::$tempDir = $tempDir;
            self::$templateDir = $templateDir;

            self::$commandsDir = $commandsDir;
            self::$commandsNamespace = $commandsNamespace;

            self::$controllersDir = $controllersDir;
            self::$controllersNamespace = $controllersNamespace;

            self::$librariesDir = $librariesDir;
            self::$librariesNamespace = $librariesNamespace;

            self::$modelsDir = $modelsDir;
            self::$modelsNamespace = $modelsNamespace;
        }
    }