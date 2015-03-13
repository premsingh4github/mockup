<?php
if(!function_exists('displayArr')){

	function displayArr($array){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}
if(!function_exists('test')){
	function test(){
		echo "test";
	}
}