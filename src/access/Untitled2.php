<?php

  $item=array();
  $item['lan']=1;
  $item['lon']=2;
  $item['zoom']=3;
  serialize($item);
echo  unserialize($item);

?>