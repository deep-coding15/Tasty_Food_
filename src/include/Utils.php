<?php

class Utils{
    public function redirect(string $path){
        header("Location: " . $path);
        exit;
    }
}