<?php

namespace App\Controller;

use App\Repository\AnimalsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animals;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/animals')]
class AnimalsController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'api_animal_index', methods: ['GET'])]
    #[Groups(["animal:read"])]

    public function index(AnimalsRepository $animalsRepository): Response
    {
$animals = $animalsRepository->findAll();
$data = $this->serializer->serialize($animals,'json');
return new Response($data,Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/animals/{id}", name="animal_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $animal = $this->getDoctrine()->getRepository(Animals::class)->find($id);

        if (!$animal) {
            // Handle case if animal is not found
            return new JsonResponse(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        // Format the response as needed (e.g., JSON)
        $data = [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            // Include other attributes as needed
        ];

        // Return the formatted response
        return new JsonResponse($data);
    }

    /**
     * @Route("/animals", name="animal_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true); // Get the data from the request body
        
        // Create a new animal entity with the received data
        $animal = new Animals();
        $animal->setName($data['name']);
        // Set other attributes as needed
        
        // Persist the new animal entity to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($animal);
        $entityManager->flush();
        
        // Format the response as needed (e.g., JSON)
        $response = [
            'message' => 'Animal created successfully',
            'id' => $animal->getId(),
            // Include other attributes as needed
        ];
        
        // Return the formatted response
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    /**
     * @Route("/animals/{id}", name="animal_update", methods={"PUT"})
     */
    public function update($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $animal = $entityManager->getRepository(Animals::class)->find($id);

        // Handle case if animal is not found
        // ...

        // Update the animal entity with the data from the request
        // ...

        // Persist the updated animal entity to the database
        // ...

        // Format the response as needed (e.g., JSON)
        // ...

        return $response;
    }

    /**
     * @Route("/animals/{id}", name="animal_delete", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $animal = $entityManager->getRepository(Animals::class)->find($id);

        // Handle case if animal is not found
        // ...

        // Remove the animal entity from the database
        // ...

        // Format the response as needed (e.g., JSON)
        // ...

        return $response;
    }
}
