<?php

namespace cano\UEKCBundle\Controller;

use Proxies\__CG__\cano\UEKCBundle\Entity\GroupEnt;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Session\Session;
use Goutte\Client;
use cano\UEKCBundle\Entity\Degrees;
use cano\UEKCBundle\Entity\Classroom;
use cano\UEKCBundle\Entity\Classes;


class CrawlerController extends Controller
{
    /**
     * @Route("/crawl/")
     * @Template()
     */
    public function indexAction()
    {
        $client = new Client();
        $em = $this->getDoctrine()->getManager();
//        $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);

        $crawlStatus = $em->getRepository('canoUEKCBundle:CrawlStatus')->findByStatus(0);
        if (!empty($crawlStatus)) {
            $buildingsArray = $crawlStatus[0]->getBuildingName();
        } else {
            return array(
                'result' => 'nothing to update'
            );
        }

        $infoArray = [];
        $firstRequest = 0;

        $crawler = $client->request('GET', 'http://planzajec.uek.krakow.pl/index.php?typ=S&grupa='.$buildingsArray.'&xml');
        $classroomIdArray = $crawler->filter('plan-zajec > zasob')->each(function ($node) {
            return $node->attr('id');
        });

        $numberOfRequests = count($classroomIdArray);

        $c = 0;

        for ($i = $firstRequest; $i < $firstRequest + $numberOfRequests; $i++) {
            $crawler = $client->request('GET', 'http://planzajec.uek.krakow.pl/index.php?typ=S&id=' . $classroomIdArray[$i] . '&okres=2&xml');

            $tableData = $crawler->filter('plan-zajec > zajecia')->each(function ($node) {
                return $node;
            });

            $classroom = $crawler->filter('plan-zajec')->attr('nazwa');

            $length = count($tableData);

            for ($j = 0; $j < $length; $j++) {
                unset($infoArray[$c]);
                $infoArray[$c] = [];
                $infoArray[$c]['classroom'] = $classroom;
                $infoArray[$c]['YYYY'] = substr($tableData[$j]->filter('termin')->text(), 0, 4);
                $infoArray[$c]['MM'] = substr($tableData[$j]->filter('termin')->text(), 5, 2);
                $infoArray[$c]['DD'] = substr($tableData[$j]->filter('termin')->text(), 8, 2);

                $infoArray[$c]['startTimeHH'] = substr($tableData[$j]->filter('od-godz')->text(), 0, 2);
                $infoArray[$c]['startTimeMM'] = substr($tableData[$j]->filter('od-godz')->text(), 3, 2);
                $infoArray[$c]['endTimeHH'] = substr($tableData[$j]->filter('do-godz')->text(), 0, 2);
                $infoArray[$c]['endTimeMM'] = substr($tableData[$j]->filter('do-godz')->text(), 3, 2);

                $infoArray[$c]['subject'] = $tableData[$j]->filter('przedmiot')->text();
                $infoArray[$c]['type'] = $tableData[$j]->filter('typ')->text();
                $infoArray[$c]['teacher'] = $tableData[$j]->filter('nauczyciel')->each(function ($node) {
                    return $node->text();
                });
                if (count($tableData[$j]->filter('uwagi')) > 0) {
                    $infoArray[$c]['notes'] = $tableData[$j]->filter('uwagi')->text();
                } else {
                    $infoArray[$c]['notes'] = '';
                }

                $infoArray[$c]['groups'][0] = '[no groups]';
                if (strpos($tableData[$j]->filter('grupa')->text(), ', ') !== false) {
                    $groups = explode(', ', $tableData[$j]->filter('grupa')->text());
                    for ($k = 0; $k < count($groups); $k++) {
                        $infoArray[$c]['groups'][$k] = $groups[$k];
                    }
                } else {
                    $infoArray[$c]['groups'][0] = $tableData[$j]->filter('grupa')->text();
                }

                if (count($tableData[$j]->filter('uwagi')) > 0) {
                    $infoArray[$c]['notes'] = $tableData[$j]->filter('uwagi')->text();
                }

                $toHash = print_r($infoArray[$c], true);
                $infoArray[$c]['hash'] = hash('md5', $toHash);
                $infoArray[$c]['dateAdded'] = $date = date('m/d/Y H:i:s', time());

                $classEnt = new Classes();
                $classEnt->setDate(new \DateTime($infoArray[$c]['DD'] . '-' . $infoArray[$c]['MM'] . '-' . $infoArray[$c]['YYYY']));
                $classEnt->setStartTime(new \DateTime($infoArray[$c]['startTimeHH'] . ':' . $infoArray[$c]['startTimeMM'] . ':00'));
                $classEnt->setEndTime(new \DateTime($infoArray[$c]['endTimeHH'] . ':' . $infoArray[$c]['endTimeMM'] . ':00'));
                $classEnt->setClassroom($em->getRepository('canoUEKCBundle:Classroom')->propagate($infoArray[$c]['classroom'], $em));
                $classEnt->setTypes($em->getRepository('canoUEKCBundle:ClassType')->propagate($infoArray[$c]['type'], $em));
                $classEnt->setSubject($em->getRepository('canoUEKCBundle:Subject')->propagate($infoArray[$c]['subject'], $em));
                $classEnt->setHash($infoArray[$c]['hash']);
                $classEnt->setNotes($infoArray[$c]['notes']);

                $classEnt->setFlags($em->getRepository('canoUEKCBundle:Flags')->find(1));

                for ($l = 0; $l < count($infoArray[$c]['teacher']); $l++) {
                    $classEnt->addTeacher($em->getRepository('canoUEKCBundle:Teacher')->propagate($infoArray[$c]['teacher'][$l], 120, 'kek.jpg', $em));
                }
                for ($l = 0; $l < count($infoArray[$c]['groups']); $l++) {
                    $classEnt->addGroup($em->getRepository('canoUEKCBundle:GroupEnt')->propagate($infoArray[$c]['groups'][$l], $em));
                }
                $em->persist($classEnt);
                $em->flush();
            }
        }

        $crawlStatus[0]->setStatus(1);
        $em->persist($crawlStatus[0]);
        $em->flush();
        $em->clear();

        return array(
            'result' => 'updated '.$buildingsArray
            );
    }

    /**
     * @Route("/crawl/reset")
     * @Template("canoUEKCBundle:Crawler:index.html.twig")
     */
    public function resetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $crawlStatus = $em->getRepository('canoUEKCBundle:CrawlStatus')->findAll(1);
        for ($i = 0; $i < count($crawlStatus); $i++) {
            $crawlStatus[$i]->setStatus(0);
            $em->persist($crawlStatus[$i]);
            $em->flush();
        }
        $em->clear();
        return array(
            'result' => 'crawl reset'
        );
    }

    /**
     * @Route("/crawl/updateDegrees/")
     * @Template("canoUEKCBundle:Crawler:index.html.twig")
     */
    public function updateDegreesAction()
    {
//        $session = new Session();
//        $session->set('name', 'abc');

        $client = new Client();
//        $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);
        $crawler = $client->request('GET', 'http://planzajec.uek.krakow.pl/index.php?typ=N&xml');

        $nodeHtml = $crawler->filter('plan-zajec > zasob')->each(function ($node) {
            return $node->attr('nazwa');
        });

        $degreeArray = [];
        $alreadyThere = false;

        for ($i = 0; $i < count($nodeHtml); $i++) {
            $deg = substr($nodeHtml[$i], strrpos($nodeHtml[$i], ', ') + 2);
            if ($deg != '') {
                if ($i == 1) {
                    array_push($degreeArray, $deg);
                }

                for ($j = 0; $j < count($degreeArray); $j++) {
                    if ($deg == $degreeArray[$j]) {
                        $alreadyThere = true;
                    }
                }
                if ($alreadyThere == false) {
                    array_push($degreeArray, $deg);
                }
                $alreadyThere = false;
            }
        }

        $em = $this->getDoctrine()->getManager();

        $degrees = $em->getRepository('canoUEKCBundle:Degrees')->findAll();
        for ($i = 0; $i < count($degreeArray); $i++) {
            $deg = $degreeArray[$i];

            for ($j = 0; $j < count($degrees); $j++) {

                if ($deg == $degrees[$j]->getName()) {
                    $alreadyThere = true;
                }
            }
            if ($alreadyThere == false) {
                $degItem = new Degrees();
                $degItem->setName($deg);
                $degItem->setFriendlyName($deg);
                $em->persist($degItem);
            }
            $alreadyThere = false;
        }
        $em->flush();

        return array(
            'result' => $degreeArray
        );
    }
}