SELECT 
G.monto
,CASE 
WHEN G.comprobante IS NULL THEN 'Sin Comprobante'
ELSE G.Comprobante
END AS Comprobante
,G.observaciones AS Notas
,TP.descripcion AS 'Tipo de Gasto'
,DATE_FORMAT(G.fecha , "%d de %M de %Y") AS Fecha
FROM 
GASTOS G
INNER JOIN 
TIPO_GASTO TP
ON G.id_tipo_gasto=TP.id
WHERE fecha BETWEEN '2018-12-01' AND CURDATE()
ORDER BY Fecha ASC LIMIT 15