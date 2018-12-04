SELECT sum(g.monto) AS Sumas, g.fecha, TG.Descripcion FROM gastos g INNER JOIN tipo_gasto TG ON g.id_tipo_gasto=TG.id
GROUP BY tg.id
SELECT SUM(I.monto), I.fecha, TI.Descripcion FROM ingresos I INNER JOIN tipo_ingreso TI ON I.id_tipo_ingreso=TI.id
GROUP BY TI.id

SELECT SUM(I.monto)  FROM ingresos I
WHERE id_usuario = 1


SELECT SUM(I.monto)  FROM ingresos I
WHERE id_usuario = 1;

SELECT SUM(G.monto)  FROM gastos G
WHERE id_usuario = 1

