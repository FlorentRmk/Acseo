<?php

namespace App\Service;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ContactManager
{
    private $em;
    private $tokenStorage;
    private $appKernel;

    public function __construct(EntityManagerInterface $em, KernelInterface $appKernel)
    {
        $this->em = $em;
        $this->appKernel = $appKernel;
    }
    public function new(Contact $contact) {
        $filename = uniqid().'.json';
        $path = $this->appKernel->getProjectDir().'\nas\\'.$filename;
        $file = fopen($path, 'wb');
        $contact->setFilename($filename);

        $this->em->persist($contact);
        $this->em->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($contact, 'json');
        fwrite($file, $json);
    }
}
