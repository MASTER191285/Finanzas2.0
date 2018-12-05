SELECT 
SUM(G.monto)
,G.observaciones
,TP.descripcion
/*,G.fecha */
,DATE_FORMAT(G.fecha , "%a, %d de %M de %Y")
FROM 
GASTOS G
INNER JOIN 
TIPO_GASTO TP
ON G.id_tipo_gasto=TP.id
WHERE fecha BETWEEN '2018-12-01' AND CURDATE()
GROUP BY TP.descripcion,G.observaciones
