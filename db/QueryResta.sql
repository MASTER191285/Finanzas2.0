SELECT 
      (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario
      ) AS GASTOS,
      (
      	SELECT SUM(I2.MONTO)
        FROM ingresos AS I2
        WHERE I2.id_usuario = G.id_usuario
      ) AS INGRESOS,
      (
        (
      		SELECT SUM(I2.MONTO)
        	FROM ingresos AS I2
        	WHERE I2.id_usuario = G.id_usuario
      	) 
      	
      	-
      	(
      		SELECT SUM(G2.MONTO)
        	FROM gastos AS G2
        	WHERE G2.id_usuario = G.id_usuario
      	)
      	
      )
AS TOTAL
FROM gastos AS G 
GROUP BY G.id_usuario
