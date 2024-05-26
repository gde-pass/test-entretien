<?php

namespace App\Normalizer\DemandeClinique;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\DemandeClinique\Reponse;

class ReponseNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        $dateValidation = $object->getDateValidation();
        $formattedDateValidation = $dateValidation ? $dateValidation->format('Y-m-d H:i:s') : null;

        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
            'date_validation' => $formattedDateValidation,
            'message_validation' => $object->getMessageValidation(),
            'titre' => $object->getTitre(),
            'description' => $object->getDescription(),
            'depot' => $object->getDepot()->getId(),
            'type' => $object->getType(),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Reponse;
    }
}