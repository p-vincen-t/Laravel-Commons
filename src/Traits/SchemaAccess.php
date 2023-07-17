<?php

namespace PVincenT\Commons\Traits;

use Illuminate\Support\Facades\Schema;

trait SchemaAccess {
    public static $schemaInstance;
    public static $schemaColumnNames;
    public static $schemaTableName;

    /**
     * @return Illuminate\Database\Eloquent\Model
     * Returns singleton of model
     */
    protected static function schemaInstance() {
        if(empty(static::$schemaInstance)) {
            static::$schemaInstance = new static;
        }
        return static::$schemaInstance;
    }

    /**
     * @return string
     * Returns the table name for a given model
     */
    public static function getSchemaTableName() {
        if(empty(static::$schemaTableName)) {
            static::$schemaTableName = static::schemaInstance()->getTable();
        }
        return static::$schemaTableName;
    }

    /**
     * @return array
     * Fetches column names from the database schema
     */
    public static function getSchemaColumnNames() {
        if(empty(static::$schemaColumnNames)) {
            static::$schemaColumnNames = Schema::getColumnListing(static::getSchemaTableName());
        }
        return static::$schemaColumnNames;
    }

    /**
     * @param $name
     * @return bool
     */
    public static function schemaHasColumn($name) {
        return in_array( $name, static::getSchemaColumnNames() );
    }
}
