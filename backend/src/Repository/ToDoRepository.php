<?php

namespace App\Repository;

use App\Entity\ToDo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<ToDo>
 *
 * @method ToDo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToDo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToDo[]    findAll()
 * @method ToDo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToDoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, ToDo::class);
        $this->em = $em;
    }

    public function createToDo(Todo $newToDo) {
        //// Indica a la doctrina prepare el ToDo            
        $this->em->persist($newToDo);
        // Ejecuta query
        $this->em->flush();
    }

    public function updateToDo(Todo $todoToUpdate) {
        $this->em->persist($todoToUpdate);
        $this->em->flush();
    }

    public function deleteToDo(Todo $todoToDelete) {
        $this->em->remove($todoToDelete);
        $this->em->flush();
    }
 
//    /**
//     * @return ToDo[] Returns an array of ToDo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ToDo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
