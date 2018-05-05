<?php
$pools = explode(' ', $packet['v']);
Array_shift($pools);
$this->pools = $pools;