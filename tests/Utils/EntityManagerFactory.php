<?php

namespace Lifeman\Cart\Utils;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\DBAL\Driver\PDOSqlite\Driver as SqliteDriver;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\SchemaTool;

final class EntityManagerFactory
{
    public static function getSqliteMemoryEntityManager(array $schemaClassNames): EntityManagerInterface
    {
        $connection = new Connection([
            'memory' => true,
        ], new SqliteDriver());

        return self::createEntityManager($connection, $schemaClassNames);
    }

    public static function createEntityManager(Connection $connection, array $schemaClassNames): EntityManager
    {
        $config = new Configuration();

        $namespaces = [
            __DIR__ . '/../../src/Infrastructure/DoctrineMapping' => 'Lifeman\\Cart\\Domain'
        ];

        $yamlDriver = new SimplifiedYamlDriver($namespaces, '.yml');

        $config->setMetadataDriverImpl($yamlDriver);

        $config->setProxyDir(__DIR__ . '/../Tests/Proxies');
        $config->setProxyNamespace('Doctrine\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_EVAL);

        $entityManager = EntityManager::create($connection, $config);

        (new SchemaTool($entityManager))
            ->createSchema(array_map([$entityManager, 'getClassMetadata'], $schemaClassNames));

        return $entityManager;
    }
}
