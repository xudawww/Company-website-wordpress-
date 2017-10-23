 <?php
 $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT);
    $from   = filter_input(INPUT_POST, 'from', FILTER_SANITIZE_SPECIAL_CHARS);
    $to     = filter_input(INPUT_POST, 'to', FILTER_SANITIZE_SPECIAL_CHARS);
     
    // building a parameter string for the query
    $encoded_string = urlencode($amount) . urlencode($from) . '%3D%3F' . urlencode($to);
     
    $url = 'http://www.google.com/ig/calculator?hl=en&amp;amp;q=' . $encoded_string;
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
 
    $results = curl_exec($ch);
     
     
    // this is json_decode function if you are having PHP < 5.2.0
    // taken from php.net
    $comment = false;
    $out = '$x=';
    
    for ($i=0; $i<strlen($results); $i++)
    {
        if (!$comment)
        {
            if ($results[$i] == '{')            $out .= ' array(';
            else if ($results[$i] == '}')       $out .= ')';
            else if ($results[$i] == ':')       $out .= '=>';
            else                                $out .= $results[$i];           
        }
        else $out .= $results[$i];
        if ($results[$i] == '"')    $comment = !$comment;
    }
    // building an $x variable which contains decoded array
    echo eval($out . ';');
     
    echo $x['lhs'] . ' = ' . $x['rhs'];
	?>