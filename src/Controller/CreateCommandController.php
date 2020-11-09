<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateCommandController extends AbstractController
{
    /**
     * @Route("/command", name="joke", methods={"POST"})
     */
    public function index(Request $request,ProductRepository $productRepo,UserRepository $userRepo,EntityManagerInterface $manager)
    {
        $data = json_decode(
            $request->getContent(),
            false
        );
        $price=0;
        $command = new Command;
        $command->setAdress($data->adress);
        $command->setZipcode($data->zipcode);
        $command->setTown($data->town);
        foreach ($data->products as $value) {
            $product = $productRepo->findOneBy(array("id"=>$value));
            $price+=$product->getQuantity() * $product->getPrice();
            $command->addProduct($product);
        }
        $command->setStatus("payé");
        $command->setDate(new DateTime());
        $command->setUser($userRepo->findOneBy(array("id"=>$data->user)));
        $command->setPrice($price);
        $manager->persist($command);
        $manager->flush();
        return $this->json([
            'command' => $command,
        ]);
        return 
            $command;
    }
}
