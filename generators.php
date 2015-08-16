<?php

foreach(hash_algos() as  $hash)
{
    echo '<br/>'.$hash."=".hash($hash,"B@st@rd0ul1s@1992!",false).'<br/>';
}

?>

