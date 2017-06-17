<?php

namespace IVAgafonov\System;

/**
 * Interface DataProviderInterface
 * @package IVAgafonov\System
 */
interface DataProviderInterface
{
    /**
     * Get objects by sql query
     *
     * @param string $query  Sql query
     * @param string $object Object name
     *
     * @return array|bool
     */
    public function getObjects($query, $object);

    /**
     * Get object by sql query
     *
     * @param string $query  Sql query
     * @param string $object Object name
     *
     * @return array|bool
     */
    public function getObject($query, $object);

    /**
     * Get arrays by sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function getArrays($query);

    /**
     * Get array by sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function getArray($query);

    /**
     * Get array by sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function getValue($query);

    /**
     * Execute sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function doQuery($query);

    /**
     * Quote string
     *
     * @param string $str Text string
     *
     * @return string
     */
    public function quote($str);

    /**
     * @return int
     */
    public function getAffectedRows();

    /**
     * @return string
     */
    public function getLastInsertId();

    /**
     * @return array
     */
    public function getLastError();

    /**
     * @return mixed
     */
    public function getLastErrno();
}
