<?php

namespace Controllers;


use System\DB;

class ServiceController
{
    public function getTarifs($userId, $serviceId)
    {
        // Используем Eager Loading
        $pdo = DB::connection();

        $sth = $pdo->prepare('
            SELECT
                current_tarif.id as current_id,
                current_tarif.title as current_title,
                current_tarif.link as current_link,
                current_tarif.speed as current_speed,

                other_tarifs.ID,
                other_tarifs.title,
                other_tarifs.price,
                other_tarifs.pay_period,
                DATE_ADD(CURDATE(), INTERVAL other_tarifs.pay_period DAY) as new_payday,
                other_tarifs.speed
            FROM services
            JOIN tarifs as current_tarif ON services.tarif_id = current_tarif.id
            JOIN tarifs AS other_tarifs ON other_tarifs.tarif_group_id = current_tarif.tarif_group_id
            WHERE services.user_id = :userId AND services.id = :serviceId
        ');
        $sth->execute(compact('userId', 'serviceId'));
        $rows = $sth->fetchAll(\PDO::FETCH_ASSOC);

        $currentTariffs = [];
        foreach ($rows as $row) {
            $id = $row['current_id'];

            if (! isset($currentTariffs[$id])) {
                $currentTariffs[$id] = [
                    'title' => $row['current_title'],
                    'link'  => $row['current_link'],
                    'speed' => $row['current_speed'],
                    'tarifs' => [],
                ];
            }

            unset($row['current_id'], $row['current_title'], $row['current_link'], $row['current_speed']);

            $currentTariffs[$id]['tarifs'][] = $row;
        }


        return $this->jsonResponse( [
            'result' => 'ok',
            'tarifs' => array_values($currentTariffs),
        ]);
    }

    public function store($userId, $serviceId)
    {
        $pdo = DB::connection();

        $putFields = json_decode(file_get_contents('php://input'));
        $tarifId = $putFields->tarif_id;

        $checkSth = $pdo->prepare('SELECT COUNT(*) FROM services WHERE user_id = :userId AND tarif_id = :tarifId');
        $checkSth->execute(compact('userId', 'tarifId'));
        $isExists = $checkSth->fetchColumn(0);
        if ($isExists) {
            return $this->jsonResponse(['result' => 'error', 'reason' => 'Yet exists!']);
        }

        $sth = $pdo->prepare('INSERT INTO services SET user_id = :userId, tarif_id = :tarifId, payday = CURDATE()');
        $sth->execute(compact('userId', 'tarifId'));

        return $this->jsonResponse(['result' => 'ok']);
    }

    private function jsonResponse($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}