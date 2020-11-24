<?php
/*
Password haveibeenpwned verification with k-Anonymity model
https://haveibeenpwned.com/API/v3#SearchingPwnedPasswordsByRange
(echo -n "Password: "; read pw; curl -s https://api.pwnedpasswords.com/range/$(echo -n $pw | shasum | cut -b 1-5) | grep $(echo -n $pw | shasum | cut -b 6-40 | tr /a-f/ /A-F/)) 
*/
	$pwd = "forever1";
	$sha1pwd = strtoupper(sha1($pwd));
        $sha1_5char = substr($sha1pwd, 0, 5);

        $ch = curl_init("https://api.pwnedpasswords.com/range/$sha1_5char");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $returndata = curl_exec ($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $returndata) as $line){
                if ( $sha1_5char.substr( $line ,0 ,40-5 ) == $sha1pwd)
                {
                        echo $line . "\n";
                        $score=explode(":", $line)[1];
                        if($score > 10)
                        {
                                echo "You can not use this password! [leaked pwd: $score]";
                                exit();
                        }
                }

        }
        echo "ok";
?>
