<?php

namespace App\Repository;

use App\Entity\Evaluacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EvaluacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluacion::class);
    }

    // Calcula el promedio de notas de una materia (solo evaluaciones con nota cargada)
    // Retorna null si todavía no hay ninguna nota — la UI muestra "Promedio: —" en gris
    public function getAverageByMateria(string $materiaId): ?float
    {
        $result = $this->createQueryBuilder('e')
            ->select('AVG(e.grade)')
            ->where('e.materia = :id AND e.grade IS NOT NULL')
            ->setParameter('id', $materiaId)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : null;
    }
}
