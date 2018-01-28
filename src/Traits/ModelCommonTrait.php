<?php

namespace Eskirex\Component\Framework\Traits;

use Eskirex\Component\Config\Config;

trait ModelCommonTrait
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected static $database;

    protected static $timestamps = false;

    protected static $table;

    protected static $createdAt  = 'creation_date';

    protected static $updatedAt  = 'last_update';


    /**
     * @return array
     */
    private function getConnectionConfigurator()
    {
        $name = (new Config('Database'))->get('default');

        $data = (new Config('Database'))->get($name);

        return [
            'dbname'   => $data['database'],
            'user'     => $data['username'],
            'password' => $data['password'],
            'host'     => $data['server'],
            'driver'   => $data['type'],
            'charset'  => $data['charset'],
        ];
    }


    /**
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getConnection()
    {
        if (static::$database === null) {

            $connection = self::getConnectionConfigurator();
            $config = new \Doctrine\DBAL\Configuration();

            static::$database = \Doctrine\DBAL\DriverManager::getConnection($connection, $config);
        }

        return static::$database;
    }


    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     * @throws \Doctrine\DBAL\DBALException
     */
    private function buildQuery()
    {
        return self::getConnection()->createQueryBuilder()->from(static::$table);
    }
}