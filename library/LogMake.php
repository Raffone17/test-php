<?php

class LogMake
{
    protected $file;


    public function __construct($file)
    {
        $this->file = $file;
    }


    public function logError($text)
    {
        $text = '['.date('Y-m-d H:i:s').'] Error: '.$text;

        if (file_put_contents($this->file, $text."\n", FILE_APPEND | LOCK_EX)) {
            return true;
        } else {
            return false;
        }
    }

    public function logWarning($text)
    {
        $text = '['.date('Y-m-d H:i:s').'] Warning: '.$text;

        if (file_put_contents($this->file, $text . "\n", FILE_APPEND | LOCK_EX)) {
            return true;
        } else {
            return false;
        }
    }
}
