<?php
// src/AppBundle/Controller/ProduitController.php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Image;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\VarDumper\VarDumper;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProduitController extends Controller {
    /**
     * @Route("/produit/{need}", defaults={"need" = 1})
     */

    public function getPrixTotal($need)
    {
        $imageBanane = new Image();
        $imageBanane->setUrl('http://www.topsante.com/var/topsante/storage/images/medecine/troubles-cardiovasculaires/avc/prevenir/avc-une-banane-par-jour-peut-reduire-le-risque-31817/207515-3-fre-FR/AVC-une-banane-par-jour-peut-reduire-le-risque.jpg');
        $imageBanane->setAlt('Banane');
        $banane = new Product;
        $banane->setName("Banane");
        $banane->setPrice(5.99);
        $banane->setDescription("Provenance Martinique.");
        $banane->setImage($imageBanane);
        $imagePomme = new Image();
        $imagePomme->setUrl('http://lasantedansmonassiette.com/wp-content/uploads/2012/07/pomme-fruit-prefere.jpg');
        $imagePomme->setAlt('Pomme Rouge');
        $pomme = new Product;
        $pomme->setName("Pomme");
        $pomme->setPrice(6.99);
        $pomme->setDescription("Provenance Brésil.");
        $pomme->setImage($imagePomme);
        return $this->returnProduct($need, $banane, $pomme);
    }

    private function returnProduct($need, $banane, $pomme)
    {
        $em = $this->getDoctrine()->getManager();
        $this->pushInDB($em, $banane);
        $this->pushInDB($em, $pomme);
        $em->flush();
        if ($need === 'banane')
            return new Response('NAME : ' . $banane->getName().
                '<br>PRIX : '.$banane->getPrice().
                '<br>DESCRIPTION : '.$banane->getDescription() .
                '<br><img src=' . $banane->getImage()->getUrl() .
                ' alt=' . $banane->getImage()->getAlt() . ' >');
        if ($need === 'pomme')
            return new Response('NAME : ' . $pomme->getName().
                '<br>PRIX : '.$pomme->getPrice().
                '<br>DESCRIPTION : '.$pomme->getDescription() .
                '<br><img src=' . $pomme->getImage()->getUrl() .
                ' alt=' . $pomme->getImage()->getAlt() . ' >');
        else
            return new Response('Bad URL');
    }

    private function pushInDB($em, $product) {
        $em->persist($product);
    }
}

