<?php

namespace PodwysockiCMS\AdminBundle\Helpers;

class LinkValidator 
{
    private $link;
    
    public function __construct($link)
    {
        $this->link = $this->validateLink($link);

    }
    
    public function validateLink($link)
    {
         $patterns = array(
            ' ' => '-',
            'ą' => 'a',
            'ę' => 'e',
            'ł' => 'l',
            'ś' => 's',
            'ź' => 'z',
            'ż' => 'z',
            'ć' => 'c',
            'ń' => 'n',
            'ó' => 'o',
            '/' => '');
        
        
        $newLink = strtolower(str_replace(array_keys($patterns),  array_values($patterns),$link));
        
        $fullLink = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $newLink;
        
        if(!filter_var($fullLink,FILTER_VALIDATE_URL)) {
            throw new \Exception('URL "' . $fullLink . '" is not valid! Please enter valid URL or fill base in PodwysockiCMS\AdminBundle\Helpers\LinkValidator.');
        }
       
        
        return $newLink;
    }
    
    public function getLink()
    {
        return $this->link;
    }
}
