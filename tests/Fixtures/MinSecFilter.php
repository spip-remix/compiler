<?php

namespace {
    /**
     * @param int nb_seconde
     * calcule le nombre de minutes et de secondes à partir d'un entier
     * retourne la durée au format 00:00
     *
     * [(#DUREE|min_sec)]
     *
     * @author  <@free.fr>
     */
    function filtre_min_sec_dist($nb_seconde)
    {
        $filter = new Acme\Filter\MinSecFilter;

        return $filter($nb_seconde);
    }
}

namespace Acme\Filter {
    /**
     * Calcule le nombre de [jours [heures:]]minutes:secondes
     * à partir d'un entier positif ou nul exprimé en secondes (durée).
     *
     * Retourne la durée au format:
     *              , (vide) si la durée est erronée (entier négatiif)
     *         00:00, si la durée est inférieure à 1 heure
     *      00:00:00, si la durée est inférieure à 1 jour
     * ou 0 00:00:00, si la durée est supérieure ou égale à 1 jour
     */
    class MinSecFilter
    {
        public function getShortName(): string
        {
            return 'min_sec';
        }

        public function __invoke(int|float $nb_seconde): string
        {
            if ($nb_seconde < 0) {
                // Pas dans mon scope !
                return '';
            }

            $nb_seconde = \round($nb_seconde);
            $zero = new \DateTimeImmutable('0000-00-00');
            $duration = $zero->add($this->dateinterval($nb_seconde));

            return $zero
                ->diff($duration)
                ->format($this->format($nb_seconde));
        }

        /**
         * description
         * 
         * @param non-negative-int $timestamp
         */
        protected function format(int $timestamp): string
        {
            if ($timestamp >= 86400) {
                return '%a %H:%I:%S';
            }

            if ($timestamp >= 3600) {
                return '%H:%I:%S';
            }

            return '%I:%S';
        }

        /**
         * description
         */
        protected function dateinterval(int $duration): \DateInterval
        {
            return new \DateInterval(sprintf(
                'P%dDT%dS',
                $duration / 86400,
                $duration % 86400
            ));
        }
    }
}
