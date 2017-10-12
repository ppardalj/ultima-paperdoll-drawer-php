<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ultima\Domain\Item;
use Ultima\Domain\Layer;
use Ultima\PaperdollDrawer\PaperdollBuilder;
use Ultima\PaperdollDrawer\PaperdollDrawer;

$drawer = PaperdollDrawer::with(__DIR__ . '/../uofiles');

$paperdoll = PaperdollBuilder::create('Lord Semerkhet')
    ->withTitle('Legendary Developer')
    ->withItem(new Item(9860, 1109, Layer::NECK)) // Hooded shroud of shadows
    ->build();

$paperdollImage = $drawer->drawPaperdoll($paperdoll);
imagepng($paperdollImage, 'mypaperdoll.png');
