<?php

namespace cano\UEKCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\JsonResponse;


class TimetableController extends Controller
{
    /**
     * @Route("/timetable/group/{id}")
     * @Template()
     */
    public function indexAction($id){
        return array(
            'result' => ''
        );
    }

    /**
     * @Route("/timetable/teacher/{id}")
     * @Template("canoUEKCBundle:Timetable:index.html.twig")
     */
    public function teacherAction($id){
        return array(
            'result' => ''
        );
    }

    /**
     * @Route("/xhr/getTimetable/{id}")
     * @Template("canoUEKCBundle:Autocomplete:index.html.twig")
     */
    public function getTimetable($id)
    {
//        $q1 = $this->getDoctrine()->getRepository('canoUEKCBundle:GroupEnt')->createQueryBuilder('groupEnt')
//            ->select('groupEnt.name')
//            ->where('groupEnt.id = :id')
//            ->setParameter('id', $id)
//            ->getQuery()->getResult();

        $q = $this->getDoctrine()->getRepository('canoUEKCBundle:GroupEnt')->createQueryBuilder('groupEnt')
            ->select ('groupEnt, classes')
            ->leftJoin('groupEnt.classes','classes')
            ->where('groupEnt.id = :subCompanyId')
            ->setParameter("subCompanyId", $id)
            ->getQuery()->getResult();

        $classes = $q[0]->getClasses();
        $data = [];

        $em = $this->getDoctrine()->getManager();



//        ld($classes[0]->getId());
//        die();

//        $crawlStatus = $em->getRepository('canoUEKCBundle:Classroom')->find($classes[0]->getClassroomId());

        for ($i = 0; $i < count($classes); $i++) {
            $q = $this->getDoctrine()->getRepository('canoUEKCBundle:Teacher')->createQueryBuilder('teacher')
                ->select('teacher.name', 'teacher.lastname')
                ->leftJoin('teacher.classes', 'classes')
                ->where('classes.id = :query')
                ->setParameter('query', $classes[$i]->getId())
                ->getQuery()->getResult();
//            ld($q[0]['name']);
//            ;die();

            $data[$i]['YYYY'] = $classes[$i]->getDate()->format("Y");
            $data[$i]['MM'] = $classes[$i]->getDate()->format("m");
            $data[$i]['DD'] = $classes[$i]->getDate()->format("d");

            $data[$i]['startTime'] = $classes[$i]->getStartTime()->format("H:i");
            $data[$i]['endTime'] = $classes[$i]->getEndTime()->format("H:i");

            $data[$i]['classroom'] = $em->getRepository('canoUEKCBundle:Classroom')->find($classes[0]->getClassroomId())->getName();
            $data[$i]['type'] = $em->getRepository('canoUEKCBundle:ClassType')->find($classes[0]->getTypes())->getName();
            $data[$i]['teacher'] = $q[0]['name'] . ' ' . $q[0]['lastname'];
        }

        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }
}
