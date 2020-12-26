<?php

use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

for($i=0;$i<500;$i++){
    $user_hash = \Illuminate\Support\Facades\Hash::make('123');
    echo "hashed " . $user_hash . "\n";
    echo "<br>";
}
//$db_hash = auth()->user()->password;
//echo "db has ". $db_hash . "\n";
//echo "<br>";
//echo "hashed " . $user_hash . "\n";
//echo "<br>";
//if(Hash::check('123',$user_hash)) {
//   echo "match 1";
//    echo "<br>";
//}else{
//    echo "unmatch";
//}
//
//if(Hash::check('123',$db_hash)) {
//    echo "match 2";
//    echo "<br>";
//}else{
//    echo "unmatch";
//}
//if(Hash::check($user_hash,$db_hash)) {
//    echo "match 2";
//    echo "<br>";
//}else{
//    echo "unmatch";
//}

