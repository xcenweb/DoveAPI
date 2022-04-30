<?php
declare(strict_types=1);
// 将数组转为xml，只能将数组转为标准的xml
// 感谢大佬 https://github.com/jmarceli/array2xml
namespace dove\tool;
class ArrToxml
{
    public static $version = '1.0';
    public static $encoding = 'UTF-8';
    
    public static function build($data, $startElement = 'data')
    {
        $xml = new \XmlWriter();
        $xml->openMemory();
        $xml->startDocument(self::$version,self::$encoding);
        $xml->startElement($startElement);
        $data = static::writeAttr($xml,$data);
        static::writeEl($xml,$data);
        $xml->endElement();
        return $xml->outputMemory(true);
    }
    
    public static function writeAttr(\XMLWriter $xml, $data)
    {
        if (is_array($data)) {
            $nonAttributes = [];
            foreach ($data as $key => $val) {
                if ($key[0] == '@') {
                    $xml->writeAttribute(substr($key, 1), $val);
                } else if ($key[0] == '%') {
                    if (is_array($val)) $nonAttributes = $val;
                    else $xml->text($val);
                } elseif ($key[0] == '#') {
                    if (is_array($val)) $nonAttributes = $val;
                    else {
                        $xml->startElement(substr($key, 1));
                        $xml->writeCData($val);
                        $xml->endElement();
                    }
                }else if($key[0] == "!"){
                    if (is_array($val)) $nonAttributes = $val;
                    else $xml->writeCData($val);
                }
                else $nonAttributes[$key] = $val;
            }
            return $nonAttributes;
        } else return $data;
    }
    
    public static function writeEl(\XMLWriter $xml, $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value) && !static::isAssoc($value)) { //numeric array
                foreach ($value as $itemValue) {
                    if (is_array($itemValue)) {
                        $xml->startElement($key);
                        $itemValue = static::writeAttr($xml, $itemValue);
                        static::writeEl($xml, $itemValue);
                        $xml->endElement();
                    } else {
                        $itemValue = static::writeAttr($xml, $itemValue);
                        $xml->writeElement($key, "$itemValue");
                    }
                }
            } else if (is_array($value)) {
                $xml->startElement($key);
                $value = static::writeAttr($xml, $value);
                static::writeEl($xml, $value);
                $xml->endElement();
            } else {
                $value = static::writeAttr($xml, $value);
                $xml->writeElement($key, "$value");
            }
        }
    }

    public static function isAssoc($array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
}