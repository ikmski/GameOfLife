<?php

require_once 'grid.php';

class GameOfLife
{
    const NUM_OF_BIRTH = 3;
    const NUM_OF_LESS  = 1;
    const NUM_OF_OVER  = 4;

    private $grid    = null;
    private $gridBuf = null;

    /**
     * コンストラクタ
     */
    public function __construct($rows=10, $column=10)
    {
        $this->grid    = new Grid($rows, $column);
        $this->gridBuf = new Grid($rows, $column);
    }

    /*
     * 初期化
     * 生存セルを設定する
     */
    public function init(array $aliveCells)
    {
        $rows    = $this->grid->getRows();
        $columns = $this->grid->getColumns();

        foreach ($aliveCells as $cell) {
            if (($cell[0] >= 0) &&
                ($cell[0] <= $rows) &&
                ($cell[1] >= 0) &&
                ($cell[1] <= $columns)) {
                $this->grid->bear($cell[0], $cell[1]);
            }
        }
    }

    /**
     * 世代を進める
     */
    public function forward()
    {
        $rows    = $this->grid->getRows();
        $columns = $this->grid->getColumns();

        $this->grid->copySelf($this->gridBuf);
        for ($i = 0; $i < $rows; ++$i) {
            for ($j = 0; $j < $columns; ++$j) {
                $count   = $this->gridBuf->totalNeighbours($i, $j);
                $isAlive = $this->gridBuf->isAlive($i, $j);

                if (!$isAlive && $count == self::NUM_OF_BIRTH) {
                    $this->grid->bear($i, $j);
                }
                elseif ($isAlive && $count <= self::NUM_OF_LESS) {
                    $this->grid->kill($i, $j);
                }
                elseif ($isAlive && $count >= self::NUM_OF_OVER) {
                    $this->grid->kill($i, $j);
                }
            }
        }

    }

    /**
     * 表示
     */
    public function display()
    {
        $rows    = $this->grid->getRows();
        $columns = $this->grid->getColumns();

        print(PHP_EOL);
        print(PHP_EOL);
        for ($j = 0; $j < $columns; ++$j) {
            print('--');
        }
        print(PHP_EOL);

        for ($i = 0; $i < $rows; ++$i) {
            for ($j = 0; $j < $columns; ++$j) {
                if ($this->grid->isAlive($i, $j)) {
                    print('■ ');
                }
                else {
                    print('□ ');
                }
            }
            print(PHP_EOL);
        }
        for ($j = 0; $j < $columns; ++$j) {
            print('--');
        }
        print(PHP_EOL);

    }
}

