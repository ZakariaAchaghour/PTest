<?php
declare(strict_types=1);

namespace Scripts;

use ArrayIterator;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;

require_once 'vendor/autoload.php';

$container = require 'config/container.php';

$eventStore = $container->get(EventStore::class);

$eventStore->create(new Stream(new StreamName('stream_post'), new ArrayIterator()));
