<?php

namespace cano\UEKCBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubjectRepository extends EntityRepository
{
    public function propagate($ent, $em) {
        $target = 'Subject';
        $t = $em->getRepository('canoUEKCBundle:'.$target)->findAll();
        $targetClass = 'cano\\UEKCBundle\\Entity\\'.$target;

        $alreadyThere = false;
        $currentId = '';
        for ($j = 0; $j < count($t); $j++) {
            if ($ent == $t[$j]->getName()) {
                $alreadyThere = true;
                $currentId = $t[$j]->getId();
            }
        }
        if ($alreadyThere == false) {
            $entItem = new $targetClass();
            $entItem->setName($ent);
            $em->persist($entItem);
            $em->flush();
            $currentId = $entItem->getId();
        }
        return $em->getRepository('canoUEKCBundle:'.$target)->find($currentId);
    }

}