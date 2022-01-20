<?php

namespace App\Controller;

use App\Entity\Home;
use App\Repository\HomeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(ManagerRegistry $manager, HomeRepository $homeRepository): Response
    {   /**
         * Home isimli Entity sınıfımızı çağırıyoruz.
         */
        $homeEntity = new Home();
         /**
         * setTitle metodu ile title değerini belirliyoruz.
         */
        $homeEntity->setTitle('Home');

        /**
         * Entity Manager'ımızı çağırıyoruz.
         */
        $em = $manager->getManager();

        /**
         * Verilerimizi persist ediyoruz.
         */
        $em->persist($homeEntity);

        /**
         * Verileri database'e kaydediyoruz.
         */
        $em->flush(); 

        /**
         * HomeRepository sınıfımızı Symfony'nin
         * Auto-Wiring'i ile 'index()' içinde çağırıyoruz.
         * Buna dikkat edin!
         * 
         * Repository sınıfı Doctrine ile iletşime geçen basit
         * bir sınıftır. Ek ayarlar yapmamıza olanak sağlar.
         * 
         * $homeRepository->find(1) ile veritabanından
         * id 1 bir olan veriyi çekiyoruz.
         */
        $homeRepository = $homeRepository->find(1);
        return $this->render('home/index.html.twig', [
            /**
             * 'controller_name' değişkenine Title 
             *  değerini atıyoruz. 
             */
            'controller_name' => $homeRepository->getTitle(),
        ]);
    }
}
