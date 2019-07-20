
SELECT ROUND(sum(g.monto) * 100.0 / 
(select monto from ingresos where id_tipo_ingreso = 1 and id_usuario = 1 and fecha BETWEEN '2019-07-01' AND CURDATE()),1) as porc
,tg.descripcion AS DESCRIPCION
FROM gastos g INNER JOIN tipo_gasto tg ON 
g.id_tipo_gasto=tg.id 
WHERE g.id_usuario = 1 
AND g.fecha BETWEEN '2019-07-01' AND CURDATE() GROUP BY tg.descripcion