CREATE OR REPLACE VIEW "view-movimientos" AS 
        (        (        (        (        ( SELECT DISTINCT n.id, n.fecha_mov, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                                           FROM nominas n
                                      JOIN cargos c ON n.id_cargo = c.id
                                 JOIN nominas_tipo nt ON nt.id::text = n.id_tipo_nomina::text
                            JOIN ubicaciones u ON u.id = n.id_ubicacion
                       JOIN empleados e ON e.id = n.id_empleado AND n.id_tipo_nomina::text = 'CO'::text
                      ORDER BY n.fecha_mov DESC, n.id, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                     LIMIT 1)
                                UNION 
                                        ( SELECT DISTINCT n.id, n.fecha_mov, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                                           FROM nominas n
                                      JOIN cargos c ON n.id_cargo = c.id
                                 JOIN nominas_tipo nt ON nt.id::text = n.id_tipo_nomina::text
                            JOIN ubicaciones u ON u.id = n.id_ubicacion
                       JOIN empleados e ON e.id = n.id_empleado AND n.id_tipo_nomina::text = 'SI'::text
                      ORDER BY n.fecha_mov DESC, n.id, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                     LIMIT 1))
                        UNION 
                                ( SELECT DISTINCT n.id, n.fecha_mov, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                                   FROM nominas n
                              JOIN cargos c ON n.id_cargo = c.id
                         JOIN nominas_tipo nt ON nt.id::text = n.id_tipo_nomina::text
                    JOIN ubicaciones u ON u.id = n.id_ubicacion
               JOIN empleados e ON e.id = n.id_empleado AND n.id_tipo_nomina::text = 'SE'::text
              ORDER BY n.fecha_mov DESC, n.id, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
             LIMIT 1))
                UNION 
                        ( SELECT DISTINCT n.id, n.fecha_mov, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                           FROM nominas n
                      JOIN cargos c ON n.id_cargo = c.id
                 JOIN nominas_tipo nt ON nt.id::text = n.id_tipo_nomina::text
            JOIN ubicaciones u ON u.id = n.id_ubicacion
       JOIN empleados e ON e.id = n.id_empleado AND n.id_tipo_nomina::text = 'PG'::text
      ORDER BY n.fecha_mov DESC, n.id, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
     LIMIT 1))
        UNION 
                ( SELECT DISTINCT n.id, n.fecha_mov, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
                   FROM nominas n
              JOIN cargos c ON n.id_cargo = c.id
         JOIN nominas_tipo nt ON nt.id::text = n.id_tipo_nomina::text
    JOIN ubicaciones u ON u.id = n.id_ubicacion
   JOIN empleados e ON e.id = n.id_empleado AND n.id_tipo_nomina::text = 'OB'::text
  ORDER BY n.fecha_mov DESC, n.id, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
 LIMIT 1))
UNION 
        ( SELECT DISTINCT n.id, n.fecha_mov, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
           FROM nominas n
      JOIN cargos c ON n.id_cargo = c.id
   JOIN nominas_tipo nt ON nt.id::text = n.id_tipo_nomina::text
   JOIN ubicaciones u ON u.id = n.id_ubicacion
   JOIN empleados e ON e.id = n.id_empleado AND n.id_tipo_nomina::text = 'PD'::text
  ORDER BY n.fecha_mov DESC, n.id, n.id_empleado, nt.nomina_tipo, c.cargo, n.fecha_ing, u.ubicacion, e.cedula
 LIMIT 1);

ALTER TABLE "view-movimientos"
  OWNER TO postgres;

 
