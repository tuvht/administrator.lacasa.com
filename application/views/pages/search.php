<?php
if (empty($list))
{
	echo 'Products not found';
}
else
{
	echo '<pre>';
	print_r($list);
	echo '</pre>';
}
?>