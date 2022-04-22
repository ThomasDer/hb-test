SELECT
    c.id,
    c.first_name,
    s.name,
    min(v.created_at) as `First visit`,
    max(v.created_at) as `Last visit`,
    count(v.customer_id) as `Number of visits`
FROM
    visits v
    LEFT JOIN customers c ON v.customer_id = c.id
    LEFT JOIN stores s ON s.id = c.store_id
WHERE
    v.store_id = c.store_id
GROUP BY
    v.customer_id
ORDER BY
    c.id
