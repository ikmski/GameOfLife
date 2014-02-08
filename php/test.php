<?php

require_once 'gameOfLife.php';

$initialCells = array(
                      array(10, 15),
                      array(10, 16),
                      array(10, 18),
                      array(10, 19),
                      array(11, 15),
                      array(11, 16),
                      array(11, 17),
                      array(11, 18),
                      array(13, 17),
                      array(14, 17),
                      array(15, 17),
                      array(16, 17),
                      array(13, 18),
                      array(14, 18),
                      array(15, 18),
                      array(16, 18),
                );

$instance = new GameOfLife(20, 30);
$instance->init($initialCells);

$instance->display();

/*
for ($i = 0; $i < 30; ++$i) {
    sleep(1);
    $instance->forward();
    $instance->display();
}
 */

exit;
