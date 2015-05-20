<?php

namespace DomainsBundle\Tests\Helpers;

use DomainsBundle\Helpers\Importer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImporterTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testImportCsvIntoDatabase()
    {
        $importer = new Importer($this->em);

        $result = $importer->importCsvIntoDatabase(__DIR__ . '/../Resources/public/top500.domains.01.14.csv', true);

        $this->assertTrue($result);
    }
}