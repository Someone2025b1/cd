TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `LOG_FACTURA_ADD` AFTER INSERT ON `FACTURA`\n FOR EACH ROW INSERT INTO LOG_BD(LBD_HOST, LBD_USUARIO, LBD_OPERACION, LBD_HORA, LBD_TABLA) \nVALUES (SUBSTRING(USER(), (INSTR(USER(),\'@\')+1)), SUBSTRING(USER(),1,(instr(user(),\'@\')-1)), \'INSERTAR\', CURRENT_TIMESTAMP(), \'FACTURA\')' 'CREATE DEFINER=`root`@`localhost` TRIGGER `LOG_FACTURA_DEL` AFTER DELETE ON `FACTURA`\n FOR EACH ROW INSERT INTO LOG_BD(LBD_HOST, LBD_USUARIO, LBD_OPERACION, LBD_HORA, LBD_TABLA) \nVALUES (SUBSTRING(USER(), (INSTR(USER(),\'@\')+1)), SUBSTRING(USER(),1,(instr(user(),\'@\')-1)), \'ELIMINAR\', CURRENT_TIMESTAMP(), \'FACTURA\')' 'CREATE DEFINER=`root`@`localhost` TRIGGER `LOG_FACTURA_UP` AFTER UPDATE ON `FACTURA`\n FOR EACH ROW INSERT INTO LOG_BD(LBD_HOST, LBD_USUARIO, LBD_OPERACION, LBD_HORA, LBD_TABLA) \nVALUES (SUBSTRING(USER(), (INSTR(USER(),\'@\')+1)), SUBSTRING(USER(),1,(instr(user(),\'@\')-1)), \'ACTUALIZAR\', CURRENT_TIMESTAMP(), \'FACTURA\')'
sql_modes=0 0 0
definers='root@localhost' 'root@localhost' 'root@localhost'
client_cs_names='utf8' 'utf8' 'utf8'
connection_cl_names='utf8_general_ci' 'utf8_general_ci' 'utf8_general_ci'
db_cl_names='latin1_swedish_ci' 'latin1_swedish_ci' 'latin1_swedish_ci'
