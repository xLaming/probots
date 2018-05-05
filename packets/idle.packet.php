<?php
$this->sockets->shutdown();
$this->sockets->connect();
$this->joinRoom($this->roomInfo["id"], True);
