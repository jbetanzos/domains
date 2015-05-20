<?php
namespace DomainsBundle\Helpers;

use DomainsBundle\Entity\Domains;

class Importer
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importCsvIntoDatabase($fileName, $ignoreFirstRow = false)
    {
        $handle = fopen($fileName, "r");
        if ($handle === false) {
            return false;
        }

        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            if ($ignoreFirstRow === false) {
                $domain = new Domains();
                $domain->setUrl($data[1]);
                $domain->setLinking($data[2]);
                $domain->setExternal($data[3]);
                $domain->setMozrank($data[4]);
                $domain->setMoztrust($data[5]);
                $this->entityManager->persist($domain);
            }
            $ignoreFirstRow = false;
        }

        $this->entityManager->flush();

        fclose($handle);

        return true;
    }
}