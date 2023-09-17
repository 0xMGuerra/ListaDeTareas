<?php

namespace App\Controller;

use App\Repository\ToDoRepository;
use App\Entity\ToDo;

use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class ToDoController extends AbstractController
{   
    private $toDoRepository;

    public function __construct(ToDoRepository $ToDoRepository) {
        $this->toDoRepository = $ToDoRepository;
    }
    /**
     * @Route("/api/addToDo", name="_annotations_addToDo", methods={"POST"})
     */
    public function addToDo(Request $request): JsonResponse
    {
        $newTodo = new ToDo();

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $data = $serializer->deserialize($request->getContent(), ToDo::Class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $newTodo]);
        
        $newTodo->setFechaCreacion(new \DateTime('today'));

        if(empty($newTodo->getNombre()) || empty($newTodo->getEstado())) {
            throw new NotFoundHttpException('Campos obligatorios sin especificar.');
        }
        
        $this->toDoRepository->createTodo($newTodo);

        return new JsonResponse(['status' => 'ToDo creado.'], Response::HTTP_CREATED);

    }

    /**
     * @Route("/api/ToDoList", name="_annotations_ToDoList", methods={"GET"})
     */
    public function getToDos(): Response {
        $todos = $this->getDoctrine()->getRepository(ToDo::class)->findAll();

        $datos = [];

        foreach ($todos as $ToDo) {
            $datos[] = [
                'id' => $ToDo->getId(),
                'Nombre' => $ToDo->getNombre(),
                'Estado' => $ToDo->getEstado(),
                'FechaCreacion' => $ToDo->getFechaCreacion(),
            ];
        }
        return $this->json($datos);        
    }

    /**
     * @Route("/api/updateToDo", name="_annotations_updateToDo", methods={"PUT"})
     */
    public function updateToDo(Request $request): Response {
        $data = json_decode($request->getContent(), true);
        $todo = $this->getDoctrine()->getRepository(ToDo::class)->findOneBy(['id' => $data['id']]);
        
        $todo->setNombre($data['Nombre']);
        $todo->setEstado($data['Estado']);

        $this->toDoRepository->updateToDo($todo);

        return new JsonResponse(['status' => 'ToDo editado.'], Response::HTTP_OK);
    }

    /**
     * @Route("/api/deleteToDo", name="_annotations_deleteToDo", methods={"DELETE"})
     */
    public function deleteToDo(Request $request): Response {
        $data = json_decode($request->getContent(), true);
        $todo = $this->getDoctrine()->getRepository(ToDo::class)->findOneBy(['id' => $data['id']]);

        $this->toDoRepository->deleteToDo($todo);

        return new JsonResponse(['status' => 'ToDo borrado.'], Response::HTTP_NO_CONTENT);
    }

}
