SELECT monto, descripcion, observaciones FROM Gastos INNER JOIN tipo_gasto TP
ON id_tipo_gasto=TP.id
WHERE 
/*fecha BETWEEN '2018-11-26 00:00:00' AND '2018-11-26 23:59:59'*/
fecha BETWEEN '2018-11-01 00:00:00' AND SYSDATE()