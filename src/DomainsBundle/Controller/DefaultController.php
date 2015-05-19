<?php

namespace DomainsBundle\Controller;

use DomainsBundle\Entity\Domains;
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
            ->add('csvFile', 'file', array('label' => 'Select your file'))
            ->add('save', 'submit', array('label' => 'Upload'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $file = $form->get('csvFile');
            $fileName = $file->getData();
            $ignoreFirstRow = true;

            $em = $this->getDoctrine()->getEntityManager();

            if (($handle = fopen($fileName, "r")) !== false) {
                while (($data = fgetcsv($handle, 0, ",")) !== false) {
                    if ($ignoreFirstRow === false) {
                        $domain = new Domains();
                        $domain->setUrl($data[1]);
                        $domain->setLinking($data[2]);
                        $domain->setExternal($data[3]);
                        $domain->setMozrank($data[4]);
                        $domain->setMoztrust($data[5]);
                        $em->persist($domain);
                    }
                    $ignoreFirstRow = false;
                }
                fclose($handle);
            }
            $em->flush();
            return $this->redirect('show');
        }

        $view = 'DomainsBundle:Welcome:index.html.twig';

        $response = $this->render(
            $view,
            array(
                'UploadFileForm' => $form->createView()
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
            ->findAll();

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