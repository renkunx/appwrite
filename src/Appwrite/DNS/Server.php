<?php

namespace Appwrite\DNS;

use Utopia\CLI\Console;

class Server
{
    protected array $types = [
        'A' => 1,
        'NS' => 2,
        'CNAME' => 5,
        'SOA' => 6,
        'WKS' => 11,
        'PTR' => 12,
        'HINFO' => 13,
        'MX' => 15,
        'TXT' => 16,
        'RP' => 17,
        'SIG' => 24,
        'KEY' => 25,
        'LOC' => 29,
        'NXT' => 30,
        'AAAA' => 28,
        'CERT' => 37,
        'A6' => 38,
        'AXFR' => 252,
        'IXFR' => 251,
        '*' => 255
    ];

    protected Adapter $adapter;

    /**
     * 
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
   
    public function start()
    {
        $this->adapter->onPacket(function ($buf)
        {
            $domain = '';
            $tmp = substr($buf,12);
            $e = strlen($tmp);
            
            for($i=0; $i < $e; $i++) {
                $len = ord($tmp[$i]);
                if ($len == 0)
                    break;
                $domain .= substr($tmp,$i+1, $len).'.';
                $i += $len;
            }
    
            $i++;$i++; /* move two char */
           
            $queryType = array_search((string)ord($tmp[$i]), $this->types ) ;
           
            $domain = substr($domain, 0, strlen($domain)-1);
            $ips = $this->resolve($domain, $queryType);
    
            $answer = $buf[0].$buf[1].chr(129).chr(128).$buf[4].$buf[5].$buf[4].$buf[5].chr(0).chr(0).chr(0).chr(0);
            $answer .= $tmp;
            $answer .= chr(192).chr(12);
            $answer .= chr(0).chr(1).chr(0).chr(1).chr(0).chr(0).chr(0).chr(60).chr(0).chr(4);
            $answer .= $this->encode($ips);
    
            return $answer;
        });
        $this->adapter->start();
    }

    /**
     * Resolve domain name to IP by record type
     * 
     * @param string $domain
     * @param string $type
     * 
     * @return string
     */
    protected function resolve(string $domain, string $type): string
    {
        Console::log('Domain: '.$domain.', Type: '.$type);
        return '127.0.0.1';
    }
   
    /**
     * Encode string to bytes
     * 
     * @param string $ip
     * 
     * @return string
     */
    protected function encode(string $string): string
    {
        $result = '';

        foreach(explode('.', $string) as $part) {
            $result .= chr((int)$part);
        }

        return $result;
    }
}