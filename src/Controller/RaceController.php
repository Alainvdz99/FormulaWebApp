<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\RaceType;
use App\Interfaces\CrudControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController implements CrudControllerInterface
{
    /**
     * @Route("/race", name="race")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $races = $this
            ->getDoctrine()
            ->getRepository(Race::class)
            ->findBy([],
                [
                    'raceDateStart' => 'ASC'
                ]

            );

        return $this->render('formula/path/race/index.html.twig', [
            'races' => $races,
        ]);
    }

    /**
     * @Route("/race/create", name="create_race")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $race = new Race();

        $form = $this->createForm(
            RaceType::class,
            $race
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $race->setIsActive($race->isAvailable());
            $manager->persist($race);

            try {

                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('race')
                );

            } catch (\Throwable $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to create race (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/race/create.html.twig', [
                'form' => $form->createView(),
                'race' => $race
            ]
        );
    }

    /**
     * @Route("/race/delete/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {
        $race = $this->getRace($id);

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($race);

            $manager->flush();
        } catch(\Throwable $e) {
            $this->addFlash(
                'error',
                sprintf(
                    'Could delete race with id: %s',
                    $id
                )
            );
        }

        return $this->redirect(
            $this->generateUrl('race')
        );
    }

    /**
     * @param int $id
     * @return \App\Entity\Race|object|null
     */
    protected function getRace(int $id)
    {
        $race = $this
            ->getDoctrine()
            ->getRepository(Race::class)
            ->find($id);

        if (!$race) {
            throw $this->createNotFoundException(
                sprintf("Could find race with id: %s",
                    $id)
            );
        }

        return $race;
    }

}
