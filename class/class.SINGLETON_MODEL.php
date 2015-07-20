<?php
    class SINGLETON_MODEL
    {
        private static $arrInstances = array();
        private function __construct() {}

        public static function getInstance($strClassName)
        {
            $strClassNameKey = strtolower($strClassName);
            if (!array_key_exists($strClassNameKey, self::$arrInstances))
            { 
                self::$arrInstances[$strClassNameKey] = new $strClassName;
            }
            return self::$arrInstances[$strClassNameKey];
        }
    }
?>