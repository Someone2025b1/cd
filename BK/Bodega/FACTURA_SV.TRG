TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER LOG_FACTURA_SV_ADD AFTER INSERT ON Bodega.FACTURA_SV\nFOR EACH ROW \nINSERT INTO LOG_BD(LBD_HOST, LBD_USUARIO, LBD_OPERACION, LBD_HORA, LBD_TABLA) \nVALUES (SUBSTRING(USER(), (INSTR(USER(),\'@\')+1)), SUBSTRING(USER(),1,(instr(user(),\'@\')-1)), \'INSERTAR\', CURRENT_TIMESTAMP(), \'FACTURA_SOUVENIR\')' 'CREATE DEFINER=`root`@`localhost` TRIGGER LOG_FACTURA_SV_UP AFTER UPDATE ON Bodega.FACTURA_SV\nFOR EACH ROW \nINSERT INTO LOG_BD(LBD_HOST, LBD_USUARIO, LBD_OPERACION, LBD_HORA, LBD_TABLA) \nVALUES (SUBSTRING(USER(), (INSTR(USER(),\'@\')+1)), SUBSTRING(USER(),1,(instr(user(),\'@\')-1)), \'ACTUALIZAR\', CURRENT_TIMESTAMP(), \'FACTURA_SOUVENIR\')' 'CREATE DEFINER=`root`@`localhost` TRIGGER LOG_FACTURA_SV_DEL AFTER DELETE ON Bodega.FACTURA_SV\nFOR EACH ROW \nINSERT INTO LOG_BD(LBD_HOST, LBD_USUARIO, LBD_OPERACION, LBD_HORA, LBD_TABLA) \nVALUES (SUBSTRING(USER(), (INSTR(USER(),\'@\')+1)), SUBSTRING(USER(),1,(instr(user(),\'@\')-1)), \'ELIMINAR\', CURRENT_TIMESTAMP(), \'FACTURA_SOUVENIR\')'
sql_modes=0 0 0
definers='root@localhost' 'root@localhost' 'root@localhost'
client_cs_names='utf8' 'utf8' 'utf8'
connection_cl_names='utf8_general_ci' 'utf8_general_ci' 'utf8_general_ci'
db_cl_names='latin1_swedish_ci' 'latin1_swedish_ci' 'latin1_swedish_ci'
