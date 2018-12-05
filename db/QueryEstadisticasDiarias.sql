SELECT 
      (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario AND id_tipo_gasto = 1
      ) AS GASTOS_ALIMENTACION,
      (
      	SELECT SUM(G3.MONTO)
        FROM gastos AS G3
        WHERE G3.id_usuario = G.id_usuario AND id_tipo_gasto = 7
      ) AS GASTOS_DISTRACCIONES,
      (
      	SELECT SUM(G4.MONTO)
        FROM gastos AS G4
        WHERE G4.id_usuario = G.id_usuario AND id_tipo_gasto = 11
      ) AS GASTOS_HORMIGA
FROM GASTOS AS G 
WHERE G.id_usuario = 1
GROUP BY G.id_usuario;