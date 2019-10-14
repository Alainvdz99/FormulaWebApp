<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Form\DriverType;
use App\Interfaces\CrudControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DriverController extends AbstractController implements CrudControllerInterface
{
    /**
     * @Route("/driver", name="driver")
     */
    public function index()
    {
        $drivers = $this->getDoctrine()
            ->getRepository(Driver::class)
            ->findAll();

        return $this->render('formula/path/driver/index.html.twig', [
            'drivers' => $drivers,
        ]);
    }

    /**
     * @Route("/admin/driver/create", name="create_driver")
     */
    public function create(Request $request)
    {
        $driver = new Driver();

        $driverForm = $this->createForm(
          DriverType::class,
          $driver
        );

        $driverForm->handleRequest($request);

        if ($driverForm->isSubmitted() && $driverForm->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $manager->persist($driver);

            try {
                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('driver')
                );

            } catch (\Throwable $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to create project (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/driver/create.html.twig', [
                'form' => $driverForm->createView(),
                'driver' => $driver
            ]
        );
    }

    /**
     * @Route("/driver/delete/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {
        $driver = $this->getDriver($id);

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($driver);

            $manager->flush();
        } catch(\Throwable $e) {
            $this->addFlash(
                'error',
                sprintf(
                    'Could delete driver with id: %s',
                    $id
                )
            );
        }

        return $this->redirect(
            $this->generateUrl('driver')
        );
    }

    /**
     * @Route("driver/{id}", name="driver_modal")
     * @param int $id
     * @return Response
     */
    public function modal(int $id)
    {
        $driver = $this
            ->getDoctrine()
            ->getRepository(Driver::class)
            ->find($id);

        return $this->render(
            'formula/components/species/driver/modal.html.twig',
            [
                'driver' => $driver,
            ]
        );
    }

    /**
     * @param int $id
     * @return object|null
     */
    protected function getDriver(int $id)
    {
        $driver = $this
            ->getDoctrine()
            ->getRepository(Driver::class)
            ->find($id);

        if (!$driver) {
            throw $this->createNotFoundException(
                sprintf("Could find driver with id: %s",
                $id)
            );
        }

        return $driver;
    }
}
