<?php

class Cell
{
    private $value = false;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * 初期化
     */
    public function init()
    {
        $this->value = false;
    }

    /**
     * 値を設定
     */
    public function setValue($v)
    {
        $this->value = $v;
    }

    /**
     * 生存しているか
     */
    public function isAlive()
    {
        return $this->value;
    }

    /**
     * 切り替え
     */
    public function toggleValue()
    {
        $this->value = !$this->value;
    }
}


