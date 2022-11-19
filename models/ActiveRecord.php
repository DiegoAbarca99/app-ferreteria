<?php

namespace Model;

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }
    // Validación
    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Registros - CRUD
    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function Notall($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE NOT ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Ordenar registros de la BD
    public static function ordenar($columna, $orden)
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY  ${columna} ${orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Retorna el total de registro de la BD
    public static function total($columna = '', $valor = '')
    {
        $query = "SELECT count(*) FROM " . static::$tabla;
        if ($columna) {
            $query .= " WHERE ${columna} = ${valor}";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_assoc();
        return array_shift($total);
    }
    //Retorna el total de todos los registro a exepción de una condición
    public static function totalAndNot($columna = '', $valor = '')
    {
        $query = "SELECT count(*) FROM " . static::$tabla;
        if ($columna) {
            $query .= " WHERE NOT ${columna} = ${valor}";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_assoc();
        return array_shift($total);
    }

    //Total de registros con un ArrayWhere
    public static function totalArray($array = [])
    {
        $query = "SELECT count(*) FROM " . static::$tabla . ' WHERE';
        foreach ($array as $key => $value) {
            if ($key === array_key_last($array)) {
                $query .= " ${key} = '${value}'";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_assoc();
        return array_shift($total);
    }


    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registro
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Retorna registro de la BD en función de la paginación dada
    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset} ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    // Busqueda Where con Array
    public static function whereArray($array = [])
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE";
        foreach ($array as $key => $value) {
            if ($key === array_key_last($array)) {
                $query .= " ${key} = '${value}'";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }
        }
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    //Busca todos los registros que pertenecen a un ID
    public static function belongsTo($columna, $valor, $orden)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    //Busca todos los registros que pertenecen a un ID y los ordena según cierta columna y patro´n
    public static function belongsToAndOrden($columna, $valor, $orden)
    {
        if (empty($valor)) {
            $query = "SELECT * FROM " . static::$tabla . " ORDER BY ${columna} ${orden} ";
        } else {
            $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}' ORDER BY ${columna} ${orden} ";
        }

      
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    //Busca todos los registros que pertenecen a un ID y en base a una paginación dada
    public static function belongsToAndPag($columna, $valor, $por_pagina, $offset)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}' ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset} ";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    // Busqueda Where con Array y una paginación dada
    public static function whereNotAndPag($offset, $por_pagina, $columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE NOT ${columna} = '${valor}'  ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset} ";

        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    // SQL para Consultas Avanzadas.
    public static function SQL($consulta)
    {
        $query = $consulta;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";


        // Resultado de la consulta
        $resultado = self::$db->query($query);

        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // debuguear($query);

        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar()
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
