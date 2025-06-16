<?php

namespace App\Util;

class DateHelper
{
    /**
     * Retourne le numéro ISO de la semaine pour une date donnée
     */
    public static function getIsoWeekNumber(\DateTimeInterface $date): int
    {
        return (int)$date->format('W');
    }

    /**
     * Retourne le premier jour de la semaine (lundi) pour une date donnée
     */
    public static function getFirstDayOfWeek(\DateTimeInterface $date): \DateTime
    {
        $dateClone = clone $date;
        $dateClone->modify('monday this week');
        return $dateClone;
    }

    /**
     * Retourne le premier jour du mois pour une date donnée
     */
    public static function getFirstDayOfMonth(\DateTimeInterface $date): \DateTime
    {
        $dateClone = clone $date;
        $dateClone->modify('first day of this month');
        return $dateClone;
    }

    /**
     * Retourne le prochain jour travaillé (hors samedi, dimanche et jours fériés)
     */
    public static function getNextWorkingDay(\DateTimeInterface $date, array $joursFeries = []): \DateTime
    {
        $dateClone = clone $date;

        do {
            $dateClone->modify('+1 day');
            $dayOfWeek = (int)$dateClone->format('N'); // 6 = samedi, 7 = dimanche
            $isWeekend = $dayOfWeek >= 6;

            $isJourFerie = false;
            foreach ($joursFeries as $jf) {
                $jfDate = $jf instanceof \DateTimeInterface ? $jf->format('Y-m-d') : $jf;
                if ($jfDate === $dateClone->format('Y-m-d')) {
                    $isJourFerie = true;
                    break;
                }
            }
        } while ($isWeekend || $isJourFerie);

        return $dateClone;
    }

    /**
     * Retourne la liste des mois entre deux dates, au format 'Y-m' (ex: 2025-06)
     */
    public static function getMonthsBetween(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $months = [];
        $current = new \DateTimeImmutable($start->format('Y-m-01'));
        $end = new \DateTimeImmutable($end->format('Y-m-01'));

        while ($current <= $end) {
            $months[] = $current->format('Y-m');
            $current = $current->modify('+1 month');
        }

        return $months;
    }

    /**
     * Retourne la liste des semaines ISO entre deux dates, avec début et fin de chaque semaine
     */
    public static function getWeeksBetween(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $weeks = [];

        $current = self::getFirstDayOfWeek($start);
        $endMonday = self::getFirstDayOfWeek($end);

        while ($current <= $endMonday) {
            $weekStart = clone $current;
            $weekEnd = (clone $current)->modify('+6 days');

            $weeks[] = [
                'year' => (int)$weekStart->format('o'), // année ISO
                'week' => (int)$weekStart->format('W'), // semaine ISO
                'start' => $weekStart,
                'end' => $weekEnd,
            ];

            $current = $current->modify('+7 days');
        }

        return $weeks;
    }
}
