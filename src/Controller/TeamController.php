<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Interfaces\CrudControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController implements CrudControllerInterface
{
    /**
     * @Route("/team", name="team")
     */
    public function index()
    {
        $teams = $this->getDoctrine()
                        ->getRepository(Team::class)
                        ->findAll();

        return $this->render('formula/path/team/index.html.twig', [
            'teams' => $teams,
        ]);
    }

    /**
     * @Route("/team/create", name="create_team")
     */
    public function create(Request $request)
    {
        $team = new Team();

        $form = $this->createForm(
            TeamType::class,
            $team
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $manager->persist($team);

            try {

                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('team')
                );

            } catch (\Throwable $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to team project (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/team/create.html.twig', [
                'form' => $form->createView(),
                'team' => $team
            ]
        );
    }

    /**
     * @Route("/team/delete/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {
        $team = $this->getTeam($id);

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($team);

            $manager->flush();
        } catch(\Throwable $e) {
            $this->addFlash(
                'error',
                sprintf(
                    'Could delete team with id: %s',
                    $id
                )
            );
        }

        return $this->redirect(
            $this->generateUrl('team')
        );
    }

    /**
     * @param int $id
     * @return object|null
     */
    protected function getTeam(int $id)
    {
        $team = $this
            ->getDoctrine()
            ->getRepository(Team::class)
            ->find($id);

        if (!$team) {
            throw $this->createNotFoundException(
                sprintf("Could find team with id: %s",
                    $id)
            );
        }

        return $team;

    }
}
