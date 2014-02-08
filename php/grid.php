<?php

require_once 'cell.php';

class Grid
{
    private $rows    = 10;
    private $columns = 10;
    private $cells   = array();

    /**
     * コンストラクタ
     */
    public function __construct($rows=10, $columns=10)
    {
        $this->init($rows, $columns);
    }

    /**
     * 初期化
     */
    public function init($rows=10, $columns=10)
    {
        $this->rows    = $rows;
        $this->columns = $columns;

        $this->cells = array();
        for ($i = 0; $i < $this->rows; ++$i) {
            $tmp = array();
            for ($j = 0; $j < $this->columns; ++$j) {
                $tmp[] = new Cell();
            }
            $this->cells[] = $tmp;
        }
    }

    /**
     * コピー
     */
    public function copySelf(Grid &$o)
    {
        if (($this->rows != $o->getRows()) || ($this->columns != $o->getColumns())) {
            throw new Exception('Invalid Argument.');
        }

        for ($i = 0; $i < $this->rows; ++$i) {
            for ($j = 0; $j < $this->columns; ++$j) {
                $cell = $this->atRowAndColumn($i, $j);
                $o->atRowAndColumn($i, $j)->setValue($cell->isAlive($i, $j));
            }
        }
    }

    /**
     * 生存しているか
     */
    public function isAlive($row, $column)
    {
        $cell = $this->atRowAndColumn($row, $column);
        return $cell->isAlive();
    }

    /**
     * 誕生させる
     */
    public function bear($row, $column)
    {
        $cell = $this->atRowAndColumn($row, $column);
        return $cell->setValue(true);
    }

    /**
     * 死滅させる
     */
    public function kill($row, $column)
    {
        $cell = $this->atRowAndColumn($row, $column);
        return $cell->setValue(false);
    }

    /**
     * 切り替え
     */
    public function toggle($row, $column)
    {
        $cell = $this->atRowAndColumn($row, $column);
        return $cell->toggleValue();
    }

    /**
     * クリア
     */
    public function clearAll()
    {
        for ($i = 0; $i < $this->rows; ++$i) {
            for ($j = 0; $j < $this->columns; ++$j) {
                $cell = $this->atRowAndColumn($i, $j);
                $cell->setValue(false);
            }
        }
    }

    /**
     * 周囲の生存しているセルを数える
     */
    public function totalNeighbours($row, $column)
    {
        $result = 0;

        // NW
        if ($row > 0 && $column > 0 && $this->isAlive($row-1, $column-1)) {
            ++$result;
        }
        // N
        if ($row > 0 && $this->isAlive($row-1, $column)) {
            ++$result;
        }
        // NE
        if ($row > 0 && $column < $this->columns-1 && $this->isAlive($row-1, $column+1)) {
            ++$result;
        }
        // W
        if ($column > 0 && $this->isAlive($row, $column-1)) {
            ++$result;
        }
        // E
        if ($column < $this->columns-1 && $this->isAlive($row, $column+1)) {
            ++$result;
        }
        // SW
        if ($row < $this->rows-1 && $column > 0 && $this->isAlive($row+1, $column-1)) {
            ++$result;
        }
        // S
        if ($row < $this->rows-1 && $this->isAlive($row+1, $column)) {
            ++$result;
        }
        // SE
        if ($row < $this->rows-1 && $column < $this->columns-1 && $this->isAlive($row+1, $column+1)) {
            ++$result;
        }

        return $result;
    }

    /**
     * 指定のセルオブジェクトを返す
     */
    private function atRowAndColumn($row, $column)
    {
        if (($row < 0) ||
            ($row > $this->rows) ||
            ($column < 0) ||
            ($column > $this->columns)) {
            throw new Exception('Invalid Argument.');
        }
        return $this->cells[$row][$column];
    }

    public function getRows()    { return $this->rows; }
    public function getColumns() { return $this->columns; }
}


