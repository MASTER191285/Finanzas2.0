DELIMITER //
CREATE PROCEDURE INFO_DIARIA (IN Id_User INT)  
BEGIN
DECLARE FECHA_INI DATETIME;
SET FECHA_INI= (SELECT DATE(NOW()) - INTERVAL DAY(NOW()) DAY + INTERVAL 1 DAY);
SELECT 
      (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario
        AND G2.fecha BETWEEN FECHA_INI AND CURDATE()
        AND G2.id_tipo_gasto = 1
      ) AS GASTOS_ALIMENTACION,
      (
      	SELECT SUM(G3.MONTO)
        FROM gastos AS G3        
        WHERE G3.id_usuario = G.id_usuario 
        AND G3.fecha BETWEEN FECHA_INI AND CURDATE()
        AND G3.id_tipo_gasto = 7
      ) AS GASTOS_DISTRACCIONES,
      (
      	SELECT SUM(G4.MONTO)
        FROM gastos AS G4        
        WHERE G4.id_usuario = G.id_usuario 
        AND G4.fecha BETWEEN FECHA_INI AND CURDATE()
        AND G4.id_tipo_gasto = 11
      ) AS GASTOS_HORMIGA     
      
FROM GASTOS AS G 
WHERE G.id_usuario = Id_User
GROUP BY G.id_usuario;
END

DELIMITER //
CREATE PROCEDURE GET_TOTALESV2 (IN Id_User INT)
BEGIN
DECLARE FECHA_INI DATETIME;
SET FECHA_INI= (SELECT DATE(NOW()) - INTERVAL DAY(NOW()) DAY + INTERVAL 1 DAY);
SELECT 	  (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario
        AND G2.fecha BETWEEN FECHA_INI AND CURDATE()
      ) AS GASTOS,
	 (
      	SELECT SUM(I2.MONTO)
        FROM ingresos AS I2
        WHERE I2.id_usuario = G.id_usuario
        AND I2.fecha BETWEEN FECHA_INI AND SYSDATE()
      ) AS INGRESOS,
      (
        (
      		SELECT SUM(I2.MONTO)
        	FROM ingresos AS I2
        	WHERE I2.id_usuario = G.id_usuario
        	AND I2.fecha BETWEEN FECHA_INI AND SYSDATE()
      	) 
      	-
      	(
      		SELECT SUM(G2.MONTO)
        	FROM gastos AS G2
        	WHERE G2.id_usuario = G.id_usuario
        	AND G2.fecha BETWEEN FECHA_INI AND CURDATE()
      	)
      )AS TOTAL
      
FROM GASTOS AS G 
WHERE G.id_usuario = Id_User
GROUP BY G.id_usuario;
END