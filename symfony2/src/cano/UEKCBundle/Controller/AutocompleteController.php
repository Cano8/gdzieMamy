<?php

namespace cano\UEKCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



class AutocompleteController extends Controller
{
    /**
     * @Route("/xhr/groupsOrTeachers/{query}")
     * @Template("canoUEKCBundle:Autocomplete:index.html.twig")
     */
    public function groupsOrTeachersAction($query)
    {
        if ($query != '') {
            $q = $this->getDoctrine()->getRepository('canoUEKCBundle:Teacher')->createQueryBuilder('teacher')
                ->select('teacher.name', 'teacher.lastname', 'degree.name as degreeName', 'teacher.id')
                ->leftJoin('teacher.degree', 'degree')
                ->where('teacher.name like :queryString')
                ->orWhere('teacher.lastname like :queryString')
                ->setParameter('queryString', '%' . $query . '%')
                ->getQuery()->getResult();

            $q2 = $this->getDoctrine()->getRepository('canoUEKCBundle:GroupEnt')->createQueryBuilder('groupEnt')
                ->select('groupEnt.name', 'groupEnt.id')
                ->where('groupEnt.name like :queryString')
                ->setParameter('queryString', '%' . $query . '%')
                ->getQuery()->getResult();

            $b = [];

            for ($i = 0; $i < count($q); $i++) {
                $b[$i]['tId'] = $q[$i]['id'];
                $b[$i]['name'] = $q[$i]['lastname'] . ' ' . $q[$i]['name'] . ', ' . $q[$i]['degreeName'];
            }

            $count = count($b);

            for ($i = 0; $i < count($q2); $i++) {
                $b[$i+$count]['gId'] = $q2[$i]['id'];
                $b[$i+$count]['name'] = $q2[$i]['name'];
            }
        } else {
            $b = [];
        }

        $response = new JsonResponse();
        $response->setData($b);
        return $response;
    }

}
