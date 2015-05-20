<?php

namespace DomainsBundle\Controller;

use DomainsBundle\Entity\Domains;
use DomainsBundle\Helpers\Importer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="welcome")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('csvFile', 'file', array('label' => ' '))
            ->add('save', 'submit', array('label' => 'Upload'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $file = $form->get('csvFile');
            $fileName = $file->getData();
            $ignoreFirstRow = true;

            $em = $this->getDoctrine()->getEntityManager();

            $importer = new Importer($em);

            if ($importer->importCsvIntoDatabase($fileName, true)) {
                return $this->redirect('show');
            }

        }

        $view = 'DomainsBundle:Welcome:index.html.twig';

        $response = $this->render(
            $view,
            array(
                'UploadFileForm' => $form->createView(),
            )
        );

        return $response;
    }

    /**
     * @Route("/show", name="welcome_show")
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $domains = $em->getRepository('DomainsBundle:Domains')
            ->findBy(array(), array('url' => 'ASC'));

        $view = 'DomainsBundle:Welcome:show.html.twig';

        return $this->render(
            $view,
            array(
                'Domains' => $domains
            )
        );
    }

    /**
     * @Route("/download", name="welcome_download")
     */
    public function downloadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $domains = $em->getRepository('DomainsBundle:Domains')
            ->findAll();

        $view = 'DomainsBundle:Welcome:export.csv.twig';

        $response = $this->render($view,array('Domains' => $domains));
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="domains.csv"');
        return $response;
    }
}