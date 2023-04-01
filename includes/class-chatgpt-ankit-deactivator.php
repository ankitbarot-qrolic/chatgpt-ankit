<?php


Class Chatgpt_Ankit_Deactivator
{
    public static function deactivate(){
        // echo "The theme is Deactivated Successfully...";

        // Flush Rewrite Rules
        flush_rewrite_rules();
   
    }
}