-- Crear un tipo enumerado para métodos de pago
CREATE TYPE metodo_pago_enum AS ENUM ('Tarjeta de crédito', 'Efectivo', 'Transferencia', 'Otro');

-- Tabla de roles
CREATE TABLE rol (
    id_rol SERIAL PRIMARY KEY,
    nombre_rol VARCHAR(50) UNIQUE NOT NULL
);

-- Tabla unificada de usuarios
CREATE TABLE usuario (
    id_usuario SERIAL PRIMARY KEY,
    usuario VARCHAR(20) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL, -- Se recomienda almacenar el hash de la contraseña
    nombre_completo VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) UNIQUE NOT NULL,
    foto_perfil VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Tabla de servicios
CREATE TABLE servicio (
    id_servicio SERIAL PRIMARY KEY,
    nombre_servicio VARCHAR(50) NOT NULL UNIQUE,  -- Añadir UNIQUE aquí
    descripcion_servicio VARCHAR(255) NOT NULL,
    precio NUMERIC(10, 2) NOT NULL,
    duracion INT NOT NULL DEFAULT 30
);


-- Tabla de citas
CREATE TABLE cita (
    id_cita SERIAL PRIMARY KEY,
    id_usuario_cliente INT NOT NULL,
    fecha DATE NOT NULL,
    hora_reserva TIMESTAMP WITH TIME ZONE NOT NULL, 
    hora_termino TIMESTAMP WITH TIME ZONE, 
    metodo_pago metodo_pago_enum,
    costo_total NUMERIC(10, 2) DEFAULT 0.00,
    id_usuario_barbero INT, --TENDRIA QUE ELEGIR SOLAMENTE BARBEROS?
    anticipo NUMERIC(10, 2) DEFAULT 0.00,
    FOREIGN KEY (id_usuario_cliente) REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_usuario_barbero) REFERENCES usuario(id_usuario) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Tabla asociativa cita_servicio
CREATE TABLE cita_servicio (
    id_cita INT NOT NULL,
    id_servicio INT NOT NULL,
    cantidad INT DEFAULT 1 CHECK (cantidad > 0), 
    costo NUMERIC(10, 2) NOT NULL,
    duracion INT NOT NULL,
    PRIMARY KEY (id_cita, id_servicio),
    FOREIGN KEY (id_cita) REFERENCES cita(id_cita) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicio(id_servicio) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Tabla asociativa barbero_servicio
CREATE TABLE barbero_servicio (
    id_usuario_barbero INT NOT NULL,
    id_servicio INT NOT NULL,
    PRIMARY KEY (id_usuario_barbero, id_servicio),
    FOREIGN KEY (id_usuario_barbero) REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicio(id_servicio) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla de logs para auditoría
CREATE TABLE logs (
    id_log SERIAL PRIMARY KEY,
    tabla VARCHAR(50),
    operacion VARCHAR(10),
    usuario VARCHAR(20),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    detalles TEXT
);

-- Índices para optimizar consultas
CREATE INDEX idx_cita_fecha ON cita(fecha);
CREATE INDEX idx_cita_usuario_barbero ON cita(id_usuario_barbero);
CREATE INDEX idx_cita_usuario_cliente ON cita(id_usuario_cliente);
CREATE INDEX idx_cita_servicio_servicio ON cita_servicio(id_servicio);
CREATE INDEX idx_barbero_servicio_servicio ON barbero_servicio(id_servicio);

-- Función para calcular la cantidad total de servicios en una cita
CREATE OR REPLACE FUNCTION cantidad_servicios_cita(p_id_cita INT)
RETURNS INT AS $$
DECLARE
    v_cantidad_total INT;
BEGIN
    SELECT COALESCE(SUM(cantidad), 0) INTO v_cantidad_total
    FROM cita_servicio
    WHERE id_cita = p_id_cita;

    RETURN v_cantidad_total;
END;
$$ LANGUAGE plpgsql;

----------------------------------------------------------------------------------------------------------------------------
-- Función para verificar si el usuario tiene el rol de Barbero o Administrador
CREATE OR REPLACE FUNCTION verificar_rol_permitido()
RETURNS TRIGGER AS $$
BEGIN
    -- Verificar si el usuario tiene el rol de Barbero o Administrador
    IF NOT EXISTS (
        SELECT 1 
        FROM usuario u
        JOIN rol r ON u.id_rol = r.id_rol
        WHERE u.id_usuario = NEW.id_usuario_barbero 
        AND r.nombre_rol IN ('Barbero', 'Administrador')
    ) THEN
        RAISE EXCEPTION 'Solo los roles de Barbero o Administrador pueden tener servicios asignados.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

----------------------------------------------------------------------------------------------------------------------------
-- Trigger en la tabla barbero_servicio para verificar roles
CREATE TRIGGER verificar_rol_en_asignacion_servicio
BEFORE INSERT ON barbero_servicio
FOR EACH ROW
EXECUTE FUNCTION verificar_rol_permitido();
----------------------------------------------------------------------------------------------------------------------------
-- Función para agregar un servicio a una cita
CREATE OR REPLACE FUNCTION agregar_servicio_cita(
   p_id_cita INT,
   p_id_servicio INT,
   p_cantidad INT
) RETURNS VOID AS $$
DECLARE
   v_precio NUMERIC(10, 2);
   v_costo NUMERIC(10, 2);
   v_duracion INT;
BEGIN
   -- Verificar si el servicio existe
   IF NOT EXISTS (SELECT 1 FROM servicio WHERE id_servicio = p_id_servicio) THEN
       RAISE EXCEPTION 'El servicio con ID % no existe', p_id_servicio;
   END IF;

   -- Verificar si el barbero ofrece el servicio
   IF NOT EXISTS (
       SELECT 1 
       FROM barbero_servicio bs
       JOIN cita c ON bs.id_usuario_barbero = c.id_usuario_barbero
       WHERE bs.id_servicio = p_id_servicio AND c.id_cita = p_id_cita
   ) THEN
       RAISE EXCEPTION 'El barbero asignado a la cita no ofrece el servicio con ID %', p_id_servicio;
   END IF;

   -- Obtener precio y duración del servicio
   SELECT precio, duracion INTO v_precio, v_duracion
   FROM servicio
   WHERE id_servicio = p_id_servicio;

   -- Calcular costo total y duración total
   v_costo := v_precio * p_cantidad;

   -- Insertar en cita_servicio
   INSERT INTO cita_servicio (id_cita, id_servicio, cantidad, costo, duracion)
   VALUES (p_id_cita, p_id_servicio, p_cantidad, v_costo, v_duracion * p_cantidad);
END;
$$ LANGUAGE plpgsql;
----------------------------------------------------------------------------------------------------------------------------
-- Función para calcular la duración total de una cita
CREATE OR REPLACE FUNCTION duracion_total_cita(p_id_cita INT)
RETURNS INT AS $$
DECLARE
    v_duracion_total INT;
BEGIN
    SELECT COALESCE(SUM(s.duracion * cs.cantidad), 0) INTO v_duracion_total
    FROM cita_servicio cs
    JOIN servicio s ON cs.id_servicio = s.id_servicio
    WHERE cs.id_cita = p_id_cita;

    RETURN v_duracion_total;
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para registrar una nueva cita
CREATE OR REPLACE FUNCTION registrar_cita(
    p_id_usuario_cliente INT, 
    p_fecha DATE,
    p_hora_reserva TIMESTAMP WITH TIME ZONE,
    p_metodo_pago metodo_pago_enum,
    p_id_usuario_barbero INT
) RETURNS TEXT AS $$
DECLARE
    v_costo_total NUMERIC(10, 2);
    v_id_cita INT;
    v_hora_termino TIMESTAMP WITH TIME ZONE;
    v_duracion_total INT;
BEGIN
    -- Verificar si hay servicios seleccionados para la cita
    IF NOT EXISTS (SELECT 1 FROM cita_servicio WHERE id_cita IS NULL) THEN
        RETURN 'No hay servicios seleccionados para registrar la cita';
    END IF;

    -- Verificar si la hora es válida (entre 10:00 y 20:00)
    IF EXTRACT(HOUR FROM p_hora_reserva) < 10 THEN
        RETURN 'Hora no válida: antes de las 10:00';
    ELSIF EXTRACT(HOUR FROM p_hora_reserva) >= 20 THEN
        RETURN 'Hora no válida: después de las 20:00';
    END IF;

    -- Calcular costo y duración total
    SELECT SUM(costo), SUM(duracion) INTO v_costo_total, v_duracion_total 
    FROM cita_servicio
    WHERE id_cita IS NULL;

    -- Calcular hora de término de la cita
    v_hora_termino := p_hora_reserva + (v_duracion_total * INTERVAL '1 minute');

    -- Verificar si la cita termina antes de las 20:00
    IF EXTRACT(HOUR FROM v_hora_termino) > 20 THEN
        RETURN 'Hora no válida: la cita terminaría después de las 20:00';
    END IF;

    -- Verificar conflictos de horario con el cliente y el barbero
    -- (Implementa las verificaciones correspondientes aquí)

    -- Registrar la cita en la tabla 'cita'
    INSERT INTO cita (id_usuario_cliente, fecha, hora_reserva, hora_termino, costo_total, id_usuario_barbero, metodo_pago, anticipo)
    VALUES (p_id_usuario_cliente, p_fecha, p_hora_reserva, v_hora_termino, v_costo_total, p_id_usuario_barbero, p_metodo_pago, v_costo_total * 0.2)
    RETURNING id_cita INTO v_id_cita;

    -- Registrar los servicios asociados en 'cita_servicio'
    UPDATE cita_servicio 
    SET id_cita = v_id_cita
    WHERE id_cita IS NULL;

    -- Retornar mensaje de éxito
    RETURN 'Cita registrada con éxito. ID de cita: ' || v_id_cita;
EXCEPTION
    WHEN OTHERS THEN
        RETURN 'Error al registrar la cita: ' || SQLERRM;
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para concluir una cita y actualizar el anticipo si es necesario
CREATE OR REPLACE FUNCTION concluir_cita(p_id_cita INT)
RETURNS TABLE(
    fecha_hora_actual TIMESTAMP,
    fecha_cita DATE,
    hora_reserva_cita TIMESTAMP WITH TIME ZONE,
    hora_termino_cita TIMESTAMP WITH TIME ZONE,
    anticipo NUMERIC(10, 2)
) AS $$
DECLARE
    v_fecha DATE;
    v_hora_reserva TIMESTAMP WITH TIME ZONE;
    v_hora_termino TIMESTAMP WITH TIME ZONE;
    v_anticipo NUMERIC(10, 2);
    v_costo_total NUMERIC(10, 2);
BEGIN
    -- Obtener la fecha y hora actuales
    fecha_hora_actual := CURRENT_TIMESTAMP;

    -- Obtener detalles de la cita
    SELECT fecha, hora_reserva, hora_termino, anticipo, costo_total
    INTO v_fecha, v_hora_reserva, v_hora_termino, v_anticipo, v_costo_total
    FROM cita
    WHERE id_cita = p_id_cita;

    IF v_fecha IS NULL THEN
        RETURN;
    END IF;

    -- Verificar si la cita ya ha pasado
    IF fecha_hora_actual > v_hora_termino THEN
        -- Actualizar el anticipo si es necesario
        UPDATE cita
        SET anticipo = v_costo_total
        WHERE id_cita = p_id_cita;
        v_anticipo := v_costo_total;
    END IF;

    -- Retornar los detalles actualizados
    RETURN QUERY 
    SELECT fecha_hora_actual, v_fecha, v_hora_reserva, v_hora_termino, v_anticipo;
END;
$$ LANGUAGE plpgsql;

------------------------------------------------------------------------------------------------------------------------
-- Función para que un cliente anule una cita
CREATE OR REPLACE FUNCTION cancelar_cita_cliente(p_id_cita INT, p_id_cliente INT)
RETURNS TEXT AS $$
DECLARE
    v_fecha_cita DATE;
    v_dias_anticipacion INT;
BEGIN
    -- Obtener la fecha de la cita
    SELECT fecha INTO v_fecha_cita
    FROM cita
    WHERE id_cita = p_id_cita AND id_usuario_cliente = p_id_cliente;

    IF v_fecha_cita IS NULL THEN
        RETURN 'La cita no existe o no pertenece a este cliente.';
    END IF;

    -- Calcular los días de anticipación
    v_dias_anticipacion := (v_fecha_cita - CURRENT_DATE);

    IF v_dias_anticipacion < 4 THEN
        RETURN 'La cita no puede ser cancelada con menos de 4 días de anticipación.';
    END IF;

    -- Eliminar servicios asociados y la cita
    DELETE FROM cita_servicio WHERE id_cita = p_id_cita;
    DELETE FROM cita WHERE id_cita = p_id_cita;

    RETURN 'Cita cancelada exitosamente.';
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para que un barbero anule una cita
CREATE OR REPLACE FUNCTION cancelar_cita_barbero(p_id_cita INT, p_id_barbero INT)
RETURNS TEXT AS $$
DECLARE
    v_fecha_cita DATE;
    v_dias_anticipacion INT;
BEGIN
    -- Obtener la fecha de la cita
    SELECT fecha INTO v_fecha_cita
    FROM cita
    WHERE id_cita = p_id_cita AND id_usuario_barbero = p_id_barbero;

    IF v_fecha_cita IS NULL THEN
        RETURN 'La cita no existe o no pertenece a este barbero.';
    END IF;

    -- Calcular los días de anticipación
    v_dias_anticipacion := (v_fecha_cita - CURRENT_DATE);

    IF v_dias_anticipacion < 4 THEN
        RETURN 'La cita no puede ser cancelada con menos de 4 días de anticipación.';
    END IF;

    -- Eliminar servicios asociados y la cita
    DELETE FROM cita_servicio WHERE id_cita = p_id_cita;
    DELETE FROM cita WHERE id_cita = p_id_cita;

    RETURN 'Cita cancelada exitosamente.';
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para obtener los servicios asociados a las citas de un cliente
CREATE OR REPLACE FUNCTION servicios_cita_cliente(p_id_usuario_cliente INT)
RETURNS TABLE (
    id_cita INT,
    fecha DATE,
    hora_reserva TIMESTAMP WITH TIME ZONE,
    hora_termino TIMESTAMP WITH TIME ZONE,
    nombre_barbero VARCHAR(100),
    nombre_servicio VARCHAR(50),
    cantidad INT,
    costo NUMERIC(10, 2)
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        c.id_cita,
        c.fecha,
        c.hora_reserva,
        c.hora_termino,
        u.nombre_completo AS nombre_barbero,
        s.nombre_servicio,
        cs.cantidad,
        cs.costo
    FROM 
        cita c
    JOIN 
        cita_servicio cs ON c.id_cita = cs.id_cita
    JOIN 
        servicio s ON cs.id_servicio = s.id_servicio
    LEFT JOIN
        usuario u ON c.id_usuario_barbero = u.id_usuario
    WHERE 
        c.id_usuario_cliente = p_id_usuario_cliente;
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para obtener las citas programadas para un barbero específico
CREATE OR REPLACE FUNCTION citas_barbero(p_id_usuario_barbero INT)
RETURNS TABLE (
    id_cita INT,
    nombre_cliente VARCHAR(100),
    fecha DATE,
    hora_reserva TIMESTAMP WITH TIME ZONE,
    hora_termino TIMESTAMP WITH TIME ZONE,
    costo_total NUMERIC(10, 2),
    metodo_pago metodo_pago_enum
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        c.id_cita,
        u.nombre_completo AS nombre_cliente,
        c.fecha,
        c.hora_reserva,
        c.hora_termino,
        c.costo_total,
        c.metodo_pago
    FROM 
        cita c
    JOIN
        usuario u ON c.id_usuario_cliente = u.id_usuario
    WHERE 
        c.id_usuario_barbero = p_id_usuario_barbero
    ORDER BY 
        c.fecha, c.hora_reserva;
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para calcular los ingresos anuales por mes
CREATE OR REPLACE FUNCTION ingresos_anual(p_año INT)
RETURNS TABLE (
    mes TEXT,
    ingresos NUMERIC(10, 2)
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        TO_CHAR(DATE_TRUNC('month', fecha), 'TMMonth') AS mes,
        SUM(anticipo) AS ingresos
    FROM 
        cita
    WHERE 
        EXTRACT(YEAR FROM fecha) = p_año
    GROUP BY 
        DATE_TRUNC('month', fecha)
    ORDER BY 
        DATE_TRUNC('month', fecha);
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
--Procedimiento para crear usuario
CREATE OR REPLACE PROCEDURE crear_usuario(
    p_usuario VARCHAR(20),
    p_clave VARCHAR(255),
    p_tipo_rol VARCHAR(50),
    p_nombre_completo VARCHAR(100),
    p_telefono VARCHAR(15),
    p_foto_perfil VARCHAR(100)
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_id_rol INT;
    v_exists BOOLEAN;
BEGIN
    -- Verificar si el rol existe, si no, crearlo
    IF NOT EXISTS (SELECT 1 FROM rol WHERE nombre_rol = p_tipo_rol) THEN
        INSERT INTO rol (nombre_rol) VALUES (p_tipo_rol) RETURNING id_rol INTO v_id_rol;
    ELSE
        SELECT id_rol INTO v_id_rol FROM rol WHERE nombre_rol = p_tipo_rol;
    END IF;

    -- Verificar si el usuario de base de datos ya existe
    SELECT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = p_usuario) INTO v_exists;
    IF NOT v_exists THEN
        EXECUTE format('CREATE USER %I WITH PASSWORD %L', p_usuario, p_clave);
    END IF;

    -- Insertar el usuario en la tabla 'usuario'
    INSERT INTO usuario (usuario, clave, nombre_completo, telefono, foto_perfil, id_rol) 
    VALUES (p_usuario, p_clave, p_nombre_completo, p_telefono, p_foto_perfil, v_id_rol);

    RAISE NOTICE 'Usuario % creado con éxito y asignado al Rol %', p_usuario, p_tipo_rol;
END;
$$;
------------------------------------------------------------------------------------------------------------------------
-- Procedimiento para dar de baja a un usuario
CREATE OR REPLACE PROCEDURE baja_usuario(p_id_usuario INT)
LANGUAGE plpgsql
AS $$
DECLARE
    v_usuario VARCHAR(20);
    v_tipo_rol VARCHAR(50);
BEGIN
    -- Obtener el nombre de usuario y tipo de rol
    SELECT u.usuario, r.nombre_rol INTO v_usuario, v_tipo_rol
    FROM usuario u
    JOIN rol r ON u.id_rol = r.id_rol
    WHERE u.id_usuario = p_id_usuario;

    IF v_usuario IS NULL THEN
        RAISE NOTICE 'Usuario no encontrado';
        RETURN;
    END IF;

    -- Actualizar el estado a inactivo
    UPDATE usuario
    SET activo = FALSE
    WHERE id_usuario = p_id_usuario;

    -- Revocar privilegios según el rol
    IF v_tipo_rol = 'Administrador' THEN
        EXECUTE format('REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA public FROM %I', v_usuario);
        EXECUTE format('REVOKE ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public FROM %I', v_usuario);
        EXECUTE format('REVOKE ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public FROM %I', v_usuario);
    ELSIF v_tipo_rol = 'Cajero' THEN
        EXECUTE format('REVOKE SELECT, UPDATE ON usuario FROM %I', v_usuario);
        EXECUTE format('REVOKE SELECT ON cita FROM %I', v_usuario);
        EXECUTE format('REVOKE SELECT ON servicio FROM %I', v_usuario);
    ELSIF v_tipo_rol = 'Barbero' THEN
        EXECUTE format('REVOKE SELECT, UPDATE ON usuario FROM %I', v_usuario);
        EXECUTE format('REVOKE SELECT ON cita FROM %I', v_usuario);
        EXECUTE format('REVOKE SELECT ON servicio FROM %I', v_usuario);
    ELSIF v_tipo_rol = 'Cliente' THEN
        EXECUTE format('REVOKE SELECT, INSERT ON cita FROM %I', v_usuario);
        EXECUTE format('REVOKE SELECT, INSERT ON cita_servicio FROM %I', v_usuario);
    END IF;

    RAISE NOTICE 'Usuario % dado de baja exitosamente', v_usuario;
END;
$$;
------------------------------------------------------------------------------------------------------------------------
-- Función para actualizar la información de un usuario
CREATE OR REPLACE FUNCTION actualizar_usuario(
    p_id_usuario INT,
    p_usuario VARCHAR(20),
    p_clave VARCHAR(255),
    p_nombre_completo VARCHAR(100),
    p_telefono VARCHAR(15),
    p_foto_perfil VARCHAR(100)
) RETURNS TEXT AS $$
DECLARE
    v_usuario_antiguo VARCHAR(20);
BEGIN
    -- Verificar que el usuario exista
    IF NOT EXISTS (SELECT 1 FROM usuario WHERE id_usuario = p_id_usuario) THEN
        RETURN 'Usuario no encontrado';
    END IF;

    -- Obtener el nombre de usuario actual
    SELECT usuario INTO v_usuario_antiguo
    FROM usuario
    WHERE id_usuario = p_id_usuario;

    -- Actualizar los datos del usuario
    UPDATE usuario
    SET 
        usuario = p_usuario,
        clave = p_clave,
        nombre_completo = p_nombre_completo,
        telefono = p_telefono,
        foto_perfil = p_foto_perfil
    WHERE id_usuario = p_id_usuario;

    -- Si el nombre de usuario ha cambiado, renombrar el usuario en PostgreSQL
    IF v_usuario_antiguo != p_usuario THEN
        EXECUTE format('ALTER USER %I RENAME TO %I', v_usuario_antiguo, p_usuario);
    END IF;

    -- Actualizar la contraseña del usuario en PostgreSQL
    EXECUTE format('ALTER USER %I WITH PASSWORD %L', p_usuario, p_clave);

    RETURN 'Usuario actualizado con éxito';
END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------------------------------------------------------------------
-- Función para loguear inserciones
CREATE OR REPLACE FUNCTION log_insert()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO logs (tabla, operacion, usuario, detalles)
    VALUES (TG_TABLE_NAME, 'INSERT', current_user, row_to_json(NEW)::text);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Función para loguear actualizaciones
CREATE OR REPLACE FUNCTION log_update()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO logs (tabla, operacion, usuario, detalles)
    VALUES (TG_TABLE_NAME, 'UPDATE', current_user, row_to_json(NEW)::text);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Función para loguear eliminaciones
CREATE OR REPLACE FUNCTION log_delete()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO logs (tabla, operacion, usuario, detalles)
    VALUES (TG_TABLE_NAME, 'DELETE', current_user, row_to_json(OLD)::text);
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

-- Crear triggers para cada tabla relevante
-- Ejemplo para la tabla 'cita'
CREATE TRIGGER trg_cita_insert
AFTER INSERT ON cita
FOR EACH ROW
EXECUTE FUNCTION log_insert();

CREATE TRIGGER trg_cita_update
AFTER UPDATE ON cita
FOR EACH ROW
EXECUTE FUNCTION log_update();

CREATE TRIGGER trg_cita_delete
AFTER DELETE ON cita
FOR EACH ROW
EXECUTE FUNCTION log_delete();

-- Repetir para otras tablas según sea necesario
------------------------------------------------------------------------------------------------------------------------
-- Insertar roles iniciales
INSERT INTO rol (nombre_rol) VALUES 
('Administrador'), 
('Cajero'), 
('Barbero'), 
('Cliente')
ON CONFLICT (nombre_rol) DO NOTHING;

-- Insertar servicios iniciales
-- Insertar servicios iniciales
INSERT INTO servicio (nombre_servicio, descripcion_servicio, precio, duracion) VALUES
('Haircut', 'Get the haircut you want with our expert stylist. Whether it''s a classic style or something unique, just bring a picture, and we''ll create the look you desire.', 45.00, 40),
('Full Cut', 'Experience our original full haircut package: A premium grooming service that includes a precise haircut, detailed beard shaping and eyebrow trimming.', 60.00, 60),
('Kids', 'We welcome kids for haircuts! For their comfort and safety, we recommend parent and adult supervision for those who are a bit more active.', 35.00, 30),
('Beard Grooming', 'We offer precise line-ups, shaping, trimming, and shaving. Enjoy a hot towel treatment and relaxing oil for a refreshing experience.', 30.00, 30),
('Wild Cut', 'Come and live the Wild Deer experience, a service in personal care and well-being, leaving you feeling renewed, confident and ready for any adventure.', 115.00, 90),
('Facial', 'We apply masks rich in natural ingredients to deeply nourish and hydrate the skin. This mask, inspired by the purity of nature, returns luminosity and elasticity to your face.', 35.00, 30),
('Line Up', 'Defining the lines of the forehead, sideburns, and nape, creating a symmetrical and polished finish.', 40.00, 30),
('Hydrogen Oxygen', 'Is a non-invasive skin care procedure that uses a special device to deliver a mixture of hydrogen gas and oxygen to the skin for deeply cleansing pores and reducing imperfections.', 140.00, 60)
ON CONFLICT (nombre_servicio) DO NOTHING;


-- Crear un administrador
CALL crear_usuario(
    'admin1', 
    'Clave123_A1!', -- Reemplazar con el hash de la contraseña
    'Administrador', 
    'Juan Pérez', 
    '+34123456789', 
    'JuanPerez.jpg'
);

-- Crear un cajero
CALL crear_usuario(
    'cajero1', 
    'Clave789_C1#', -- Reemplazar con el hash de la contraseña
    'Cajero', 
    'Pedro Rodríguez', 
    '+31112223333', 
    'PedroRodriguez.jpg'
);

-- Crear un barbero
CALL crear_usuario(
    'barbero1', 
    'Clave345_B1%', -- Reemplazar con el hash de la contraseña
    'Barbero', 
    'Carlos López', 
    '+37778889999', 
    'CarlosLopez.jpg'
);

-- Crear un cliente
CALL crear_usuario(
    'cliente1', 
    'Clave901_Cl1&', -- Reemplazar con el hash de la contraseña
    'Cliente', 
    'Roberto Fernández', 
    '+3334445555', 
    'RobertoFernandez.jpg'
);

-- Asignar servicios al barbero1 (id_usuario = 3 asumiendo el orden de inserción)
INSERT INTO barbero_servicio (id_usuario_barbero, id_servicio) VALUES 
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5)
ON CONFLICT DO NOTHING;
---------------------------------------------------------------------------------------------
-- Función para calcular los ingresos anuales por mes
CREATE OR REPLACE FUNCTION ingresos_anual(p_año INT)
RETURNS TABLE (
    mes TEXT,
    ingresos NUMERIC(10, 2)
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        TO_CHAR(DATE_TRUNC('month', fecha), 'TMMonth') AS mes,
        SUM(anticipo) AS ingresos
    FROM 
        cita
    WHERE 
        EXTRACT(YEAR FROM fecha) = p_año
    GROUP BY 
        DATE_TRUNC('month', fecha)
    ORDER BY 
        DATE_TRUNC('month', fecha);
END;
$$ LANGUAGE plpgsql;
---------------------------------------------------------------------------------------------
-- Ejemplo de triggers para la tabla 'usuario'
CREATE TRIGGER trg_usuario_insert
AFTER INSERT ON usuario
FOR EACH ROW
EXECUTE FUNCTION log_insert();

CREATE TRIGGER trg_usuario_update
AFTER UPDATE ON usuario
FOR EACH ROW
EXECUTE FUNCTION log_update();

CREATE TRIGGER trg_usuario_delete
AFTER DELETE ON usuario
FOR EACH ROW
EXECUTE FUNCTION log_delete();

-- Repetir para otras tablas si es necesario
------------------------------------------------------------------------------------------
-- Función para actualizar el anticipo al concluir una cita
CREATE OR REPLACE FUNCTION actualizar_anticipo_concluir_cita()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.hora_termino IS NOT NULL AND NEW.hora_termino < CURRENT_TIMESTAMP THEN
        NEW.anticipo := NEW.costo_total;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger para la tabla 'cita'
CREATE TRIGGER trg_actualizar_anticipo
BEFORE UPDATE ON cita
FOR EACH ROW
EXECUTE FUNCTION actualizar_anticipo_concluir_cita();
