<?php

namespace PVincenT\Commons\Utils;

interface Acceptor {
    public function accept(Visitor $v, $args);
}
