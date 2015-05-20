<?php
namespace DomainsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals('DomainsBundle\Controller\DefaultController::indexAction', $client->getRequest()->attributes->get('_controller'));

        $form = $crawler->selectButton('form_save')->form(
            array(
                'form[csvFile]' => __DIR__ . '/../Resources/public/top500.domains.01.14.csv',
            )
        );

        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testUploadFile()
    {
        $client = static::createClient();

        $csvFile = new UploadedFile(
                __DIR__ . '/../Resources/public/top500.domains.01.14.csv',
                'top500.domains.01.14.csv',
                'text/csv'
            );

        $crawler = $client->request(
            'POST',
            '/',
            array(),
            array('csvFile' => $csvFile)
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains('content-type', 'text/html; charset=UTF-8')
        );

        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
    }

    public function testDownloadFile()
    {
        $client = static::createClient();

        $crawler = $client->request(
            'GET',
            '/download',
            array(),
            array()
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains('content-type', 'text/csv; charset=UTF-8')
        );

        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request(
            'GET',
            '/show',
            array(),
            array()
        );

        $this->assertGreaterThan(0, $crawler->filter('table.table')->filter('tr')->count());
    }
}