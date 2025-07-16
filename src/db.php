<?php

function getUsers($pdo, $limitDay, $minAmount, $searchName = '')
{
    $query = "
        SELECT 
            u.id AS user_id,
            u.name,
            u.email,
            COUNT(o.id) AS orders_count,
            COALESCE(SUM(o.amount), 0) AS total_amount
        FROM users u
        WHERE u.name LIKE $searchName.'%' 
        LEFT JOIN orders o ON u.id = o.user_id
    ";

    $params = [];

    //filter by day
    if ($limitDay > 0)  {
        $query .= " AND o.created_at >= :limit_day";
        $params[':limit_day'] = date('Y-m-d H:i:s', strtotime("-$limitDay days"));
    }

    $query .= " GROUP BY u.id, u.name, u.email";

    //filter by min amount
    if ($minAmount > 0) {
        $query .= " HAVING total_amount >= :min_amount";
        $params[':min_amount'] = $minAmount;
    }

    $query .= "
     ORDER BY total_amount DESC;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}