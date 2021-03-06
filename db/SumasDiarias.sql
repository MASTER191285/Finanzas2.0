SELECT 
SUM(G.monto) AS Monto
,G.observaciones AS Notas
,TP.descripcion AS 'Tipo de Gasto'
/*,G.fecha */
,DATE_FORMAT(G.fecha , "%a, %d de %M de %Y") AS Fecha
FROM 
GASTOS G
INNER JOIN 
TIPO_GASTO TP
ON G.id_tipo_gasto=TP.id
WHERE fecha BETWEEN '2018-12-01' AND CURDATE()
GROUP BY TP.descripcion,G.observaciones
ORDER BY Fecha
