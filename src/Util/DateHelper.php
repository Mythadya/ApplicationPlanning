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
     * Retourne le prochain jour travaillé à partir d'une date donnée (exclut samedi, dimanche, et jours fériés)
     * $joursFeries est un tableau de dates (string 'Y-m-d') ou \DateTimeInterface
     */
    public static function getNextWorkingDay(\DateTimeInterface $date, array $joursFeries = []): \DateTime
    {
        $dateClone = clone $date;
        do {
            $dateClone->modify('+1 day');
            $dayOfWeek = (int)$dateClone->format('N'); // 1 = lundi ... 7 = dimanche
            $isWeekend = ($dayOfWeek >= 6);
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
     * Retourne la liste des mois entre deux dates données (inclus), sous forme de chaînes 'Y-m' (ex: 2025-06)
     */
    public static function getMonthsBetween(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $months = [];
        $period = new \DatePeriod(
            self::getFirstDayOfMonth($start),
            new \DateInterval('P1M'),
            (new \DateTimeImmutable($end->format('Y-m-01')))->modify('+1 month')
        );

        foreach ($period as $dt) {
            $months[] = $dt->format('Y-m');
        }

        return $months;
    }

    /**
     * Retourne la liste des semaines ISO entre deux dates données (inclus),
     * sous forme de tableau ['year' => xxxx, 'week' => xx, 'start' => DateTime, 'end' => DateTime]
     */
    public static function getWeeksBetween(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $weeks = [];

        $startMonday = self::getFirstDayOfWeek($start);
        $endMonday = self::getFirstDayOfWeek($end);

        $period = new \DatePeriod(
            $startMonday,
            new \DateInterval('P7D'),
            $endMonday->modify('+7 days')
        );

        foreach ($period as $weekStart) {
            $weekEnd = (clone $weekStart)->modify('+6 days');
            $weeks[] = [
                'year' => (int)$weekStart->format('o'),   // année ISO
                'week' => (int)$weekStart->format('W'),   // numéro semaine ISO
                'start' => $weekStart,
                'end' => $weekEnd,
            ];
        }

        return $weeks;
    }
}
