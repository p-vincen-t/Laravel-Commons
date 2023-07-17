<?php

namespace PVincenT\Commons\Utils;

/**
 * Undocumented trait
 */
trait AcceptorImpl
{
    /**
     * Undocumented function
     *
     * @param Visitor $v
     * @param array $args
     */
    public function accept(Visitor $v, $args = [])
    {
        return $v->visit($this, $args);
    }
}
