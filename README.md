# 資料庫

## 題目 1

```SQL
SELECT
    o.bnb_id,
    b.name AS bnb_name,
    SUM(o.amount) AS may_amount
FROM bnbs AS b
JOIN
    (
        SELECT *
        FROM orders
        WHERE YEAR(created_at) = 2023
        AND MONTH(created_at) = 5
        AND currency = 'TWD'
    ) AS o
ON b.id = o.bnb_id
GROUP BY b.id
ORDER BY may_amount DESC
LIMIT 10;
```

## 題目 2

在這三張表中  
orders 表的資料量應該會最為龐大  
所以首先可以考慮將 orders 表做拆分  
像是將各個季度的資料分表存放
這樣可以減少查詢時的壓力

然後若 orders 表上的欄位沒有建立索引  
可以考慮將 currency、created_at 欄位加上索引  
並且調整搜尋 created_at 的寫法
來提升 WHERE 的效率

```SQL
WHERE created_at BETWEEN '2023-05-01 00:00:00' AND '2023-05-31 23:59:59';
```
